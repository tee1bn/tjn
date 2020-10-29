<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User ;
use Filters\Traits\RangeFilterable;

/**
 * 
 */
class TradingAccountFilter extends QueryFilter
{
	use RangeFilterable;






	public function is_active($is_active = null)
	{
		if ($is_active == null) {
			return ;
		}


		switch ($is_lpr) {
			case  0:
				$this->builder->where('active_status', null)->orWhere('active_status', 0);
				break;
			
			case  1:

				$this->builder->where('active_status', 1);
				break;
			
			default:
				# code...
				break;
		}

	}



	public function is_lpr($is_lpr = null)
	{
		if ($is_lpr == null) {
			return ;
		}

		switch ($is_lpr) {
			case  0:
				$this->builder->where('is_through_us', null)->orWhere('is_through_us', 0);
				break;
			
			case  1:

				$this->builder->where('is_through_us', 1);
				break;
			
			default:
				# code...
				break;
		}

	}



	public function broker($broker = null)
	{
		if ($broker == null) {
			return ;
		}

		$this->builder->where('broker_id', $broker);
	}


	public function account_number($account_number = null)
	{
		if ($account_number == null) {
			return ;
		}

		$this->builder->where('account_number', $account_number);
	}

	public function name($name = null)
	{
		if ($name == null) {
			return ;
		}

		$user_ids = User::WhereRaw("firstname like ? 
                                      OR lastname like ? 
                                      OR middlename like ? 
                                      OR username like ? 
                                      OR email like ? 
                                      OR phone like ? 
                                      ",
                                      array(
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%')
                                  )->get()->pluck('id')->toArray();



		$this->builder->whereIn('user_id', $user_ids);
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