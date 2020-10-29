<?php


namespace v2\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
use  Filters\Traits\Filterable;
use  v2\Models\Withdrawal;
use  v2\Models\DepositOrder;
use Illuminate\Database\Capsule\Manager as DB;


class TradingAccount extends Eloquent 
{	

	use Filterable;
	
	protected $fillable = [
							'account_number',
							'broker_id',
							'user_id',
							'is_through_us',
							'active_status',
							'created_at',
							'updated_at'
						];
	

	protected $table = 'trading_account';



	public function total_withdrawals()
	{
		$withdrawals = Withdrawal::where('account_number' , $this->account_number)->where('status','completed')
		->select(DB::raw('sum(amount) as dollar') , DB::raw('sum(amount_payable) as naira'))->first();

		return $withdrawals;
	}



	public function total_deposits()
	{	
		$deposits = DepositOrder::where('account_number' , $this->account_number)->where('status','completed')
		->select(DB::raw('sum(amount_to_fund) as dollar') , DB::raw('sum(amount_confirmed) as naira'))->first();

		return $deposits;

	}


	
	public function getDisplayActiveStatusAttribute()
	{

		switch ($this->active_status) {
			case 1:
				$status = '<span class="badge badge-success"> Active</span>';
				break;
			
			case 0:
				$status = '<span class="badge badge-danger"> Not Active</span>';
				break;
			
			case 'pending':
				$status = '<span class="badge badge-warning"> Pending</span>';
				break;
			
			default:
				$status = '<span class="badge badge-warning"> Not Active</span>';
				break;
		}

		return $status;
		



	}


	public function getExchangeRate()
	{
		$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;


		if ($this->is_through_us()) {

			$exchange = $setting['fund_lpr_at'];
		}else{
			$exchange = $setting['fund_nlpr_at'];
		}

		return $exchange;
	}


	public function is_through_us()
	{
		return $this->is_through_us == 1;
	}

	public function is_active()
	{
		return $this->active_status == 1;
	}

	public function getDisplayLPRStatusAttribute()
	{

		switch ($this->is_through_us) {
			case 1:
				$status = '<span class="badge badge-success"> Yes</span>';
				break;
		
			default:
				$status = '<span class="badge badge-danger"> No</span>';
				break;
		}

		return $status;
		



	}


	public function broker()
	{
		return $this->belongsTo('v2\Models\Broker','broker_id');
	}

	
	public function user()
	{
		return $this->belongsTo('User','user_id');
	}


	public function withdrawals()
	{
		return $this->hasMany('v2\Models\UserWithdrawal', 'account_number');
	}
	

	public function deposits()
	{
		return $this->hasMany('v2\Models\DepositOrder', 'account_number' , 'account_number');
	}

}


















?>