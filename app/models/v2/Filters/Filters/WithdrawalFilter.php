<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User ;
use Filters\Traits\RangeFilterable;
use v2\Models\FinancialBank ;

/**
 * 
 */
class WithdrawalFilter extends QueryFilter
{
	use RangeFilterable;


	
	

	public function withdrawal_method($withdrawal_method)
	{
		
		if ($withdrawal_method == null) {
				return ;
			}


			$ref = "\"method\":\"$withdrawal_method\"";

        $this->builder->where('method_details', 'like', "%$ref%");

	}


	
	

	public function bank_id($bank_id)
	{
		
		if ($bank_id == null) {
				return ;
			}

			$bank_ids = FinancialBank::where('id', "$bank_id")->get()->pluck('id')->toArray();

		$this->builder->whereIn('bank_id', $bank_ids);
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

		$this->Range($start, $end,  'amount');
	}

		

	public function ref($ref=null)
	{	

		if ($ref == null) {
			return ;
		}
        $this->builder->where('id', 'like', "%$ref%");
	}

	


	public function status($status = null)
	{
		if ($status == null) {
			return ;
		}

		$this->builder->where('status', $status);
	}


	public function name($name = null)
	{
		if ($name == null) {
			return ;
		}

		$user_ids = User::WhereRaw("firstname like ? 
                                      OR lastname like ? 
                                      OR username like ? 
                                      OR email like ? 
                                      OR phone like ? 
                                      ",
                                      array(
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%')
                                  )->get()->pluck('id')->toArray();



		$this->builder->whereIn('user_id', $user_ids);
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