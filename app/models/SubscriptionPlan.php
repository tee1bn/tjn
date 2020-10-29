<?php



use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;


class SubscriptionPlan extends Eloquent 
{
	
	protected $fillable = [
							'package_type', //name
							 'price' ,
							 'commission_price' , // amount on which commission is calculated
							 'downline_commission_level' ,
							 'get_pool' , //whether user on this package qualify for pools commissions
							 'percent_vat' , //percent of 'price' added to arrive at final cost.
							 'hierarchy' ,
							'features',
							'availability',
							'confirmation_message',
							'created_at'
						];
	
	protected $table = 'subscription_plans';





	public function getFinalcostAttribute()
	{
		return (0.01 * $this->percent_vat * $this->price) + $this->price;
	}





	public static function create_subscription_request($subscription_id, $user_id)
	{	
			$month = date('m');

		DB::beginTransaction();

		try {


			$existing_requests = SubscriptionOrder::where('user_id', $user_id)
												// ->whereMonth('created_at', $month )
												->where('plan_id', $subscription_id)
												->get();

			$user  			= User::find($user_id);
			$previous_sub 	= self::find($user->account_plan);
			$new_sub 		= self::find($subscription_id);


			// $cost =  (@$previous_sub->Finalcost ==null) ?  $new_sub->Finalcost  : ($new_sub->Finalcost - (int)$previous_sub->Finalcost) ;

			$cost = $new_sub->Finalcost;


			$previous_hierachy = (@$previous_sub->hierarchy != null) ? $previous_sub->hierarchy : $new_sub->hierarchy ;


					//ensure this is not downgrade
				if ($new_sub->hierarchy  > $previous_hierachy  ) {

					Session::putFlash('danger', 
						"You cannot downgrade your subscription to {$new_sub->package_type}.");
						return;
				}

					//ensure no request is existing for the month
					//ie one subscription per calendar month
				if ($existing_requests->count() > 0) {
						$month = date('F');
						Session::putFlash('info', 
							"You already have a request on {$new_sub->package_type}");
						// throw new Exception("You already have a request on {$new_sub->package_type}", 1);

						return $existing_requests->first();
				}


			//if user has enough balance, put on subscription
			if (false) {


			}else{
				//create subscription request
				if (SubscriptionOrder::user_has_pending_order($user_id, $new_sub->id)) {
					Session::putFlash('danger', 
						"You have pending order for {$new_sub->package_type}.");
						return;
					// throw new Exception("You have pending order for {$new_sub->package_type}.", 1);
				}

					//delete unuseful orders
				 	SubscriptionOrder::where('user_id', $user_id)->where('plan_id', '!=', $subscription_id)->where('paid_at',null)->delete();


				$new_order =  SubscriptionOrder::create_order($subscription_id, $user_id, $cost);

			}

			DB::commit();
				Session::putFlash('success', 
					"Order for {$new_sub->package_type} created successfully.");
			return $new_order;
		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
		}

		return false;
	}

	

	public function is_available()
	{
		return (bool) ($this->availability =='on');
	}



	public function available()
	{
		return self::where('availability', 'on');
	}

	public function getfeatureslistAttribute()
	{
		return explode(',', $this->features);
	}


}


















?>