<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User ;
use Filters\Traits\RangeFilterable;
use v2\Models\FinancialBank ;

/**
 * 
 */
class MarketFilter extends QueryFilter
{
	use RangeFilterable;


	
	

	public function category($category)
	{
		
		if ($category == null) {
				return ;
			}

		$this->builder->GetCategory($category);
	}
	
		


	public function status($status = null)
	{
		if ($status == null) {
			return ;
		}

		$this->builder->where('approval_status', $status);
	}



	public function onsale($onsale = null)
	{
		if ($onsale == null) {
			return ;
		}

		$this->builder->where('onsale_status', $onsale);
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



		$this->builder->whereIn('seller_id', $user_ids);
	}




	public function created($start_date=null , $end_date=null )
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