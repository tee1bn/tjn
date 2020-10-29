<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User ;
use Filters\Traits\RangeFilterable;



/**
 * 
 */
class WalletFilter extends QueryFilter
{
	use RangeFilterable;





	public function ref($ref=null)
	{	

		if ($ref == null) {
			return ;
		}
        $this->builder->where('id', 'like', "%$ref%");
	}


	public function order_id($order_id=null)
	{	

		if ($order_id == null) {
			return ;
		}
        $this->builder->where('order_id', '=', "$order_id");
	}

	
	

	public function comment($comment=null)
	{	

		if ($comment == null) {
			return ;
		}
        $this->builder->where('comment', 'like', "%$comment%");
	}

	

	public function is_transfer($is_transfer=null)
	{	

		if ($is_transfer == null) {
			return ;
		}
        $this->builder->where('comment', 'like', "%Transfer From%");
	}

	

	public function cost($start=null , $end=null )
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

		$this->Range($start, $end,  'cost');
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






	public function payment_status($payment_status = null)
	{
		if ($payment_status == null) {
			return ;
		}

		$operations = [ 'paid' => '!=',  'unpaid' => '='];
		$operation = $operations[$payment_status];
		
		$this->builder->where('paid_at', $operation , null);
	}





	public function status($status = null)
	{
		if ($status == null) {
			return ;
		}

		$this->builder->where('status', $status);
	}



	public function type($type = null)
	{
		if ($type == null) {
			return ;
		}

		$this->builder->where('type', $type);
	}

	

	public function earning_category($earning_category = null)
	{
		if ($earning_category == null) {
			return ;
		}

		$this->builder->where('earning_category', $earning_category);
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



	public function cleared($start_date=null , $end_date=null )
	{

		if (($start_date == null) &&  ($end_date == null) ) {
			return ;
		}

		$date = compact('start_date','end_date');

		if ($end_date == null) {
			$date = $start_date;
		}

		$this->date($date, 'paid_at');
	}




}