<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User ;
use Filters\Traits\RangeFilterable;



/**
 * 
 */
class TestimonialsFilter extends QueryFilter
{
	use RangeFilterable;

	
	

	public function ref($ref=null)
	{	

		if ($ref == null) {
			return ;
		}
        $this->builder->where('id', 'like', "%$ref%");
	}



	public function type($type = null)
	{
		if ($type == null) {
			return ;
		}
		$this->builder->where('type', "=",  "$type");
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




	public function status($status = null)
	{
		if ($status == null) {
			return ;
		}

		$this->builder->where('approval_status', '=' , $status);
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