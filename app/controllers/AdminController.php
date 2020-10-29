<?php

use  v2\Shop\Shop;
use v2\Models\UserBank;
use v2\Models\Withdrawal;
use v2\Models\UserDocument;
use v2\Models\Campaign;
use v2\Models\Offer;
use v2\Models\Market;
use v2\Models\DepositOrder;
use v2\Models\Signals;
use v2\Models\TradingAccount;
use  Filters\Filters\UserFilter;
use  Filters\Filters\PostFilter;
use  Filters\Filters\UserBankFilter;
use  Filters\Filters\MarketFilter;
use  Filters\Filters\WithdrawalFilter;
use  Filters\Filters\UserDocumentFilter;
use  Filters\Filters\TestimonialsFilter;
use  Filters\Filters\DepositOrderFilter;
use  Filters\Filters\OrderFilter;
use  Filters\Filters\SupportTicketFilter;
use  Filters\Filters\TradingAccountFilter;
use  Filters\Filters\CampaignCategoryFilter;
use  Filters\Filters\CampaignFilter;
use Illuminate\Database\Capsule\Manager as DB;



require_once "../app/controllers/crud/CategorySpoof.php";


/**
 * this class is the default controller of our application,
 * 
*/
class AdminController extends controller
{


	public function __construct(){


		$this->middleware('administrator')->mustbe_loggedin();
	}




	public function approve_testimonial($testimonial_id)
	{

	    $testimony = Testimonials::find($testimonial_id);
	    if ($testimony->approval_status) {

	        $update = $testimony->update(['approval_status' => 0]);
	        Session::putFlash('success', 'Testimonial disapproved succesfully');


	    } else {

	        $update = $testimony->update(['approval_status' => 1]);

	        Session::putFlash('success', 'Testimonial approved succesfully');

	    }


	    Redirect::back();


	}

	public function delete_testimonial($testimonial_id)
	{

	    $testimony = Testimonials::find($testimonial_id);
	    if ($testimony != null) {

	        $testimony->delete();
	        Session::putFlash('success', 'Testimonial deleted succesfully');


	    }


	    Redirect::back();
	}



	public function upload_testimonial_pic()
	{
	    $order_id = $_POST['order_id'];
	    $order = Testimonials::find($order_id);
	    $order->upload_pic($_FILES['payment_proof']);
	    Session::putFlash('success', "#$order_id Testimonial Uploaded Successfully!");
	    Redirect::back();

	}




	public function update_testimonial()
	{

	    echo "<pre>";
	    $testimony_id = Input::get('testimony_id');
	    $testimony = Testimonials::find($testimony_id);

	    $testimony->update([
	        'attester' => Input::get('attester'),
	        'content' => Input::get('testimony'),
	        'bio' => Input::get('bio'),
	    ]);


	    Session::putFlash('success', 'Testimonial updated successfully. Awaiting approval');

	    Redirect::back();
	}

	public function create_testimonial()
	{

	    if (Input::exists() || true) {

	        $testimony = Testimonials::create([
	            'attester' => Input::get('attester'),
	            'content' => Input::get('testimony')]);

	    }
	    Redirect::to("admin/edit_testimony/{$testimony->id}");
	}



	public function order_invoice($order_id=null)
	{

		$order  =  Orders::where('id', $order_id)->first();
		
		if ($order == null) {
			Redirect::back();
		}

		$order->getInvoice();
	}





	public function edit_offer($id)
	{
		$offer = Offer::find($id);
		if ($offer == null) {
			Redirect::back();
		}

		$this->view('admin/edit_offer', compact('offer'));
	}

	public function create_offer()
	{
		$offer = Offer::create([]);
		Redirect::to("admin/edit_offer/$offer->id");
	}


	public function offers()
	{
		$offers = Offer::all();
		$this->view('admin/offers', compact('offers'));
	}



	public function suspending_account($id){


		if (TradingAccount::find($id)->is_active()) {

		$update = TradingAccount::find($id)->update(['active_status' => null ]);
		Session::putFlash('success', 'Ban lifted succesfully');


		}else{

		$update = TradingAccount::find($id)->update(['active_status' => 1]);

		Session::putFlash('success', 'Trading Account Blocked succesfully');

		}


		if ($update) {	
		}else{
		Session::putFlash('flash', 'Could not Block this Trading Account');
		}


		Redirect::back();
	}

	

