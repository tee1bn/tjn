<?php

use Illuminate\Database\Capsule\Manager as DB;
use  v2\Shop\Shop;
use  v2\Models\Market;


/**
 * this class is the default controller of our application,
 * 
*/
class shopController extends controller
{


	public function __construct(){		
	/*	if (! $this->admin()) {
			$this->middleware('current_user')
				 ->mustbe_loggedin();
				 // ->must_have_verified_email();
				}		*/
			}


			public function re_confirm_order()
			{
				$shop = new Shop();
				$item_purchased = $shop->available_type_of_orders[$_REQUEST['item_purchased']];
				$full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];
				$order = $full_class_name::where('id' ,$_REQUEST['order_unique_id'])->where('paid_at', null)->first();

				$shop->setOrder($order)->reVerifyPayment();

				Redirect::back();
			}


			public function callback()
			{
				$auth = $this->auth();
				$shop = new Shop();
				$item_purchased = $shop->available_type_of_orders[$_REQUEST['item_purchased']];
				$full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];		 	
				$order_id = $_REQUEST['order_unique_id'];
				$order = $full_class_name::where('id' ,$order_id)->where('user_id', $auth->id)->where('paid_at', null)->first();

				if ($order==null) {
					Redirect::back();
				}

				$shop->setOrder($order)->verifyPayment();


				$url = $order->after_payment_url();


				header("content-type:application/json");
				echo json_encode(compact('url','order'));

			}


			public function checkout()
			{
				$shop = new Shop();

				$item_purchased = $shop->available_type_of_orders[$_REQUEST['item_purchased']];

				$full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];
				$order_id = $_REQUEST['order_unique_id'];
				$order = $full_class_name::where('id' ,$order_id)->where('user_id', $this->auth()->id)->where('paid_at', null)->first();

				if ($order == null) {
					Session::putFlash("info","Invalid Request");
					return;
				}

				$shop = new Shop();
				$attempt =	$shop
				->setOrder($order)
				->setPaymentMethod($_REQUEST['payment_method'])
				->initializePayment()
				->attemptPayment();
				if ($attempt ==false) {
					Redirect::back();
				}

				$shop->goToGateway();

			}


			public function complete_order($action='breakdown')
			{

				$cart = json_decode($_POST['cart'],  true);

				DB::beginTransaction();



				$model = $cart['$config']['order_storage'];


				try {

					$auth = $this->auth();

					$new_order = $model::create(
						// ['id' => $_SESSION['shop_checkout_id']],
						[
							'user_id'		 => $auth->id,
							'buyer_order'	 => json_encode($cart['$items']),
							'percent_off' 	 => $percent_off ?? 0,
						]);

					$shop = new Shop();
					$payment_details =	$shop
										// ->setOrderType('order') //what is being bought
					->setOrder($new_order)
					->setPaymentMethod($_POST['payment_method'])
					->initializePayment()
					->attemptPayment()
					;

					DB::commit();
					$_SESSION['shop_checkout_id'] = $new_order->id;
					header("content-type:application/json");

					switch ($action) {
						case 'get_breakdown':


						$breakdown = $shop->fetchPaymentBreakdown();
						echo json_encode(compact('breakdown')) ;
						break;

						case 'make_payment':

						Session::putFlash('success', "Order Created Successfully. ");
						echo json_encode($payment_details);
						break;

						default:
					# code...
						break;
					}



				} catch (Exception $e) {
					print_r($e->getMessage());

					DB::rollback();
					Session::putFlash('danger', "We could not create your order.");
			// Redirect::back();
				}
			}



	/**
	 * this is the default landing point for all request to our application base domain
	 * @return a view from the current active template use: Config::views_template()
	 * to find out current template
	 */
	public function index($category=null)
	{
		$model = 'course';
		$this->view('guest/shop', compact('model'));
	}


	public function retrieve_cart_in_session()
	{

		// echo "<pre>";
		header("content-type:application/json");

		$cart = json_decode($_SESSION['cart'], true);

		foreach ($cart['$items'] as $key =>  $item) {

				 // $item_array =  json_decode($item, true);
			unset($cart['$items'][$key]['$$hashKey']);
			$items[] = $item;
		}

		if (! isset($_SESSION['cart'])) {
			$cart = [];
		}

		print_r(json_encode($cart));
	}


	public function update_cart()
	{		
		
		$_SESSION['cart'] = ($_POST['cart']);
	}


	public function empty_cart_in_session()
	{
		unset($_SESSION['cart']);
		unset($_SESSION['shop_checkout_id'] );
	}




	public function send_order_notification_email($order_id)
	{
		$order =  Orders::find($order_id);

		$notification_email=  	CmsPages::where('page_unique_name', 'notification' )->first()->page_content;
		$notification_email = json_decode($notification_email , true);


		$subject = Config::project_name().' NEW ORDER NOTIFICATION';
		$email_body = $this->buildView('emails/order_notification', ['order'=>$order]);

		$mailer = 	new Mailer();
		$mailer->sendMail($notification_email['notification_email'], $subject, $email_body );
		ob_end_clean();
	}


	public function send_order_confirmation_email($order_id)
	{
		$order =  Orders::find($order_id);
		$to = $order->billing_email;
		$subject = Config::project_name().' ORDER CONFIRMATION';
		$email_body = $this->buildView('emails/order_confirmation', ['order'=>$order]);

		$mailer = 	new Mailer();
		$mailer->sendMail($to, $subject, $email_body );
		ob_end_clean();
	}



	public function fetch_items($page=1, $model=null)
	{

		if (($model== null) || ($model== '') ) {
			$model='course';
		}

		$domain = Config::domain();
		$shop_link = "$domain/shop";

		$register = [
			'course' => [
				'per_page' => 30,
				'model' => 'Course',
				'currency' => '&#8358;',
				'shop_link' => $shop_link,
			],

		];


		$per_page = 30;
		$products = $register[$model]['model']::approved()->orderBy('updated_at', 'DESC');

		if (Category::find($category_id) != null) {

			$products->where('category_id', $category_id);
		}

			//pagination
		$products = $products->get()->forPage($page, $per_page);
		foreach ($products as $course) {
			$course->market_details = $course->market_details(); 
		}

		header("Content-type: application/json");

		$config = $register[$model];

		$items = $products;


		$shop = compact('items', 'config');
		echo json_encode($shop);	
	}




	public function submit_for_review($item_id, $model_key='course')
	{

		// $this->middleware('current_user')->mustbe_loggedin();

		$register = [
			'course' => [
				'model' => 'Course',
			],

			'post' => [
				'model' => 'Post',
			],

		];

		$model = $register[$model_key]['model'];


		//$this->middleware('current_user')->mustbe_loggedin();
		$item = $model::find($item_id);
		$auth = $this->auth();

		// do some checks
		if  (! $item->is_ready_for_review()){
			Session::putFlash('danger' ,' Pls check to see all required fields have been field then try again');
			Redirect::back();
		}

		//ensure this is not in review already
		$last_submission =	Market::/*where('seller_id', $auth->id)
		->*/where('category', $item::$category_in_market)
		->where('item_id', $item->id)
		->latest()
		->first();

/*
		if ($last_submission != null) {
			if ($last_submission->approval_status_is('in_review')) {
				Session::putFlash('info' ,'Already in review. Admin will decline or approve before you can re-submit.');
				Redirect::back();
			}
		}*/


		DB::beginTransaction();
		
		try {

			$submission = Market::create([
				'item_id' => $item->id,
				// 'seller_id' => $auth->id,
				'category' => $item::$category_in_market,
				'item' => $item->toJson(),
								'approval_status' => 1, //in review
							]);


			DB::commit();
			Session::putFlash('success' ,'Submitted for review successfully! This will be Live after approval');
		} catch (Exception $e) {
			Session::putFlash('danger' ,'Something went wrong');

			print_r($e->getMessage());
			DB::rollback();
			
		}
				$submission->approve();

		Redirect::back();
	}



	public function get_single_item_on_market($model_key, $item_id)
	{
		$register = [
			'course' => [
				'model' => 'Course',
			],
		];

		$model = $register[$model_key]['model'];


		$item =  new $model;

		$item_on_sale =	Market::where('category', $item::$category_in_market)
		->where('item_id', $item_id)
		->latest()
		->OnSale()
		->first();


		$good  = $item_on_sale->good()->market_details();
		$single_good = [
			'market_details' => $good
		];



		header("content-type:application/json");

		echo json_encode(compact('single_good'));


	}

	public function full_view($item_id, $model_key)
	{

		$register = [
			'course' => [
				'model' => 'Course',
			],

		];

		$model = $register[$model_key]['model'];
		$item =  new $model;



		$item_on_sale =	Market::where('category', $item::$category_in_market)
		->where('item_id', $item_id)
		->latest()
		->OnSale()
		->first();




		$good = $item_on_sale->preview();


		switch ($model_key) {
			case 'course':
			$course = $good;

			$model = 'course';
			$access = '';
			// return;
			$this->view('guest/single-course',compact('course','model','access'));
			break;
			
			default:
				# code...
			break;
		}




	}

	
	public function market($page=1 , $type = 'course')
	{	
		

		$domain = Config::domain();
		$shop_link = "$domain/shop";

		$register = [
			'course' => [
				'per_page' => 5,
				'currency' => '&#8358;',
				'shop_link' => $shop_link,
				'order_storage' => 'Orders',
			],

		];

		$market_category = $register[$type];
		$per_page = $market_category['per_page'];
		$skip = (($page -1 ) * $per_page) ;




		$items_on_sale = Market::latest()
		->GoodsBelongingTo($type)
		->OnSale()
		->skip($skip)
		->take($per_page)
		->get()
		;


		$shaded=[];
		foreach ($items_on_sale as $key => $item_on_sale) {
			$market_content = $item_on_sale->item;

			if ($market_content == null) {
				continue;
			}
			$shaded_market[]['market_details'] = $item_on_sale->good()->market_details();
		}

		header("Content-type: application/json");
		
		$config = $market_category;
		$items = $shaded_market;


		$shop = compact('items', 'config');
		echo json_encode($shop);	
	}
}






?>