<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User, SubscriptionPlan ;
use Filters\Traits\RangeFilterable;



/**
 * 
 */
class SubscriptionOrderFilter extends QueryFilter
{
	use RangeFilterable;


	public function item($item_id=null)
	{	

		if ($item_id == null) {
			return ;
		}

        $this->builder->where('plan_id', 'like', "%$item_id%");
	}

		public function user($user = null)
		{
			if ($user == null) {
				return ;
			}

			$user_ids =  User::WhereRaw("firstname like ? 
	                                      OR lastname like ? 
	                                      OR email like ? 
	                                      OR phone like ? 
	                                      OR username like ? 
	                                      ",
	                                      array(
	                                          '%'.$user.'%',
	                                          '%'.$user.'%',
	                                          '%'.$user.'%',
	                                          '%'.$user.'%',
	                                          '%'.$user.'%')
	                                  )->get()->pluck('id')->toArray();

			$this->builder->whereIn('user_id', $user_ids);
		}


	public function payment_method($method=null)
	{	

		if ($method == null) {
			return ;
		}
        $this->builder->where('payment_details', 'like', "%$method%");
	}
	

	public function id($id=null)
	{	

		if ($id == null) {
			return ;
		}
        $this->builder->where('id', '=', "$id");
	}


	public function ref($ref=null)
	{	

		if ($ref == null) {
			return ;
		}
        $this->builder->where('payment_details', 'like', "%$ref%");
	}


	public function email($email=null)
	{	

		if ($email == null) {
			return ;
		}
		$user_ids = \User::where('email', 'like', "%$email%")->get()->pluck('id')->toArray();

        $this->builder->whereIn('user_id', $user_ids);
	}


	public function payment_status($payment_status = null)
	{
		if ($payment_status == null) {
			return ;
		}

		$operations = [ 'paid' => '!=',  'unpaid' => '='];
		$operation = $operations[$payment_status];
		
		$this->builder->where('paid_at', $operation , null);
	}


	public function phone($phone = null)
	{
		if ($phone == null) {
			return ;
		}
		$user_ids = \User::where('phone', 'like', "%$phone%")->get()->pluck('id')->toArray();

        $this->builder->whereIn('user_id', $user_ids);
	}

	public function username($username = null)
	{
		if ($username == null) {
			return ;
		}

		$user =  User::where('username', $username)->first();
		$this->builder->where('user_id', $user->id);
	}


	public function ordered($start_date=null , $end_date=null )
	{

		if (($start_date == null) &&  ($end_date == null) ) {
			return ;
		}

		$date = compact('start_date','end_date');

		if ($end_date == null) {
			$date = $start_date;
		}

		$this->date($date, 'created_at');
	}




}