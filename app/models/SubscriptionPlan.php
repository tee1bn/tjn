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

	public static $benefits = [
		   'participate_in_compensation_plan' => [
		   		'title'=> 'Participate in compensation plan',
		   ],
		   'get_leadership_reward' => [
		   		'title'=> 'Get leadership rewards',
		   ],

		   'qualification_for_trips_and_quaterly_conventions' => [
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
			$previous_sub 	= $user->subscription;
			$new_sub 		= self::find($subscription_id);

			// $cost =  (@$previous_sub->Finalcost ==null) ?  $new_sub->Finalcost  : ($new_sub->Finalcost - (int)$previous_sub->Finalcost) ;
			$previous_price = (@$previous_sub->price != null) ? $previous_sub->price : $new_sub->price ;

					//ensure this is not downgrade
				if ($new_sub->price  < $previous_price  ) {
					Session::putFlash('danger', 
						"You cannot downgrade your subscription to {$new_sub->name}.");
						return json_encode([]);
				}


				//ensure no double purchase on subscription
				if ($new_sub->id  < $previous_sub->id  ) {
					Session::putFlash('danger', 
						"You are already on {$new_sub->name} plan.");
						return json_encode([]);
				}





				//ensure the same scheme is not ordered twice within same time
/*                $ordered_ids = $user->subscriptions->where('paid_at', '!=', null)->pluck('plan_id')->toArray();
                if (in_array($new_sub->id, $ordered_ids)) {
                	Session::putFlash('info', "You already purchased {$new_sub->name}");
                	return json_encode([]);
                }
*/

			//if user has enough balance, put on subscription
			if (false) {


			}else{
				
				//delete unuseful orders
			 	SubscriptionOrder::where('user_id', $user_id)->where('plan_id', '!=', $subscription_id)->where('paid_at',null)->delete();		 	

			 	//cancel current subscription if automatic


			 	//determine wallet to debit


			 	if (isset($_POST['wallet'])) {

				 	$wallet_to_use =  Wallet::$wallets[$_POST['wallet']];
				 	$wallet_class = $wallet_to_use['class'];
				 	$wallet_category = $wallet_to_use['category'];

			 	}else{

		        	$wallet = new Wallet;
			 		foreach ($wallet->available_wallets($user) as $key => $option){

			 			if ($option['balance'] >= $new_sub->price) {
			 				$wallet_category = $option['name'];
			 				break;
			 			}

			 		}
			 	}	

			 	if ((!isset($wallet_category)) || ($wallet_category=='')) {


			 		$wallet_to_use =  Wallet::$wallets['deposit'];
			 		$wallet_class = $wallet_to_use['class'];
			 		$wallet_category = $wallet_to_use['category'];

			 	}



			 	 	//cal expiry date.

			 		/*$setting = SiteSettings::find_criteria('rules_settings')->settingsArray;
			 		$rule = $setting['this_month_membership_expiry_rule'];
			 		$today = date("d");
			 		
			 		$expiry_date =  $rule['renewal_date'];
			 		if (($today >= $rule['from']) && ($today <= $rule['to']) ) {
			 			$expires_at = date("Y-m-$expiry_date");
			 		}else{
			 			if (in_array($today, [31,30,29,28])) {
			 				$date = date("Y-m-d", strtotime("-1 days"));
			 			}

			 			$expires_at = date("Y-m-$expiry_date", strtotime("$date next month"));
			 		}
					*/

					//expires next 29days
			 		$paid_at = date("Y-m-d", strtotime("+29 days"));
			 		$expires_at = $paid_at;

			 



			 	//debit user
			 	$comment = "Purchased $new_sub->name for $new_sub->price";
			 	//make debit first
			 	$debit =$wallet_class::createTransaction(
			 		'debit',
			 		$user_id,
			 		null,
			 		$new_sub->price,
			 		'completed',
			 		$wallet_category,
			 		$comment,
			 		null, 
			 		null, 
			 		null,

			 		null,
			 		$paid_at,
			 		null,
			 		false
			 	);

			 	if ($debit == false) {

			 	//do not show notification if this function is invoked automacticaly
				if ($_POST['auto']==1) {
					unset($_SESSION['flash']);
				}

			 		throw new Exception("Could not debit", 1);
			 	}

			 	$debit->update([
			 		'payment_method' => 'account_plan',
			 	]);





			 	$new_sub_order = SubscriptionOrder::create([
			 							 'plan_id'  	=> $new_sub->id,
			 							 'user_id' 		=> $user_id,
			 							 'price'   		=> $new_sub->price,
			 							 'payment_method'=> $wallet_category,
			 							 'payment_state'=> 'manual',
			 							 'expires_at'=> 	$expires_at,
			 							 'details'		=> json_encode($new_sub),
			 						]);



			 	$new_sub_order->mark_paid();


			 	/*$plan_id = $subscription_id;
			 	$price = $new_sub->PriceBreakdown['total_payable'];
			 	$cart = compact('plan_id','user_id','price');

		 		$shop = new Shop();
		 		$payment_details =	$shop
		 							->setOrderType('packages') //what is being bought
		 							->receiveOrder($cart)
		 							->setPaymentMethod($_POST['payment_method'])
		 							->setPaymentType(SubscriptionOrder::$payment_types[$_POST['payment_method']])
		 							->initializePayment()
		 							->attemptPayment()
		 							;*/
			}

			DB::commit();
			// $shop->goToGateway();

				Session::putFlash('success', 
					"Order for {$new_sub->name} created successfully.");


			return $new_sub_order;
		} catch (Exception $e) {
			DB::rollback();
		}

		return false;
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