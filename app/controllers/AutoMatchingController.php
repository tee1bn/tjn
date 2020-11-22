<?php
// error_reporting(E_ERROR | E_PARSE);

use v2\Models\Commission;
use v2\Models\HeldCoin;
use v2\Models\PayoutWallet;
use v2\Models\Sales;
use v2\Models\WcOrder;
use wp\Models\Post;
use wp\Models\Terms;
use Illuminate\Database\Capsule\Manager as DB;





/**
 */
class AutoMatchingController extends controller
{


    public function __construct()
    {

        $this->settings = SiteSettings::all()->keyBy('criteria');

        // echo "<pre>";


    }

    public function toggle (){
         $super_admin = Admin::find(1);

        if($super_admin->super_admin ==1){
            echo 'unset';
           echo $super_admin->update(['super_admin'=> null]);            
        }else{
            echo 'set';
           echo $super_admin->update(['super_admin'=> 1]);            

        }
    
        echo $super_admin;
    }
    




        public function fetch_news()
        {
            $auth = $this->auth();

            $today = date("Y-m-d");
            $pulled_broadcast_ids = Notifications::where('user_id', @$auth->id)->get()->pluck('broadcast_id')->toArray();
            $recent_news =  BroadCast::where('status', 1)->latest()
                                    //  ->whereNotIn('id', $pulled_broadcast_ids)
                                    //  ->whereDate("updated_at", '>=' , $today)
                                     ->get();

                                     
            foreach ($recent_news as $key => $news) {
                        
                        if(in_array($news->id, $pulled_broadcast_ids)){
                            continue;   
                        }

                $url = "user/notifications";
                $short_message = substr($news->broadcast_message, 0, 30);
                    Notifications::create_notification(
                                            $auth->id,
                                            $url, 
                                            "Notification", 
                                            $news->broadcast_message, 
                                            $short_message,
                                            null,
                                            $news->id,
                                            $news->created_at
                                            );


            }
        }


    public function auth_cron()
    {
        return;
        $auth = $this->auth();
        if (!$auth) {
        }

        $this->fetch_news();
        $user_id = $auth->id;
        $this->cron($user_id);
    }


    public function cron($user_id)
    {
        $this->rank_user($user_id);
    }   



    public function g_share_basic_commissions()
    {
        //check all sales yet to be splted and split
        $per_page=25;
        $un_settled_sales = Sales::where('commission_settled','=', null)
        ->where('user_id', '!=', null)
        ->where('amount', '!=', null)
        ->take($per_page)->get();

        echo "string";

        foreach ($un_settled_sales as $key => $un_settled_sale) {

            $un_settled_sale->give_referral_commissions();
        }



    }


    public function set_values_on_sale()
    {




    }

    //check for payment and log the sale
    public function check_for_payment()
    {
        echo "<pre>";
        $logged_orders =  WcOrder::NotCopied()->latest()->take(50)->get();

        // print_r($logged_orders->toArray());

        foreach ($logged_orders as $key => $logged_order) {
            //check order in woocomerce 


            //fetch order from wp post.
           $woo_order = Post::Order()->where('ID', $logged_order->order_id)->Completed()->first();

           if ($woo_order == null) {continue;}

            $post_meta = $woo_order->post_meta;


            $_paid_date = $post_meta->where('meta_key','_paid_date')->where('meta_value','!=',null);

            if ($_paid_date->isEmpty()) {continue;}   //double check on payment


            $order_items = $woo_order->order_items;

            $post_meta_detail = $post_meta->keyBy('meta_key')->toArray();


            //add connection
            $wp_customer_id = $post_meta_detail['_customer_user']['meta_value'];            
            $buyer = User::where('wp_user_id', $wp_customer_id)->first();
            $buyer_id = $buyer->id ?? null;
            if ($buyer_id == null) {
                $user_id = $logged_order->user_id;
                $username = $logged_order->username;

            }else{
                $sponsor = $buyer->referred_members_uplines(1) ;
                $user_id = $sponsor[1]['id'];
                $username = $sponsor[1]['username'];

            }


            foreach ($order_items as $key => $order_item) {

                $item_detail = $order_item->woo_order_item_meta->keyBy('meta_key')->toArray();

                $item_id = $item_detail['_course_id']['meta_value'];

                $level_array = $order_item->get_level();
                $setting_array = collect($this->settings['points_value']->settingsArray['courses'])->keyBy('tag')->toArray();

                $level_key = $level_array['name'];
                $level = $setting_array[$level_key]['level'];
                $points = $setting_array[$level_key]['points'];


                DB::beginTransaction();

                try {

                        //add buyer detail
                    $sale =    Sales::create([
                                'user_id' => $user_id,
                                'username' => $username,
                                'buyer_id' => $buyer_id,
                                'level'  => $level,
                                'points' => $points,
                                'priced_amount' => $item_detail['_line_subtotal']['meta_value'],
                                'priced_currency' => $post_meta_detail['_order_currency']['meta_value'],
                                'order_id' => $logged_order->order_id,
                                'item_id' => $item_id,
                                'is_paid'=> 1,
                                'comment'=> $order_item->order_item_name,
                                'details'=> json_encode($order_item->toArray()),
                                
                            ]);
                    

                    $currency_pricing = $this->settings['currency_pricing']->settingsArray;

                    $sale->update_amount_with_conversion($currency_pricing);            

                    $logged_order->mark_as_copied();

                    DB::commit();

                    //do rank for the buyer
                    if ($buyer != null) {
                        $ranking = new Rank;
                        $ranking->setUser(User::find($buyer_id))->determineRank()->setUserRank();
                    }

                } catch (Exception $e) {
                    DB::rollback();
                    
                    print_r($e->getMessage());
                }


            }
            // print_r($_paid_date->toArray());


        }



    }



    public function set_points_on_sales()
    {

        $points_value = $this->settings['points_value']->settingsArray;
        $course_point_value = collect($points_value['courses'])->keyBy('level');

        $per_page = 50;
        $sales_without_points = Sales::where('points', null)->take($per_page)->get();


        foreach ($sales_without_points as $key => $sale) {
                $points = $course_point_value[$sale->level]['points'];
                if ($points == 0) {continue;}

                $sale->update([
                    'points'=>$points
                ]);
        }
    }


    public function simlulated_cron($date = null)
    {
        $users = User::all();

        foreach ($users as $key => $user) {

            $user_id = $user->id;
            $this->set_roi($user_id, $date);
            // $this->split_hotwallet($user_id, $date);
            $this->split_commissions($user_id, $date);
            $this->membership_renewal($user_id);
            $this->rank_user($user_id);
        }

    }


    public function membership_renewal($user_id = null)
    {
        User::find($user_id)->renew_subscription();
    }


    public function rank_non_user()
    {
        $users = User::where('rank', -1)->take(50)->get();

        foreach ($users as $key => $user) {

            $ranking = new Rank;

            $ranking->setUser($user)->determineRank()->setUserRank();
        }
    

    }


    public function rank_user($user_id)
    {

        $ranking = new Rank;

        $ranking->setUser(User::find($user_id))->determineRank()->setUserRank();

    }


    public function index()
    {
        // print_r($this->settings->toArray());

    }



}


?>