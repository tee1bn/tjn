<?php



use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\Wallet;
use  v2\Shop\Shop;


class SubscriptionPlan extends Eloquent 
{
	
	protected $fillable = [
							'name', //name
							'price' ,
							'hierarchy', 
							'features',
							'availability',
							'details',
						];
	
	protected $table = 'account_plans';

	public static $cycle = 'year';

	public static $benefits = [

		   'vendor_access' => [
		   		'title'=> 'Participate in compensation plan',
		   ],
		   'affiliate_access' => [
		   		'title'=> 'Get leadership rewards',
		   ],

		   'list_product' => [
		   		'title'=> 'Qualification for trips and quartely conventionsQualification for trips and quartely conventions
		   		Qualification for trips and quartely conventionsQualification for trips and quartely conventionsQualification for trips and quartely conventions
		   		 ',
		   ],
		   'access_to_product_you_can_promote' => [
		   		'title'=> 'Recieve promotional items ',
		   ],
		   'make_more_sales' => [
		   		'title'=> "Sell more by listing by step guide to generate $10,000 commission",
		   ],
		   'earn_commission_on_all' => [
		   		'title'=> 'University Access',
		   ],

		];

	public static $comparison = [

		 /*  'vendor_access' => [
		   		'title'=> 'Participate in compensation plan',
		   ],
		   'affiliate_access' => [
		   		'title'=> 'Get leadership rewards',
		   ],

		   'list_product' => [
		   		'title'=> 'Qualification for trips and quartely conventions ',
		   ],
		   'receive_promotional_items' => [
		   		'title'=> 'Recieve promotional items ',
		   ],
		   'guide_to_generate_x_dollars' => [
		   		'title'=> "Step by step guide to generate $10,000 commission",
		   ],
		   'university_access' => [
		   		'title'=> 'University Access',
		   ],
*/
		];



	public function getDetailsArrayAttribute()
	{
	    if ($this->details == null) {
	        return [];
	    }

	    return json_decode($this->details, true);
	}





	public static function default_sub()
	{
		return self::where('price', 0)->first();
	}


	public function getFinalcostAttribute()
	{
		return $this->price;
	}

	public function getPriceBreakdownAttribute()
	{
		$tax = 0.01 * 0 * $this->price;
		$breakdown = [
			'before_tax'=> $this->price,
			'set_price'=> $this->price,
			'total_percent_tax'=> 0,
			'tax'=>  $tax,
			'type'=>  "exclusive",
			'total_payable'=>  $this->Finalcost,
		];

		return $breakdown;
	}


	public static function create_subscription_request($subscription_id, $user_id, $paid_at=null)
	{


				DB::beginTransaction();


				try {


					$existing_requests = SubscriptionOrder::where('user_id', $user_id)
														->where('plan_id', $subscription_id)
														->get();

					$user  			= User::find($user_id);
					// $previous_sub 	= $user->subscriptions[$subscription_id];
					$new_sub 		= self::find($subscription_id);


					// $cost =  (@$previous_sub->Finalcost ==null) ?  $new_sub->Finalcost  : ($new_sub->Finalcost - (int)$previous_sub->Finalcost) ;
					$previous_price = (@$previous_sub->price != null) ? $previous_sub->price : $new_sub->price ;
						//ensure this is not downgrade
					/*if ($new_sub->price  < $previous_price  ) {
						Session::putFlash('danger', "You cannot downgrade your subscription to {$new_sub->package_type}.");
							return;
					}*/





							
						//ensure the same scheme is not ordered twice
		                /*$ordered_ids = $user->subscriptions->where('paid_at', '!=', null)->pluck('plan_id')->toArray();
		                if (in_array($new_sub->id, $ordered_ids)) {
		                	Session::putFlash('info', "You already purchased {$new_sub->package_type}");
		                	return json_encode([]);
		                }*/


					//if user has enough balance, put on subscription
					if (false) {


					}else{
						
						//delete unuseful orders
					 	// SubscriptionOrder::where('user_id', $user_id)->where('plan_id', '=', $subscription_id)->where('paid_at',null)->delete();		 	
					 	//cancel current subscription if automatic

					 	$plan_id = $subscription_id;
					 	$price = $new_sub->price;

					 	 $payment_type = 'one_time';

					 	$cart = compact('plan_id','user_id','price');


				 		$shop = new Shop();
				 		$payment_details =	$shop
				 							->setOrderType('packages') //what is being bought
				 							->receiveOrder($cart)
				 							->setPaymentMethod($_POST['payment_method'])
				 							->setPaymentType($payment_type)
				 							->initializePayment()
				 							->attemptPayment()
				 							;
					}

					DB::commit();
					// $shop->goToGateway();

					Session::putFlash('success', "Order for {$new_sub->package_type} created successfully.");
					return $payment_details;
					return $shop->order;
				} catch (Exception $e) {
					DB::rollback();

					print_r($e->getMessage());
				}

				return false;
			

	}

	public function getFeaturesListAttribute()
	{
		$list =explode(",", $this->features);
		return $list;
	}
	

	public function is_available()
	{
		return (bool) ($this->availability =='on');
	}



	public static function available()
	{
		return self::where('availability', 'on');
	}

	

}


















?>