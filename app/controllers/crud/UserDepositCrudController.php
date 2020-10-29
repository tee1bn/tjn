<?php
use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\UserBank;
use v2\Models\DepositOrder;
use v2\Models\AdminComment;
use v2\Models\TradingAccount;
use  v2\Shop\Shop;


/**
 * 
*/
class UserDepositCrudController extends controller
{


	public function __construct(){
	}


	public function push_to_state()
	{
		$doc_id = $_POST['doc_id'];
		$state = $_POST['status'];
		$comment = $_POST['comment'];

		$doc_id = MIS::dec_enc('decrypt', $doc_id);

		$doc = DepositOrder::find($doc_id);

		if (($doc == null)) {
			Session::putFlash('danger','File Not Found');
			Redirect::back();
		}

		DB::beginTransaction();	
		try {

			AdminComment::create([
						'admin_id' => $this->admin()->id,
						'model' => 'deposit',
						'model_id' => $doc->id,
						'comment' => $comment,
						'status' => $state						
			]);


			$reverse_calculation = $doc->doReverseCalculation($_POST['amount_confirmed']);
			$amount_to_fund = round($reverse_calculation['dollar_value'] , 2);

			$doc->update([
						'status'=> $state,
					]);

				if ($doc->is_confirmed()) {


					$doc->update([
						'status'=> $state,
						'amount_confirmed'=> $_POST['amount_confirmed'],
						'amount_to_fund'=> $amount_to_fund,
						'paid_at' => date("Y-m-d H:i:s")
					]);
				}

			DB::commit();	
			$this->sendNotification($doc->id);
			
			Session::putFlash('success','Changes saved successfully');
		} catch (Exception $e) {
			DB::rollback();	
			print_r($e->getMessage());
			Session::putFlash('danger','Something went wrong');
		}

		Redirect::back();
	}


	public function sendNotification($deposit_id=null, $reason=null)
	{


		$deposit = DepositOrder::find($deposit_id);
		$domain = Config::domain();
		$project_name = Config::project_name();

		$reverse_calculation = $deposit->doReverseCalculation($deposit->amount_confirmed);
		$view = $this->buildView('composed/deposit_reverse_calculation', compact('reverse_calculation') );

		switch ($deposit->status) {
			case 'completed':

				$content = "Dear {$deposit->user->firstname},
							<p>Your Deposit order as been processed. A sum of $deposit->amount_to_fund$ as been deposited into your account:</p>

							<p>Order ID: <strong>$deposit->TransactionID</strong></p>
							<p>Broker:{$deposit->broker->name}</p>

							<p>Account number: {$deposit->trading_account->account_number} </p>

							<p>&nbsp;</p>

							<table class='table table-striped'>
							<caption><small> Breakdown: </small></caption>
							  
							    <tbody id='payment_breakdown'>

									{$view}
							    </tbody>
							</table>

							<p>&nbsp;</p>
							<p>Please <a href='{$deposit->broker->ClientCabinet}'>log in </a>to your client cabinet to confirm.</p>

							<p>Thank you for choosing to do business with us.</p>
							
							<p>&nbsp;</p>

							";

				$admin_content = "
							<p><strong>NOTICE</strong></p>

							<p>A Deposit of $deposit->amount$ for {$deposit->user->fullname} as been completed by {$deposit->admin->fullname}</p>

						<p>Please <a href='$domain/login/admin_login'>login </a>to confirm.</p>
				";

				break;


			case 'declined':
			$comment = 		$deposit->adminComments()->where('status','declined')->last()->comment;

			$content = "Dear {$deposit->user->firstname},
						<p>Your Deposit order as been declined.</p>

						<p>Order ID: <strong>$deposit->TransactionID</strong></p>
						<p>Broker:{$deposit->broker->name}</p>

						<p>Account number: {$deposit->trading_account->account_number} </p>

						<p>&nbsp;</p>
						Comment: $comment

						
						<p>Thank you for choosing to do business with us.</p>
						
						<p>&nbsp;</p>

						";


				$admin_content = "
							<p><strong>NOTICE</strong></p>

							<p>A Deposit of $deposit->amount$ for {$deposit->user->fullname} as been declined by {$deposit->admin->fullname}</p>

						<p>Please <a href='$domain/login/admin_login'>login </a>to confirm.</p>
				";

				break;


			
			default:
				# code...
				break;
		}

		if (!in_array($deposit->status, ['declined','completed'])) {
			return;
		}

		$settings = SiteSettings::site_settings();
		$noreply_email = $settings['noreply_email'];
		$support_email = $settings['support_email'];
		$notification_email = $settings['notification_email'];



		$subject = "Notification Deposit - $project_name";
		$mailer = new Mailer;

		$content = MIS::compile_email($content);
		$admin_content = MIS::compile_email($admin_content);

		//client
		$mailer->sendMail(
		    "{$deposit->user->email}",
			"$subject",
		    $content,
		    "{$deposit->user->firstname}",
		    "{$support_email}",
		    "$project_name"
		);



		//ADMIN
		$mailer->sendMail(
		    $notification_email,
			"$subject",
		    $admin_content,
		    "$project_name",
		    "$support_email",
		    "$project_name"
		);
	}


