<?php


use v2\Shop\Shop;
use  v2\Models\Broker;
use  v2\Models\TradingAccount;
use  v2\Models\FinancialBank;
use  v2\Models\DepositOrder;
use  Filters\Filters\DepositOrderFilter;
use  Filters\Filters\WithdrawalFilter;
use  v2\Models\Withdrawal;
use  Filters\Filters\SupportTicketFilter;
use  Filters\Filters\TradingAccountFilter;
use Illuminate\Database\Capsule\Manager as DB;


/**
 * this class is the default controller of our application,
 * 
*/
class UserController extends controller
{


	public function __construct(){

		// if (! $this->admin()) {

			$this->middleware('current_user')
				->mustbe_loggedin()
				->must_have_verified_email()
				;
		// }		
	}
	
	

	public function supportmessages($value='')
	{
		$this->view('auth/support-messages');
	}






	public function instructor()
	{

		$this->view('auth/instructor-dashboard');
	}


	public function preview_post($post_id)
	{
		$post =  Post::where('id',$post_id)
		                  ->where('user_id', $this->auth()->id)
		                  ->first();

			if ($post == null) {
				Redirect::back();
			}

		$this->view('guest/single-post', compact('post'));  //note this is
	}




	public function blogger()
	{
		$this->view('auth/blogger-dashboard');

	}


	public function courses()
	{

		$this->view('auth/courses');
	}

	public function notifications($notification_id = 'all')
	{
		switch ($notification_id) {
			case 'all':
			$notifications = Notifications::all_notifications($this->auth()->id);

				break;
			
			default:
			

			$notifications = Notifications::where('user_id', $this->auth()->id)->where('id', $notification_id)->first();

			Notifications::mark_as_seen([$notifications->id]);


			if ($notifications == null) {
				Session::putFlash("danger", "Invalid Request");
				Redirect::back();
			}



			if ($notifications->DefaultUrl != $notifications->UsefulUrl) {

				Redirect::to($notifications->UsefulUrl);
			}



				break;
		}



		$this->view('auth/notifications', compact('notifications'));
	}



	public function company()
	{
		$company = $this->auth()->company;
		$this->view('auth/company', compact('company'));
	}


	public function order($order_id=null)
	{

		$order  =  Orders::where('id', $order_id)->where('user_id', $this->auth()->id)->first();


		$this->view('auth/order_detail', compact('order'));
	}

	


	public function products_orders()
	{
		$this->view('auth/products_orders');
	}




	public function cart()
	{
		$shop = new Shop;

		$cart = json_decode($_SESSION['cart'], true)['$items'];

		if (count($cart) == 0) {
			Session::putFlash("info","Your cart is empty.");
			Redirect::to('shop');
		}
		
    	$this->view('auth/cart', compact('shop'));
	}



	public function create_upgrade_request($subscription_id=null)
	{



		$subscription_id = $_POST['subscription_id'];
		
		$response = SubscriptionPlan::create_subscription_request($subscription_id, $this->auth()->id);


			header("content-type:application/json");
			echo $response;

		// Redirect::back();
	}

	public function subscription_orders()
	{
			$this->view('auth/subscription_orders');
	}


	public function package()
	{
			$this->view('auth/package');
	}


 	public function update_testimonial()
    {

    	echo "<pre>";
    	$testimony_id = Input::get('testimony_id');
     	$testimony = Testimonials::find($testimony_id);

    	$attester =  $this->auth()->lastname.' '. $this->auth()->firstname;


    	$testimony->update([
    						 'attester' =>$attester,
							  'user_id'	 => $this->auth()->id, 
							  'content'  =>Input::get('testimony'),
							  'approval_status' => 0 
							]);


    	Session::putFlash('success','Testimonial updated successfully. Awaiting approval');

    	Redirect::back();
    }



	public function create_testimonial()
    {
    	if (Input::exists() || true) {

    		$auth = $this->auth();

	    	$testimony = Testimonials::create([
	    						'attester' => $auth->lastname.' '. $auth->firstname,
								  'user_id'	 => $auth->id, 
								  'content'  =>Input::get('testimony')]);

    	}
    	Redirect::to("user/edit_testimony/{$testimony->id}");
    }



	public function edit_testimony($testimony_id =null)
	{
		if (($testimony_id != null)  ) {
		$testimony = Testimonials::find($testimony_id);
			if (($testimony != null) && ($testimony->user_id == $this->auth()->id)) {

						$this->view('auth/edit_testimony', ['testimony'=>$testimony ]);
						return;
			}else{
				Session::putFlash('danger','Invalid Request');
				Redirect::back();
			}

		}

	}

