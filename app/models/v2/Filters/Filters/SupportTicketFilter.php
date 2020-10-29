<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User, SupportTicket;
use Filters\Traits\RangeFilterable;

/**
 * 
 */
class SupportTicketFilter extends QueryFilter
{
	use RangeFilterable;

	public function ticket_id($ticket_id = null)
	{
		if ($ticket_id == null) {
			return ;
		}

		$this->builder->where('code', 'like' ,"%$ticket_id%");
	}

	
	public function status($status = null)
	{
		if ($status == null) {
			return ;
		}

		$this->builder->where('status', $status);
	}




	public function email($email = null)
	{
		if ($email == null) {
			return ;
		}

		$user_ids = User::where('email', $email)->get()->pluck('id')->toArray();

		$this->builder->whereIn('user_id', $user_ids);
	}

	public function name($name = null)
	{
		if ($name == null) {
			return ;
		}

		$this->builder->WhereRaw("customer_name like ? 
                                      OR customer_email like ? 
                                      OR customer_name like ? 
                                      ",
                                      array(
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%')
                                  );

	}



	public function phone($phone = null)
	{
		if ($phone == null) {
			return ;
		}

		$user_ids = User::where('phone', $phone)->get()->pluck('id')->toArray();

		$this->builder->whereIn('user_id', $user_ids);
	}

	public function username($username = null)
	{
		if ($username == null) {
			return ;
		}
		$this->builder->where('username', $username);
	}


	public function registration($start_date=null , $end_date=null )
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