	public function suspending_user($user_id){


		if (User::find($user_id)->blocked_on) {

		$update = User::find($user_id)->update(['blocked_on' => null ]);
		Session::putFlash('success', 'Ban lifted succesfully');


		}else{

		$update = User::find($user_id)->update(['blocked_on' => date("Y-m-d")]);

		Session::putFlash('success', 'User Blocked succesfully');

		}


		if ($update) {	
		}else{
		Session::putFlash('flash', 'Could not Block this User');
		}


		Redirect::back();
	}



	public function edit_signal($signal_id)
	{
		$signal = Signals::find($signal_id);

		if ($signal == null) {
			Redirect::back();
		}

		
		$this->view('admin/edit_signal', compact('signal'));
	}
	


	public function signals()
	{

		$this->view('admin/signals');
	}


	private function access_course($course_id)
	{


		$course = Course::find($course_id);


		$item_on_sale =	Market::where('category', 'course')
									->where('item_id', $course_id)
									->latest()
									->OnSale()
									->first();

		if ($item_on_sale == null) {

			Session::putFlash("danger", "Denied Access! More attempts will lead to blockage of account");
			Redirect::back();
		}


		$course = $item_on_sale->good();

	 $this->view('admin/single-course', ['course' => $course, 'access' => 'granted']);
	}



	public function read($course_id=null, $chapter= 1)
	{
		// return;
		$course = Course::find($course_id);
	
			$item_on_sale =	Market::where('category', 'course')
									->where('item_id', $course_id)
									->latest()
									->OnSale()
									->first();



		if ($item_on_sale == null) {
			Session::putFlash("danger", "Denied Access More attempts will lead to blockage of account");
			Redirect::back();
		}


		$course = $item_on_sale->good();

		
		$this->view('admin/read-course', compact('course', 'chapter'));
	}


	public function courses($course_id=null, $action=null )
	{

		if ($course_id !== null) {
			$course = Course::find($course_id);



			switch ($action) {
				case 'goal':
				$this->view('admin/course-goal', compact('course'));
				return;
				break;
				
				case 'access':

				$this->access_course($course_id);

				return;
				break;

				case 'structure':
				$this->view('auth/course-structure', ['course' => $course]);
				return;
				break;
				
				case 'curriculum':
				$this->view('auth/course-curriculum', ['course' => $course]);

				return;
				break;
				
				case 'publish':
				$this->view('auth/publish-course', ['course' => $course]);
				return;
				break;
				
				case 'view':
				$this->view('guest/single-course',['course' => $course]);
				return;
				break;
				
				default:
					# code...
					break;
			}

		}

		$this->view('auth/courses');
	}

	public function client_detail($client_id)
	{
		$client_id = MIS::dec_enc('decrypt', $client_id);
		$user = User::find($client_id);

		if ($user==null) {
			Session::putFlash("danger","Client not found");
			Redirect::back();
		}


		$this->view('admin/client_detail', compact('user'));
	}

	public function edit_client_detail($client_id)
	{
		$client_id = MIS::dec_enc('decrypt', $client_id);
		$user = User::find($client_id);

		if ($user==null) {
			Session::putFlash("danger","Client not found");
			Redirect::back();
		}


		$this->view('admin/edit_client_profile', compact('user'));
	}


	public function client_comment($client_id)
	{
		$client_id = MIS::dec_enc('decrypt', $client_id);
		$user = User::find($client_id);

		if ($user==null) {
			Session::putFlash("danger","Client not found");
			Redirect::back();
		}


		$this->view('admin/client_comment', compact('user'));
	}


	


	public function all_courses()
	{
		$this->course_verification();
	}


	public function mark_course_order($value , $order_id)
	{


		$order  =  Orders::where('id', $order_id)->where('paid_at', null)->first();
		if ($order == null) {

			Session::putFlash('danger','invalid request');
			Redirect::back();
		}

			$order->mark_paid();
			Session::putFlash('success','Marked as paid ');
			Redirect::back();
	}


	private function course_orders_matters($extra_sieve=[])
	{
		$sieve = $_REQUEST;
		$sieve = array_merge($sieve, $extra_sieve);

		$query = Orders::latest();
		// ->where('status', 1);  //in review
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  OrderFilter($sieve);

		$data =  $query->Filter($filter)->count();

		CategorySpoof::register_query($query);

		$orders =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered


		$shop = new Shop;

		return compact('orders', 'sieve', 'data','per_page','shop');
	}