	public function notify_deposit($deposit_id)
	{

		$deposit_id = MIS::dec_enc('decrypt', $deposit_id);
		$deposit = depositorder::where('id', $deposit_id)->where('user_id', $this->auth()->id)->first();

		if ($deposit == null) {

			Session::putFlash('danger','Invalid Request');
			Redirect::back();
		}

		if (! in_array($deposit->status, ['initialized'])) {

			Session::putFlash('info','Your deposit is currently being treated. You will be notified through your email.');
			Redirect::back();
		}

		DB::beginTransaction();


		try {

			$deposit->update(['status' => 'pending']);

			
			DB::commit();	
			Session::putFlash('success', "Notification Successful. Your Deposit will be treated.");
		} catch (Exception $e) {
			DB::rollback();	
			Session::putFlash('danger', "Something went wrong.");
			
		}


		$admin_content = "
					<p><strong>NOTICE</strong></p>

					<p>A deposit notification of $deposit->amount$ by {$deposit->user->fullname} </p>

				<p>Please <a href='$domain/login/admin_login'>login </a>to confirm.</p>
		";


		$settings = SiteSettings::site_settings();
		$noreply_email = $settings['noreply_email'];
		$support_email = $settings['support_email'];
		$notification_email = $settings['notification_email'];



		$subject = "Notification Deposit - $project_name";
		$mailer = new Mailer;

		$admin_content = MIS::compile_email($admin_content);
		
		$domain = Config::domain();
		$project_name = Config::project_name();

		Shop::empty_cart_in_session();


		//ADMIN
		$mailer->sendMail(
		    $notification_email,
			"$subject",
		    $admin_content,
		    "$project_name",
		    "$support_email",
		    "$project_name"
		);

		Redirect::back();

	}


	public function view_testimony()
	{
		$this->view('auth/view-testimony');
	}



	public function testimony()
	{
		$this->view('auth/testimony');
	}




	public function news()
	{
		$this->view('auth/news');
	}




	public function profile()
	{

    	$this->view('auth/profile');
	}




	public function contact_us()
	{
		$this->view('auth/contact-us');

	}

	public function support()
	{
		$auth = $this->auth();

		$sieve = $_REQUEST;
		$sieve = array_merge($sieve);

		$query = SupportTicket::where('user_id', $auth->id)->latest();
		// ->where('status', 1);  //in review
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 20;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  SupportTicketFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$tickets =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered


		$this->view('auth/support', compact('tickets', 'sieve', 'data','per_page'));

	}

	public function view_ticket($ticket_id){

	 	$support_ticket = SupportTicket::find($ticket_id); 

		$this->view('auth/support-messages', [
					'support_ticket'			=> $support_ticket 
									]);  


	}



	public function index()
	{
		$this->view('auth/dashboard');
	}


	public function open_trading_account($broker_id =1)
	{	
		$broker = Broker::where('id', $broker_id)->first();
		if ($broker == null) {
			Session::putFlash('danger',"Invalid Request");
			Redirect::back();
		}

		$account_opening_page = $broker->getAccountOpeningPage();

		Redirect::to($broker->DetailsArray['open_account']);


		// $this->view("auth/account_opening_page", compact('broker'));
	}

	public function make_deposit($account_number='', $broker_id= '')
	{
		$shop = new Shop;

		$this->view("auth/making_deposit", compact('shop','account_number', 'broker_id'));
	}


	public function make_withdrawal($account_number='', $broker_id= '')
	{
		$shop = new Shop;

		$this->view("auth/making_withdrawal", compact('shop','account_number', 'broker_id'));
	}



	public function deposit_history()
	{
			
		$auth = $this->auth();


		$sieve = $_REQUEST;
		$sieve = array_merge($sieve);

		$query = DepositOrder::where('user_id', $auth->id)->latest();
		// ->where('status', 1);  //in review
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  DepositOrderFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$deposits =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered


		$shop = new Shop;

		$this->view('auth/deposit-history', compact('deposits','shop', 'sieve', 'data','per_page'));

	}

	public function withdrawal_history()
	{
			
		$auth = $this->auth();

		$sieve = $_REQUEST;
		$sieve = array_merge($sieve);

		$query = Withdrawal::where('user_id', $auth->id)->latest();
		// ->where('status', 1);  //in review
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  WithdrawalFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$withdrawals =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered


		$shop = new Shop;

		$this->view("auth/withdrawal-history", compact('withdrawals','shop', 'sieve', 'data','per_page'));
	}


