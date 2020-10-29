<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User, MIS ;
use Filters\Traits\RangeFilterable;



/**
 * 
 */
class MerchantFilter extends QueryFilter
{
	use RangeFilterable;



	public function id($id = null)
	{
		if ($id == null) {
			return $this->builder;
		}

		return  $this->builder->where('id', $id);
	}



	public function registration($start_date=null , $end_date=null )
	{


		if (($start_date == null) &&  ($end_date == null) ) {
			return $this->builder;
		}

		$date = compact('start_date','end_date');

		if ($end_date == null) {
			$date = $start_date;
		}

		return 	$this->date($date, 'createdAt', 'collection');
	}




}