	public function complete_order($action='get_breakdown')
	{

		$auth = $this->auth();	
		$currency = Config::currency();
		$domain = Config::domain();
		$link = "<a href='$domain/user/verification'>verification</a> ";
		//ensure user is verified
		if (! $auth->has_verified_profile()) {
			Session::putFlash("danger", "Please complete your $link to avoid {$currency}200,000 limit on your deposits and withdrawals");
			// Redirect::to("user/verification");
		}


		$usd_amount = $_POST['amount'];

		DB::beginTransaction();

		try {
				$trading_account = TradingAccount::where('account_number', $_POST['account_number'])->first();

				if ($trading_account == null) {
					$trading_account  = TradingAccount::create([
						'account_number'=> $_POST['account_number'],
						'broker_id'=> $_POST['broker_id'],
						'user_id'=> $auth->id,
						'active_status'=> 1,
					]);
				}

				//ensure account is active
				if (!$trading_account->is_active()) {
					Session::putFlash('danger','You cannot make deposit on this account because it is currently blocked. contact support');
					Redirect::back();
				}


				$new_order =  DepositOrder::updateOrCreate(
														[
															'id' => $_SESSION['shop_checkout_id']
														],
														[

																'account_number' => $_POST['account_number'],
																'broker_id'  => $_POST['broker_id'],
																'amount'  => $_POST['amount'],
																'user_id'		 => $auth->id,
															]
														);

				$shop = new Shop();
				$payment_details =	$shop
									// ->setOrderType('order') //what is being bought
									->setOrder($new_order)
									->setPaymentMethod('rave')
									->initializePayment()
									->attemptPayment()
									;

				DB::commit();
			$_SESSION['shop_checkout_id'] = $new_order->id;

			header("content-type:application/json");

		Redirect::to("user/confirm_deposit/{$new_order->id}");

		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
			Session::putFlash("danger","Something went wrong");
		}

	}


	public function confirm_order($deposit_id, $action='get_breakdown')
	{

		$auth = $this->auth();

		$deposit = DepositOrder::where('id', $deposit_id)->where('user_id', $auth->id)->first();

		if ($deposit==null) {
			Session::putFlash('danger','Invalid Request');
			return;
		}
			

			$shop = new Shop();
			$payment_details =	$shop
								// ->setOrderType('order') //what is being bought
								->setOrder($deposit)
								->setPaymentMethod($_REQUEST['payment_method'])
								->initializePayment()
								->attemptPayment()
								;




			header("content-type:application/json");
			switch ($action) {
				case 'get_breakdown':

					$breakdown = 	$shop->fetchPaymentBreakdown();
					echo json_encode(compact('breakdown')) ;
					break;
				
				case 'make_payment':

					Session::putFlash('success', "Order Created Successfully. ");
					echo json_encode($payment_details);
					break;
				
				case 'initialize':
					break;
				
				default:
					# code...
					break;
			}

	}




}























?>