	public function courses_orders()
	{

		$sieve = [];
		$compact =  $this->course_orders_matters($sieve);
		extract($compact);
		$page_title = 'Course Orders';

		$this->view('admin/courses_orders', compact('orders', 'sieve', 'data','per_page','shop', 'page_title'));

	}


	public function index($value='')
	{
		# code...
	}

	public function toggle_course($course_id)
	{


		 $last_submission =  Market::where('category', 'course')
		                  ->where('item_id', $course_id)
		                  ->latest()
		                  ->first();

			if ($last_submission == null) {
				Session::putFlash("danger", "Invalid Request");
				Redirect::back();
			}


			if($last_submission->approval_status_is('approved')){

				$last_submission->decline();

				Session::putFlash("success", "Declined");

			}else{


				$last_submission->approve();
				Session::putFlash("success", "Approved");
			}



			Redirect::back();
	}


	public function toggle_blogpost($post_id)
	{
		$last_submission =  Market::where('category', 'post')
		                  ->where('item_id', $post_id)
		                  ->latest()
		                  ->first();

			if ($last_submission == null) {
				Redirect::back();
			}


			if($last_submission->approval_status_is('approved')){

				$last_submission->decline();

				Session::putFlash("success", "Declined");

			}else{
				$last_submission->approve();
				Session::putFlash("success", "Approved");
			}



			Redirect::back();
	}


	public function faqs()
	{
		$this->view("admin/faqs");
	}



	public function cms()
	{
		$this->view("admin/cms");
	}



	public function access_control($admin_id)
	{	

		$admn = Admin::find($admin_id);
		if ($admn == null) {
			Redirect::back();
		}

		if ($admn->is_owner()) {
			// Session::putFlash('danger', "Invalid Request");
			// Redirect::back();
		}


		$this->view('admin/access_control', compact('admn'));
	}


	public function accesses()
	{
		$accesses = Access::all();
		$this->view('admin/accesses', compact('accesses'));
	}

	public function edit_access($access_id)
	{
		$db_access = Access::find($access_id);
		if ($db_access == null) {
			Redirect::back();
		}


		$this->view('admin/edit_access', compact('db_access'));
	}


	public function add_admin()
	{
		$this->view('admin/add_admin');
	}



	public function all_admins()
	{
		$admins = Admin::all();
		$this->view('admin/all_admins', compact('admins'));
	}

	public function users()
	{
		$this->all_users();
	}

	private function users_matters($extra_sieve)
	{


		$sieve = $_REQUEST;
		$sieve = array_merge($sieve, $extra_sieve);

		$query = User::latest();
		// ->where('status', 1);  //in review
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  UserFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$sql = $query->Filter($filter);
		CategorySpoof::register_query($sql);

		$users =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered


		return compact('users', 'sieve', 'data','per_page');
		
	}


	public function all_users()
	{

		$compact =  $this->users_matters([]);
		extract($compact);
		$page_title = 'All users';

		$this->view('admin/all_users', compact('users', 'sieve', 'data','per_page', 'page_title'));
	}


	public function verified_users()
	{
		$sieve = $_REQUEST;
		$sieve = array_merge($sieve);

		$query = User::latest()->Verified();
		// ->where('status', 1);  //in review
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  UserFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$users =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered



		$page_title = 'Verified users';

		$this->view('admin/all_users', compact('users', 'sieve', 'data','per_page','shop', 'page_title'));
	}

	public function all_trading_accounts()
	{


		$sieve = $_REQUEST;
		$query = TradingAccount::latest();
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
	
		$this->view('admin/all_trading_accounts', compact('trading_accounts', 'sieve', 'data','per_page'));
	}


	
	public function all_leads()
	{


		/*$sieve = $_REQUEST;
		$query = TradingAccount::latest();
		$sieve = array_merge($sieve);
		
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  TradingAccountFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$users =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered

		$users = $query->get();
*/
		$this->view('admin/all_leads', compact('users', 'sieve', 'data','per_page'));
		
	}


	public function user_verification()
	{


		$sieve = $_REQUEST;
		$query = UserDocument::latest();
		// ->where('status', 1);  //in review

					
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  UserDocumentFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$documents =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered


		$this->view('admin/user_verification', compact('documents', 'sieve', 'data','per_page'));
	}

