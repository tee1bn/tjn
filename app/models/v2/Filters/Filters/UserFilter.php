<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User ;
use Filters\Traits\RangeFilterable;



/**
 * 
 */
class UserFilter extends QueryFilter
{
	use RangeFilterable;



	public function firstname($firstname = null)
	{
		if ($firstname == null) {
			return ;
		}
		$this->builder->where('firstname', "like",  "%$firstname%");
	}

	public function lastname($lastname = null)
	{
		if ($lastname == null) {
			return ;
		}
		$this->builder->where('lastname', "like",  "%$lastname%");
	}


	public function middlename($middlename = null)
	{
		if ($middlename == null) {
			return ;
		}
		$this->builder->where('middlename', "like",  "%$middlename%");
	}



	public function name($name = null)
	{
		if ($name == null) {
			return ;
		}

		$this->builder->WhereRaw("firstname like ? 
                                      OR lastname like ? 
                                      ",
                                      array(
                                          '%'.$name.'%',
                                          '%'.$name.'%')
                                  );
	}



	public function email($email = null)
	{
		if ($email == null) {
			return ;
		}

		$this->builder->where('email', $email);
	}

	
	public function active_status($active_status = null)
	{
		if ($active_status == null) {
			return ;
		}

		$operations = [ 2 => '!=',  1 => '='];
		$operation = $operations[$active_status];
		
		$this->builder->where('blocked_on', $operation , null);
	}


	public function phone($phone = null)
	{
		if ($phone == null) {
			return ;
		}
		$this->builder->where('phone', $phone);
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