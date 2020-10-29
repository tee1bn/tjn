<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use Clientele, TradingAccount;

/**
 * 
 */
class Mt4TradesFilter extends QueryFilter
{


	public function type($type = null)
	{
		if ($type == null) {
			return ;
		}

		$cmd =  intval($type);

		$this->builder->where('CMD', $cmd);
	}



	public function symbol($symbol = null)
	{
		if ($symbol == null) {
			return ;
		}

		$this->builder->where('SYMBOL', $symbol);
	}

	public function email($email = null)
	{
		if ($email == null) {
			return ;
		}
		$client = Clientele::where('email_address', $email)->first();
		$trading_accounts = $client->trading_accounts;
		if (! empty($trading_accounts)) {
			$account_numbers = $trading_accounts->pluck('trading_account')->toArray();
		}else{
			$account_numbers = [];
		}

		$this->builder->whereIn('LOGIN', $account_numbers);
	}



	public function account_number($account_number = null)
	{
		if ($account_number == null) {
			return ;
		}

		$this->builder->where('LOGIN', $account_number);
	}



	public function category($category = null)
	{

		if ($category == null) {
			return ;
		}

		switch ($category) {
			case 'trade':

				$this->builder->where('SYMBOL', '!=', '');
		
				break;
			
			default:
				# code...
				break;
		}
	}


	public function open_or_close($state = null)
	{
		if ($state == null) {
			return ;
		}

		switch ($state) {
			case 'open':
					$this->builder->whereYear('CLOSE_TIME', 1970);
				break;
			case 'close':
					$this->builder->whereYear('CLOSE_TIME', '!=' ,1970);
				break;
			
			default:
				# code...
				break;
		}


	}


	public function volume($start=null , $end=null )
	{

		if (($start == null) &&  ($end == null) ) {
			return ;
		}

		$volume = compact('start','end');

		if ($end == null) {
			$end = $start;
		}


		$this->Range($start, $end,  'VOLUME');
	}
	public function open_time($start_date=null , $end_date=null )
	{

		if (($start_date == null) &&  ($end_date == null) ) {
			return ;
		}

		$date = compact('start_date','end_date');

		if ($end_date == null) {
			$date = $start_date;
		}

		$this->date($date, 'OPEN_TIME');
	}

	public function close_time($start_date=null , $end_date=null )
	{

		if (($start_date == null) &&  ($end_date == null) ) {
			return ;
		}
		
		$date = compact('start_date','end_date');

		if ($end_date == null) {
			$date = $start_date;
		}

		$this->date($date, 'CLOSE_TIME');
	}

	public function group($group=null )
	{

		if ($group == null ) {
			return ;
		}
		
		$account_numbers = TradingAccount::Group($group)->get()->pluck('trading_account')->toArray();
		$this->builder->whereIn('LOGIN', $account_numbers);
	}


	public function date($date = null, $column=null)
	{

		if ($date == null) {
			return ;
		}

		$today = date("Y-m-d");
		switch ($date) {
			
			case 'this_week':
				$date = date_range($today, 'week', true);
				break;
			
			case 'last_week':
				$last_week = date("Y-m-d",strtotime("$today -1 week"));
				$date = date_range($last_week, 'week', true);
				break;
			
			case 'this_month':
				$date = date_range($today, 'month', true);
				break;
			
			case 'last_month':
				$last_month = date("Y-m-d",strtotime("$today -1 month"));
				$date = date_range($last_month, 'month', true);
				break;	

			case 'today':
				$date = [
					'start_date' => date('Y-m-d'),
					'end_date' => date('Y-m-d'),
				];
				break;

			default:
			if (is_array($date)) {

				//great
			}

				break;
		}

		extract($date);
		$this->dateRange($start_date , $end_date, $column);		
	}


	public function dateRange($start_date=null, $end_date= null, $column=null)
	{		
		if (($start_date == null) && ($end_date==null)) {
			return;
		}

        $this->builder->whereDate($column,'>=',  $start_date)->whereDate($column, '<=',$end_date);
	}


	public function Range($start=null, $end = null, $column=null)
	{		
		if (($start == null) && ($end ==null)) {
			return;
		}

        $this->builder->where($column,'>=',  $start)->where($column, '<=',$end );
	}


}