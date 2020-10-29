<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use LevelIncomeReport , User;
use Filters\Traits\RangeFilterable;



/**
 * 
 */
class EarningFilter extends QueryFilter
{
	use RangeFilterable;





		public function type($type = null)
		{
			if ($type == null) {
				return ;
			}
			
			$this->builder->where('status', $type);
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

			$this->builder->whereIn('owner_user_id', $user_ids);
		}


		public function downline($user = null)
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
			
			$this->builder->whereIn('downline_id', $user_ids);
		}


	public function firstname($firstname = null)
	{
		if ($firstname == null) {
			return ;
		}

		$user_ids = User::where('firstname', "like",  "%$firstname%")->get()->pluck('id')->toArray();
		$this->builder->whereIn('id', $user_ids);
	}

	public function lastname($lastname = null)
	{
		if ($lastname == null) {
			return ;
		}
		$user_ids = User::where('lastname', "like",  "%$firstname%")->get()->pluck('id')->toArray();
		$this->builder->whereIn('id', $user_ids);
	}

	public function email($email = null)
	{
		if ($email == null) {
			return ;
		}

		$user_ids = User::where('email', $email)->get()->pluck('id')->toArray();

		$this->builder->whereIn('id', $user_ids);
	}




	public function amount($start=null , $end=null )
	{

		if (($start == null) &&  ($end == null) ) {
			return ;
		}

		$volume = compact('start','end');

		if ($end == null) {
			$end = $start;
		}

		$end = $end ;
		$start = $start ;

		$this->Range($start, $end,  'amount_earned');
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