	public function deposit_withdrawal()
	{
			
		$auth = $this->auth();
		$deposits = DepositOrder::where('user_id', $auth->id)->latest()->get();

		$this->view("auth/deposit-withdrawal", compact('deposits'));
	}


	public function bank_transfer($order_id, $type)
	{
		$auth = $this->auth();
		$register = [
			'deposit' => [
				'class' => 'v2\Models\DepositOrder' ,
			],
			'course' => [
				'class' => 'Orders' ,
			],
		];



		$class = $register[$type]['class'];

		switch ($type) {
			case 'deposit':


					 $order = $class::where('id', $order_id)
					 							->where('payment_method', 'bank_transfer')
												 ->where('status','initialized')
												 ->where('user_id', $auth->id)
												 ->where('paid_at', null)->first();


			case 'course':


					 $order = $class::where('id', $order_id)
					 						->where('payment_method', 'bank_transfer')
												 ->where('user_id', $auth->id)
												 ->where('paid_at', null)->first();


				break;
			
			default:
				# code...
				break;
		}

		if ($order==null) {
			// Session::putFlash('danger','Invalid Request');
			Redirect::back();
		}

		Shop::empty_cart_in_session();

		$this->view('auth/deposit_bank_transfer', compact('order','type'));

	}


	public function show_invoice($order_id, $type)
	{

		$auth = $this->auth();
		$register = [
			'deposit' => [
				'class' => 'v2\Models\DepositOrder' ,
			],
			'course' => [
				'class' => 'Orders' ,
			],
		];

		$class = $register[$type]['class'];


		switch ($type) {
			case 'deposit':


					 $order = $class::where('id', $order_id)
					 // ->where('payment_method', 'bank_transfer')
												 ->where('status','initialized')
												 ->where('user_id', $auth->id)
												 ->where('paid_at', null)->first();


			case 'course':


					 $order = $class::where('id', $order_id)
					 // ->where('payment_method', 'bank_transfer')
												 ->where('user_id', $auth->id)
												 ->where('paid_at', null)->first();


				break;
			
			default:
				# code...
				break;
		}


		if ($order==null) {
			// Session::putFlash('danger','Invalid Request');
			Redirect::back();
		}

		Shop::empty_cart_in_session();

		// $invoice = 
		// $invoice = 
		$order->getInvoice();


	}

	


	public function confirm_deposit($deposit_id)
	{

		$shop = new Shop;
		$auth = $this->auth();

		$deposit = DepositOrder::where('id', $deposit_id)->where('user_id', $auth->id)->where('paid_at', null)->where('status', 'initialized')->first();

		if ($deposit==null) {
			// Session::putFlash('danger','Invalid Request');
			Redirect::to('user/make_deposit');
		}

				$payment_details =	$shop
									// ->setOrderType('order') //what is being bought
									->setOrder($deposit)
									->setPaymentMethod($deposit->payment_method)
									->initializePayment()
									->attemptPayment()
									;

					$breakdown = 	$shop->fetchPaymentBreakdown();
		$this->view('auth/confirm_deposit', compact('shop', 'deposit', 'breakdown'));
	}


	public function confirm_withdrawal($withdrawal_id)
	{

		$shop = new Shop;
		$auth = $this->auth();

		$withdrawal = Withdrawal::where('id', $withdrawal_id)->where('user_id', $auth->id)->where('status', 1)->first();

		if ($withdrawal==null) {

			// Session::putFlash('danger','Invalid Request');
			Redirect::to('user/make_withdrawal');
		}

		$breakdown = 	$withdrawal->fetchBreakdown();
		$this->view('auth/confirm_withdrawal', compact('shop', 'withdrawal', 'breakdown'));
	}

	

	public function password()
	{
		$this->view('auth/password');
	}


	public function dashboard()
	{

		$this->view('auth/dashboard');
		// Redirect::to("user/profile");

	}

	public function broadcast()
	{
		$this->view('auth/broadcast');

	}


	public function bank_account()
	{
		$this->view('auth/bank-account');

	}

	public function all_trading_accounts()
	{


		$auth = $this->auth();

		$sieve = $_REQUEST;
		$sieve = array_merge($sieve);

		$query = TradingAccount::where('user_id', $auth->id)->latest();
		// ->where('status', 1);  //in review
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  TradingAccountFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$trading_accounts =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered



		$this->view('auth/all-trading-accounts', compact('trading_accounts', 'sieve', 'data','per_page'));

	}

	public function verification()
	{
		$this->view('auth/verification');

	}








}























?>