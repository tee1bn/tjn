<?php

use Illuminate\Database\Capsule\Manager as DB;
use  v2\Shop\Shop;
use  v2\Models\Market;
use wp\Models\Post;
use wp\Models\User as WpUser;


/**
 * this class is the default controller of our application,
 * 
*/
class shopController extends controller
{


    public function __construct(){      
    /*  if (! $this->admin()) {
            $this->middleware('current_user')
                 ->mustbe_loggedin();
                 // ->must_have_verified_email();
                }       */
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


            //for subscription payment
            public function execute_agreement()
            {       

                $auth = $this->auth();
                $shop = new Shop();
                $item_purchased = $shop->available_type_of_orders[$_REQUEST['item_purchased']];
                $full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];          
                $order_id = $_REQUEST['order_unique_id'];
                $order = $full_class_name::where('id' ,$order_id)->where('user_id', $auth->id)->where('paid_at', null)->first();



                switch ($_REQUEST['item_purchased']) {
                    case 'packages':
                        $redirect = 'user/package';
                        break;
                    case 'product':
                        $redirect = 'user/online_shop';
                        break;
                    
                    default:
                        # code...
                        break;
                }


                if ($order==null) {
                    Redirect::to($redirect);
                }



                DB::beginTransaction();
                try {
                    
                    $shop->setOrder($order)->executeAgreement();

                DB::commit();
                } catch (Exception $e) {
                    
                }


                    Redirect::to($redirect);
            }


            public function callback()
            {
                $auth = $this->auth();
                $shop = new Shop();
                $item_purchased = $shop->available_type_of_orders[$_REQUEST['item_purchased']];
                $full_class_name = $item_purchased['namespace'].'\\'.$item_purchased['class'];          
                $order_id = $_REQUEST['order_unique_id'];
                $order = $full_class_name::where('id' ,$order_id)->where('paid_at', null)->first();


                switch ($_REQUEST['item_purchased']) {
                    case 'packages':
                        $redirect = 'user/package';
                        break;
                    case 'product':
                        $redirect = 'user/online_shop';
                        break;
                    
                    default:
                        # code...
                        break;
                }
                    

                if ($order==null) {
                    // Redirect::to($redirect);
                }


                $shop->setOrder($order)->verifyPayment();
                
                // Redirect::to($redirect);
                

                $url = $order->after_payment_url();


                header("content-type:application/json");
                echo json_encode(compact('url','order'));

            }