	public function bank_verification()
	{

		$sieve = $_REQUEST;
		$query = UserBank::latest();
					
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  UserBankFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$banks =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered


		$this->view('admin/bank_verification', compact('banks', 'sieve', 'data','per_page'));
		
	}

	public function course_verification()
	{	
		$response = DB::select("SELECT m1.*
		FROM market m1 LEFT JOIN market m2
		 ON (m1.item_id = m2.item_id AND m1.id < m2.id)
		WHERE m2.id IS NULL 
		AND m1.category = 'course'
		;
		");

		$market_ids = collect($response)->pluck('id')->toArray();


				$sieve = $_REQUEST;
				$query = Market::whereIn('id', $market_ids);
				$sieve = array_merge($sieve, ['category' => 'course']);
				// print_r($sieve);
							
				$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
				$per_page = 50;
				$skip = (($page -1 ) * $per_page) ;

				$filter =  new  MarketFilter($sieve);

				$data =  $query->Filter($filter)->count();

				$posts =  $query->Filter($filter)
								->offset($skip)
								->take($per_page)
								->get();  //filtered

		$this->view('admin/course_verification', compact('posts', 'sieve', 'data','per_page'));
	}



	public function preview_post($post_id)
	{
			try {
				 $post = Post::find($post_id);
				
			} catch (Exception $e) {
				
				Session::putFlash('warning','Could Not Find Post. Please try again');
				// Redirect::back();
			}

		$this->view('guest/single-post', compact('post'));  //note this is
	}


	public function create_post()
	{

			$post = Post::create([
				'user_id'=> $this->admin()->id,
				'author_type' =>'admin'
				]);

			Redirect::to("admin/edit_post/{$post->id}");
	}

	public function edit_post($post_id)
	{
			try {
				 $post = Post::find($post_id);
				
			} catch (Exception $e) {
				
				Session::putFlash('warning','Could Not Find Post. Please try again');
				Redirect::back();
			}

			$this->view('admin/edit_post', compact('post')); 

	}

	public function blogs()
	{



		$sieve = $_REQUEST;
		$query = Post::query();
		$sieve = array_merge($sieve);
					
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  PostFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$records =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered


		$note = MIS::filter_note($records->count(), ($data), (Post::count()),  $sieve, 1);
		$this->view('admin/blogs', compact('records', 'sieve', 'data', 'per_page','note')); 
	}


	public function blog_verification()
	{

		$response = DB::select("SELECT m1.*
		FROM market m1 LEFT JOIN market m2
		 ON (m1.item_id = m2.item_id AND m1.id < m2.id)
		WHERE m2.id IS NULL 
		AND m1.category = 'post'
		;
		");

		$market_ids = collect($response)->pluck('id')->toArray();


		$sieve = $_REQUEST;
		$query = Market::whereIn('id', $market_ids);
		$sieve = array_merge($sieve, ['category' => 'post']);
		// print_r($sieve);
					
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  MarketFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$posts =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered


/*
		print_r($posts->toArray());
		return;
*/
		$this->view('admin/blog_verification', compact('posts', 'sieve', 'data','per_page'));
	}


	public function testimonial_verification()
	{
		$this->view('admin/testimonial_verification');
	}


	public function request_reverse_calculation($deposit_id, $amount_confirmed)
	{
		$deposit_id = MIS::dec_enc('decrypt', $deposit_id);
		$deposit = DepositOrder::find($deposit_id);

		$reverse_calculation = $deposit->doReverseCalculation($amount_confirmed);
		$view = $this->buildView('composed/deposit_reverse_calculation', compact('reverse_calculation') );

		header("content-type:application/json");
		echo json_encode(compact('view'));

	}



	public function process_deposit($deposit_id)
	{	

		$prev_location = $_SERVER['HTTP_REFERER'];
		$main_url = explode("/", $prev_location);
		$end_point = end($main_url);


		$actions = [
			'all_deposits' => [
			/*	'pending',
				'declined',*/

			],
			'deposit_initiated' => [

			],

			'deposit_pending' => [
				'pending',
				'declined',
				'confirmed',
			],

			'deposit_confirmed' => [
				'pending',
				'completed',
				'declined',
			],
			'deposit_completed' => [

			],

			'deposit_declined' => [
				'pending',
				'declined',
				'confirmed',
			],	
		];

		$admin_action =  $actions[$end_point];
		$filtered_admin_action = array_filter(v2\Models\DepositOrder::$statuses , function($action) use ($admin_action){
			return in_array($action, $admin_action);
		});


		$enc_deposit_id = $deposit_id;
		$deposit_id = MIS::dec_enc('decrypt', $deposit_id);
		$deposit = DepositOrder::find($deposit_id);

		if ($deposit ==null) {
			Session::putFlash("danger", "Deposit not found");
			Redirect::back();
		}


		$this->view('admin/process_deposit', compact('deposit','filtered_admin_action','enc_deposit_id'));

	}

	public function process_withdrawal($withdrawal_id)
	{	



		$prev_location = $_SERVER['HTTP_REFERER'];
		$main_url = explode("/", $prev_location);
		$end_point = end($main_url);

		$actions = [
			'all_withdrawals' => [

			],
			'withdrawal_initiated' => [
				
				'pending',
				'declined',
				'confirmed',
					
			],

			'withdrawal_pending' => [
				'pending',
				'declined',
				'confirmed',
			],

			'withdrawal_confirmed' => [
				'pending',
				'completed',
				'declined',
			],
			'withdrawal_completed' => [

			],

			'withdrawal_declined' => [

			],	


		];

		$admin_action =  $actions[$end_point];
		$filtered_admin_action = array_filter(v2\Models\Withdrawal::$statuses , function($action) use ($admin_action){
			return in_array($action, $admin_action);
		});




		$withdrawal_id = MIS::dec_enc('decrypt', $withdrawal_id);
		$withdrawal = Withdrawal::find($withdrawal_id);

		if ($withdrawal ==null) {
			Session::putFlash("danger", "withdrawal not found");
			Redirect::back();
		}


		$this->view('admin/process_withdrawal', compact('withdrawal','filtered_admin_action'));

	}


	public function all_deposits()
	{


		$compact =  $this->deposit_matters();
		extract($compact);
		$page_title = 'All Deposits';

		$this->view('admin/all_deposits', compact('deposits', 'sieve', 'data','per_page','shop', 'page_title'));
	}


	private function deposit_matters($extra_sieve=[])
	{
		$sieve = $_REQUEST;
		$sieve = array_merge($sieve, $extra_sieve);

		$query = DepositOrder::latest();
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

		return compact('deposits', 'sieve', 'data','per_page','shop');
	}


	private function withdrawal_matters($extra_sieve=[])
	{
		$sieve = $_REQUEST;
		$sieve = array_merge($sieve, $extra_sieve);

		$query = Withdrawal::latest();
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

		return compact('withdrawals', 'sieve', 'data','per_page','shop');
	}


	public function deposit_initiated()
	{

		$sieve = ['status' => 'initialized'];
		$compact =  $this->deposit_matters($sieve);
		extract($compact);
		$page_title = 'Initiated Deposits';

		$this->view('admin/all_deposits', compact('deposits', 'sieve', 'data','per_page','shop', 'page_title'));
	}

	public function deposit_pending()
	{

		$sieve = ['status' => 'pending'];
		$compact =  $this->deposit_matters($sieve);
		extract($compact);
		$page_title = 'Pending Deposits';
		
		$this->view('admin/all_deposits', compact('deposits', 'sieve', 'data','per_page','shop', 'page_title'));
	}



	public function deposit_confirmed()
	{
		$sieve = ['status' => 'confirmed'];
		$compact =  $this->deposit_matters($sieve);
		extract($compact);
		$page_title = 'Confirmed Deposits';
		
		$this->view('admin/all_deposits', compact('deposits', 'sieve', 'data','per_page','shop', 'page_title'));
	}

	



	public function deposit_completed()
	{

		$sieve = ['status' => 'completed'];
		$compact =  $this->deposit_matters($sieve);
		extract($compact);
		$page_title = 'Completed Deposits';
		
		$this->view('admin/all_deposits', compact('deposits', 'sieve', 'data','per_page','shop', 'page_title'));
	}


	public function deposit_declined()
	{

		$sieve = ['status' => 'declined'];
		$compact =  $this->deposit_matters($sieve);
		extract($compact);
		$page_title = 'Declined Deposits';
		
		$this->view('admin/all_deposits', compact('deposits', 'sieve', 'data','per_page','shop', 'page_title'));
	}



	public function all_withdrawals()
	{

		$sieve = [];
		$compact =  $this->withdrawal_matters($sieve);
		extract($compact);
		$page_title = 'All Withdrawals';
		
		$this->view('admin/all_withdrawals', compact('withdrawals', 'sieve', 'data','per_page','shop', 'page_title'));
	}

	public function withdrawal_initiated()
	{

		$sieve = ['status'=> 1];
		$compact =  $this->withdrawal_matters($sieve);
		extract($compact);
		$page_title = 'Initiated Withdrawals';
		
		$this->view('admin/all_withdrawals', compact('withdrawals', 'sieve', 'data','per_page','shop', 'page_title'));
	}

	public function withdrawal_pending()
	{

		$sieve = ['status'=> 2];
		$compact =  $this->withdrawal_matters($sieve);
		extract($compact);
		$page_title = 'Pending Withdrawals';
		
		$this->view('admin/all_withdrawals', compact('withdrawals', 'sieve', 'data','per_page','shop', 'page_title'));
	}

	public function withdrawal_confirmed()
	{

		$sieve = ['status'=> 3];
		$compact =  $this->withdrawal_matters($sieve);
		extract($compact);
		$page_title = 'Confirmed Withdrawals';
		
		$this->view('admin/all_withdrawals', compact('withdrawals', 'sieve', 'data','per_page','shop', 'page_title'));
	}

	public function withdrawal_completed()
	{

		$sieve = ['status'=> 4];
		$compact =  $this->withdrawal_matters($sieve);
		extract($compact);
		$page_title = 'Completed Withdrawals';
		
		$this->view('admin/all_withdrawals', compact('withdrawals', 'sieve', 'data','per_page','shop', 'page_title'));
	}


	public function withdrawal_declined()
	{

		$sieve = ['status'=> 5];
		$compact =  $this->withdrawal_matters($sieve);
		extract($compact);
		$page_title = 'Declined Withdrawals';
		
		$this->view('admin/all_withdrawals', compact('withdrawals', 'sieve', 'data','per_page','shop', 'page_title'));
	}

	public function all_bonuses()
	{
		$this->view('admin/all_bonuses');
	}



	

	public function survey()
	{
		$this->view('admin/survey');
	}



	public function support_messages()
	{

		$this->view('admin/support-messages');
	}

	private function ticket_matters($extra_sieve)
	{


		$sieve = $_REQUEST;
		$sieve = array_merge($sieve, $extra_sieve);

		$query = SupportTicket::latest();
		// ->where('status', 1);  //in review
		$sieve = array_merge($sieve);
		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  SupportTicketFilter($sieve);

		$data =  $query->Filter($filter)->count();

		$tickets =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filtered

		return compact('tickets', 'sieve', 'data','per_page');
		
	}


	public function open_tickets()
	{
		$sieve = ['status' => 0];
		$compact =  $this->ticket_matters($sieve);
		extract($compact);
		$page_title = 'Open Tickets';

		$this->view('admin/all_tickets', compact('tickets', 'sieve', 'data','per_page', 'page_title'));
	}


	public function closed_tickets()
	{
		$sieve = ['status' => 1];
		$compact =  $this->ticket_matters($sieve);
		extract($compact);
		$page_title = 'Closed Tickets';

		$this->view('admin/all_tickets', compact('tickets', 'sieve', 'data','per_page', 'page_title'));
	}


	public function all_campaigns()
	{	


		$sieve = $_REQUEST;
		$sieve = array_merge($sieve, []);


		$query = Campaign::query();

		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  CampaignFilter($sieve);

		$data =  $query->Filter($filter)->count();


		$campaigns =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filt


		$this->view('admin/all_campaigns', compact('sieve', 'data','per_page','campaigns'));

	}


	public function view_category($category_id)
	{
		$campaign_category = CampaignCategory::find($category_id);
		if ($campaign_category==null) {
			Session::putFlash('danger',"Invalid request");
			Redirect::back();
		}

		$this->view('admin/campaign_category_view',  compact('rows','campaign_category'));
	}

	public function campaigns_categories()
	{
		$sieve = $_REQUEST;
		$sieve = array_merge($sieve, []);


		$query = CampaignCategory::query();

		$page = (isset($_GET['page']))?  $_GET['page'] : 1 ;
		$per_page = 50;
		$skip = (($page -1 ) * $per_page) ;

		$filter =  new  CampaignCategoryFilter($sieve);

		$data =  $query->Filter($filter)->count();


		$campaigns_categories =  $query->Filter($filter)
						->offset($skip)
						->take($per_page)
						->get();  //filt


		$this->view('admin/campaigns_categories', compact('sieve', 'data','per_page','campaigns_categories'));
	}

	public function create_campaign()
	{
		$campaign =  Campaign::create([
			'admin_id'=> $this->admin()->id,
		]);


		Redirect::to($campaign->editLink);
	}


	public function edit_campaign($campaign_id)
	{
		$campaign =  Campaign::find($campaign_id);
		if ($campaign == null) {
			Session::putFlash('danger','Invalid request');
			Redirect::back();
		}


		$this->view('admin/edit_campaign', compact('campaign'));
	}

	public function news()
	{
		$this->view('admin/news');
	}



	public function testimony()
	{
		$this->view('admin/testimony');
	}






	public function edit_testimony($testimony_id =null)
	{
		if (($testimony_id != null)  ) {
		$testimony = Testimonials::find($testimony_id);
			if (($testimony != null) ) {

						$this->view('admin/edit_testimony', ['testimony'=>$testimony ]);
						return;
			}else{
				Redirect::to();
			}

		}

	}






	public function mark_withdrawal_paid($withdrawal_id)
	{

		$withdrawal = LevelIncomeReport::find($withdrawal_id);
		$withdrawal->mark_withdrawal_paid();
	
			Redirect::back();
	}



	public function administrators()
	{

		$this->view('admin/administrators');
	}
	


	public function accounts()
	{
		$this->view('admin/accounts');
	}


	public function profile($admin_id=null)
	{

		$admn  =  Admin::where('id', $admin_id)->first();
		if (($admn == null) || (($admn->is_owner() )  && (!$this->admin()->is_owner()))) {

			Session::putFlash('danger','unauthorised access');
			Redirect::back();
		}

		$this->view('admin/profile', compact('admn'));

	}




	public function broadcast()
	{
		$this->view('admin/broadcast');
	}



	public function viewSupportTicket($ticket_id){

		$support_ticket_messages = SupportTicket::find($ticket_id)->messages; 
		$support_ticket 		 = SupportTicket::find($ticket_id); 

		$this->view('admin/support-ticket-messages', [
					'support_ticket_messages'	=> $support_ticket_messages ,
					'support_ticket'			=> $support_ticket 
									]);  

	}
	



	public function testimonials()
	{


	    $sieve = $_REQUEST;
	    // $sieve = array_merge($sieve, $extra_sieve);

	    $query = Testimonials::latest();
	    // ->where('status', 1);  //in review
	    $sieve = array_merge($sieve);
	    $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
	    $per_page = 50;
	    $skip = (($page - 1) * $per_page);

	    $filter = new  TestimonialsFilter($sieve);

	    $data = $query->Filter($filter)->count();

	    $testimonials = $query->Filter($filter)
	        ->offset($skip)
	        ->take($per_page)
	        ->get();  //filtered

	        $note = MIS::filter_note($testimonials->count(), ($data), (Testimonials::count()),  $sieve, 1);

	    $this->view('admin/testimonials', compact('testimonials', 'sieve', 'data', 'per_page','note'));
	}



	public function support()
	{

		$support_tickets = SupportTicket::all();
			$this->view('admin/support', ['support_tickets' => $support_tickets]);  
	}



	public function companies(){
		$this->view('admin/companies');
	}



	public function testing()
	{
		$this->view('admin/sales');
	}	






	public function settings(){
		$this->view('admin/settings');
	}


	public function user_profile($user_id = null){

		if ($user_id==null) {
			Redirect::back();
		}


		$_SESSION[$this->auth_user()] = $user_id;

		$domain = Config::domain();
		$e = <<<EOL


				<style type="text/css">
					body {
	  				 margin: 0;
	   				overflow: hidden;
					}
					#iframe1 {
	   				 position:absolute;
	    				left: 0px;
	    				width: 100%;
	    				top: 0px;
	    				height: 100%;
					}
				</style>


	 		<iframe  id="iframe1" src="$domain/user/dashboard"></iframe>
EOL;

		echo "$e";
		// $this->view('admin/accessing_user_profile');
	}



	public function dashboard()
	{	
		$this->view('admin/dashboard');

	}





}























?>