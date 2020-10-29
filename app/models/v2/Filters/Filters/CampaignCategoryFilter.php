<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User ;
use Filters\Traits\RangeFilterable;



/**
 * 
 */
class CampaignCategoryFilter extends QueryFilter
{
	use RangeFilterable;




	public function title($title = null)
	{
		if ($title == null) {
			return ;
		}
		$this->builder->where('title', "like",  "%$title%");
	}




	public function admin_id($admin_id = null)
	{

		if ($admin_id == null) {
			return ;
		}

		$this->builder->where('admin_id', $admin_id);
	}

	public function status($status = null)
	{
		if ($status == null) {
			return ;
		}

		
		$this->builder->where('status', $status);
	}


	public function created_at($start_date=null , $end_date=null )
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