            public function delivery($order_id)
            {   
                $order_id = MIS::dec_enc('decrypt', $order_id);
                $order = Orders::where('id', $order_id)->Paid()->first();
                if ($order == null) {

                    Redirect::back();
                }


                $this->view('guest/delivery', compact('order'));
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

                $payment_type = $order->PaymentDetailsArray['payment_type'] ?? 'one_time';

                $shop = new Shop();
                $attempt =  $shop
                ->setOrder($order)
                ->setPaymentMethod($_REQUEST['payment_method'])
                ->setPaymentType($payment_type)
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

                    //create new customer
                    $extra_detail = $cart['$extra_detail'];
                    if (! $auth) {
                        $customer = Customer::updateOrcreate(
                                            [
                                                'email' => $extra_detail['email'],
                                            ],
                                            [
                                            'firstname' => $extra_detail['firstname'],
                                            'lastname' => $extra_detail['lastname'],
                                            'phone' => $extra_detail['phone']
                                        ]);

                    }


                    $product_references = explode("-", $extra_detail['product_ref']);
                    $affiliate_id = $product_references[1] ?? null;


                    $new_order = $model::updateOrcreate(
                        ['id' => $_SESSION['shop_checkout_id'] ??null ],
                        [
                            'user_id'        => $auth->id ?? null,
                            'customer_id'        => $customer->id ?? null,
                            'affiliate_id'        => $affiliate_id ?? null,
                            'buyer_order'    => json_encode($cart['$items']),
                            'extra_detail'    => json_encode($cart['$extra_detail']),
                            'percent_off'    => $percent_off ?? 0,
                        ]);

                    $shop = new Shop();
                    $shop
                                        // ->setOrderType('order') //what is being bought
                    ->setOrder($new_order)
                    ->setPaymentMethod($_POST['payment_method'])
                    ->setPaymentType();


                    DB::commit();
                    $_SESSION['shop_checkout_id'] = $new_order->id;



                    header("content-type:application/json");

                    switch ($action) {
                        case 'get_breakdown':


                        $breakdown = $shop->fetchPaymentBreakdown();
                        echo json_encode(compact('breakdown')) ;
                        break;

                        case 'make_payment':

                        $payment_details = $shop->initializePayment()
                        ->attemptPayment();



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





        public function show_invoice($order_id, $type)
        {
            $auth = $this->auth();
                  

            $shop = new Shop;
            $class = $shop->available_type_of_orders[$type]['class'];



            $order = $class::where('id', $order_id)->where('payment_method', 'bank_transfer')
                                         // ->where('user_id', $auth->id)
                                         ->where('paid_at', null)->first();


            if ($order==null) {
                // Session::putFlash('danger','Invalid Request');
                Redirect::back();
            }

            Shop::empty_cart_in_session();

            // $invoice = 
            // $invoice = 
            $order->getInvoice();


        }

        



        public function bank_transfer($order_id, $type)
        {
            $auth = $this->auth();


            $shop = new Shop;
            $class = $shop->available_type_of_orders[$type]['class'];


           $order = $class::where('id', $order_id)->where('payment_method', 'bank_transfer')
                                        ->first();




            if ($order==null) {
                // Session::putFlash('danger','Invalid Request');
                // Redirect::back();
            }

            Shop::empty_cart_in_session();

            $this->view('auth/deposit_bank_transfer', compact('order','type'));

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


        if (! isset($_SESSION['cart'])) {
            $cart = [];
        }else{



            $cart = json_decode($_SESSION['cart'], true);
           foreach ($cart['$items'] as $key =>  $item) {
                     // $item_array =  json_decode($item, true);
                unset($cart['$items'][$key]['$$hashKey']);
                $items[] = $item;
            }

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

        $notification_email=    CmsPages::where('page_unique_name', 'notification' )->first()->page_content;
        $notification_email = json_decode($notification_email , true);


        $subject = Config::project_name().' NEW ORDER NOTIFICATION';
        $email_body = $this->buildView('emails/order_notification', ['order'=>$order]);

        $mailer =   new Mailer();
        $mailer->sendMail($notification_email['notification_email'], $subject, $email_body );
        ob_end_clean();
    }


    public function send_order_confirmation_email($order_id)
    {
        $order =  Orders::find($order_id);
        $to = $order->billing_email;
        $subject = Config::project_name().' ORDER CONFIRMATION';
        $email_body = $this->buildView('emails/order_confirmation', ['order'=>$order]);

        $mailer =   new Mailer();
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




    public function submit_for_review($item_id, $model_key='product')
    {
        

        $register = Market::$register;

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
        $last_submission =  Market::where('seller_id', $auth->id)
        ->where('category', $item::$category_in_market)
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
                'seller_id' => $auth->id,
                'category' => $item::$category_in_market,
                'item' => $item->toJson(),
                                'approval_status' => 1, //in review
                            ]);


            DB::commit();
            Session::putFlash('success' ,'Put on sale successfully.');
        } catch (Exception $e) {
            Session::putFlash('danger' ,'Something went wrong');

            print_r($e->getMessage());
            DB::rollback();
            
        }
        
        $submission->approve();

        Redirect::back();
    }



    public function get_single_item_on_market($model_key, $item_id, $previvew= 0)
    {
        $register = Market::$register;

        $model = $register[$model_key]['model'];


        $item =  new $model;

        $item_on_sale = Market::where('category', $item::$category_in_market)
        ->where('item_id', $item_id)
        ->latest()
        ->OnSale()
        ->first();

        if ($item_on_sale==null) {
            echo json_encode([]);
            return;
        }

        $good  = $item_on_sale->good()->market_details();
        if ($previvew==1) {
            $good  = $model::find($item_id)->market_details();
        }

        $single_good = [
            'market_details' => $good
        ];



        header("content-type:application/json");

        echo json_encode(compact('single_good'));


    }

    //previvew page for product
    public function v($id)
    {
        $auth = $this->auth();
        $product = Products::where('id',$id)->where('user_id',$auth->id)->first();

        if ($product == null) {

            Session::putFlash("danger","Item not found");
            Redirect::back();
        }

        $is_preview = 1;
        $this->view('guest/single-product', compact('product','is_preview',));
        // $this->view('composed/view_product', compact('product'));

    }


    public function s($product_ref){
        $this->full_view($product_ref);
    }


    public function full_view($product_ref)
    {

        $product_references = explode("-", $product_ref);

        $item_id = $product_references[0];
        $affiliate_id = $product_references[1] ?? null;


        $model_key ='product';

        $register = Market::$register;

        $model = $register[$model_key]['model'];
        $item =  new $model;



        $item_on_sale = Market::where('category', $item::$category_in_market)
        ->where('item_id', $item_id)
        ->latest()
        ->OnSale()
        ->first();


        if ($item_on_sale == null) {

            // Session::putFlash("danger","Item not found");
            Redirect::back();
        }


        $good = $item_on_sale->preview();

        $product = $item_on_sale->preview();

        $_SESSION['product_ref'] = $product_ref;

        $this->view('guest/single-product', compact('product'));


    }




    public function cart()
    {

        $shop = new Shop;
        $cart = json_decode($_SESSION['cart'], true)['$items'];

        if (count($cart) == 0) {
            Session::putFlash("info", "Your cart is empty.");
            Redirect::to('shop');
        }

        $this->view('guest/view_cart', compact('shop'));
    }




    
    public function market($page=1 , $type = 'product')
    {   
        $type = 'product';

        $domain = Config::domain();
        $shop_link = "$domain/user/shop";

        $register = [
            'course' => [
                'per_page' => 25,
                'currency' => '&#8358;',
                'shop_link' => $shop_link,
                'order_storage' => 'Orders',
            ],

            'product' => [
                'per_page' => 25,
                'currency' => Config::currency(),
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
        $items = $shaded_market ?? [];


        $shop = compact('items', 'config');
        echo json_encode($shop);    
    }
}






?>