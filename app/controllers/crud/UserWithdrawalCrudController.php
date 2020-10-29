<?php
use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\UserBank;
use v2\Models\DepositOrder;
use v2\Models\Withdrawal;
use v2\Models\TradingAccount;
use  v2\Shop\Shop;
use v2\Models\AdminComment;


/**
 * 
*/
class UserWithdrawalCrudController extends controller
{


	public function __construct(){
	}



	public function push_to_state()
	{
		$doc_id = $_POST['doc_id'];
		$state = $_POST['status'];
		$comment = $_POST['comment'];

		$doc_id = MIS::dec_enc('decrypt', $doc_id);

		$doc = Withdrawal::find($doc_id);


		if (($doc == null)) {
			Session::putFlash('danger','File Not Found');
			Redirect::back();
		}

		DB::beginTransaction();	
		try {

			AdminComment::create([
				'admin_id' => $this->admin()->id,
				'model' => 'withdrawal',
				'model_id' => $doc->id,
				'comment' => $comment,
				'status' => $state						
			]);


			$doc->update([
				'status'=> $state
			]);

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




	public function sendNotification($withdrawal_id=null, $reason=null)
	{


		$withdrawal = Withdrawal::find($withdrawal_id);
		$domain = Config::domain();
		$project_name = Config::project_name();

		$reverse_calculation = $withdrawal->fetchBreakdown()['line'];


		switch ($withdrawal->status) {
			case 4:

				$content = "Dear {$withdrawal->user->firstname},
							<p>Your withdrawal order as been processed. 
							A sum of NGN$withdrawal->amount_payable as been deposited into your bank  account:</p>

							<p>Transaction ID: <strong>$withdrawal->trans_id</strong></p>
							<p>From:</p>
							<p>Broker:{$withdrawal->broker->name}</p>
							<p>Trading Account: {$withdrawal->account_number} </p>
							<p>To:</p>
							<p>Bank: {$withdrawal->bank->financial_bank->bank_name} </p>
							<p>Account Number: {$withdrawal->bank->account_number} </p>

							
							<p>&nbsp;</p>

							<table class='table table-striped'>
							<caption><small> Breakdown: </small></caption>
							  
							    <tbody id='payment_breakdown'>

									{$reverse_calculation}
							    </tbody>
							</table>

							<p>&nbsp;</p>
							<p>You can <a href='{$withdrawal->broker->ClientCabinet}'>log in </a>to your client cabinet confirm.</p>

							<p>Thank you for choosing to do business with us.</p>
							
							<p>&nbsp;</p>

							";

				$admin_content = "
							<p><strong>NOTICE</strong></p>

							<p>A withdrawal of $withdrawal->amount$ for {$withdrawal->user->fullname} as been completed by {$withdrawal->admin->fullname}</p>
							<p>A sum of NGN$withdrawal->amount_payable has been paid</p>

						<p>Please <a href='$domain/login/admin_login'>login </a>to confirm.</p>
				";

				break;


			case 5:
			$comment = 		$withdrawal->adminComments()->where('status','declined')->last()->comment;

			$content = "Dear {$withdrawal->user->firstname},
						<p>Your withdrawal order as been declined.</p>

						<p>Order ID: <strong>$withdrawal->trans_id</strong></p>
						<p>Broker:{$withdrawal->broker->name}</p>

						<p>Trading Account: {$withdrawal->trading_account->account_number} </p>
						<p>Bank: {$withdrawal->bank->financial_bank->bank_name} </p>
						<p>Account Number: {$withdrawal->bank->account_number} </p>


						<p>&nbsp;</p>
						Comment: $comment

						
						<p>Thank you for choosing to do business with us.</p>
						
						<p>&nbsp;</p>

						";


				$admin_content = "
							<p><strong>NOTICE</strong></p>

							<p>A withdrawal of $withdrawal->amount$ for {$withdrawal->user->fullname} as been declined by {$withdrawal->admin->fullname}</p>

						<p>Please <a href='$domain/login/admin_login'>login </a>to confirm.</p>
				";

				break;


			
			default:
			
			return;

				break;
		}


		$settings = SiteSettings::site_settings();
		$noreply_email = $settings['noreply_email'];
		$support_email = $settings['support_email'];
		$notification_email = $settings['notification_email'];



		$subject = "Notification withdrawal - $project_name";
		$mailer = new Mailer;

		$content = MIS::compile_email($content);
		$admin_content = MIS::compile_email($admin_content);


		//client
		$mailer->sendMail(
		    "{$withdrawal->user->email}",
			"$subject",
		    $content,
		    "{$withdrawal->user->firstname}",
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






	public function complete_order()
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


		echo "<pre>";
		print_r($_POST);

		// return;

		$usd_amount = $_POST['amount'];

		DB::beginTransaction();

		try {

			$trading_account = TradingAccount::where('account_number', $_POST['account_number'])->where('user_id', $auth->id)->first();

			if ($trading_account == null) {
				TradingAccount::create([
					'account_number'=> $_POST['account_number'],
					'broker_id'=> $_POST['broker_id'],
					'user_id'=> $auth->id,
					'active_status'=> 1,
				]);
			}


				//ensure account is active
			if (! $trading_account->is_active()) {
				Session::putFlash('danger','You cannot make withdrawal on this account because it is currently blocked. contact support');
				Redirect::back();
			}


			$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;
			$exchange = $setting['withdraw_at'];


			$amount_payable = $exchange * $_POST['amount'];

			$new_order =  Withdrawal::updateOrCreate([
				'id' => $_SESSION['shop_checkout_id']
			],
			[

				'account_number' => $_POST['account_number'],
				'broker_id'  => $_POST['broker_id'],
				'bank_account_id'  => $_POST['bank_account_id'],
				'amount'  => $_POST['amount'],
				'user_id'		 => $auth->id,
				'status'		 => 1,
				'amount_payable' => $amount_payable,
			]);

			$new_order->update([
				'trans_id' => $new_order->generateOrderID()
			]);

			$_SESSION['shop_checkout_id'] = $new_order->id;
			DB::commit();


			//notify admin

			$admin_content = "
						<p><strong>NOTICE</strong></p>

						<p>A withdrawal of $new_order->amount$ / NGN$new_order->amount_payable for {$new_order->user->fullname} as been requested. </p>

					<p>Please <a href='$domain/login/admin_login'>login </a>to confirm.</p>
			";

			$domain = Config::domain();
			$project_name = Config::project_name();

			$settings = SiteSettings::site_settings();
			$noreply_email = $settings['noreply_email'];
			$support_email = $settings['support_email'];
			$notification_email = $settings['notification_email'];



			$subject = "Notification Withdrawal - $project_name";
			$mailer = new Mailer;
			
			$admin_content = MIS::compile_email($admin_content);

			//ADMIN
			$mailer->sendMail(
			    $notification_email,
				"$subject",
			    $admin_content,
			    "$project_name",
			    "$support_email",
			    "$project_name"
			);




			Redirect::to("user/confirm_withdrawal/{$new_order->id}");


		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
			Session::putFlash("danger","Something went wrong");
		}

		Redirect::back();
	}


	public function confirm_order()
	{

		$auth = $this->auth();	
		$withdrawal_id = $_POST['withdrawal_id'];

		$withdrawal = Withdrawal::where('id', $withdrawal_id)->where('user_id', $auth->id)->where('status', 1)->first();

		if ($withdrawal==null) {
			Session::putFlash('danger','Invalid Request');
			return;
		}



		DB::beginTransaction();

		try {
			$withdrawal->setBreakdown();
			$withdrawal->update(['status' => 2]);

			unset($_SESSION['shop_checkout_id']);
			DB::commit();

			Session::putFlash("success","Withdrawal submitted successfully");
		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
			Session::putFlash("danger","Something went wrong");
		}


		Redirect::to('user/make-withdrawal');
	}




}























?>