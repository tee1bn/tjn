<?php

namespace v2\Models;

use  v2\Models\Wallet;
use  v2\Models\HotWallet;
use Illuminate\Database\Eloquent\Model as Eloquent;

class InvestmentPackage extends Eloquent 
{
	
	protected $fillable = [
				'name',	'details','pack_id', 'features','availablity','category'
				];
	
	protected $table = 'investment_ranges';

	private $amount ;

	public static $categories = [
		1=> [
			'name'=>"REGULAR",
		],
		2=>	[
			'name'=>"CO-FOUNDER PACKS",
		],
	];


	public static function is_roi_complete_on($investment_id)
	{

		$investment =  HotWallet::find($investment_id);
		$detail = $investment->ExtraDetailArray;
		
		//check if this is complete to avoid duplicate rois
		$is_complete = self::for($investment->user_id, $detail['investment']['pack_id'], 1)->first();
		if ($is_complete != null) {
			return true;
		}

		return false;
	}



	public static function setRoi($investment_id, $request_date = null)
	{
		$today =date("Y-m-d H:i:s");

		if ($request_date==null) {
			$request_date = $today;
		}


		$investment =  HotWallet::find($investment_id);
		$detail = $investment->ExtraDetailArray;

		
		//check if this is complete to avoid duplicate rois
		if (self::is_roi_complete_on($investment_id)) {
			return false;
		}

		$roi = self::getRoi($investment_id, $request_date);

		$total_return = array_sum($detail['spread']);



		//set as complete if so
		if ($total_return == $roi) {

			$detail['is_complete'] = 1;
			$investment->update([
								 'amount'=> $roi,
								 // 'paid_at'=> $request_date,
								 'extra_detail'=> json_encode($detail),
								]);

		}else{
			$investment->update([
								 'amount'=> $roi,
								 // 'paid_at'=> $request_date,
								]);
		}

		return $investment;
	}


	public static function getRoi($investment_id, $request_date = null)
	{	

		if ($request_date==null) {
			$request_date = date("Y-m-d");
		}

		$investment =  HotWallet::find($investment_id);

		$detail = $investment->ExtraDetailArray;

		$next_roi = [];
		foreach ($detail['spread'] as $date => $value) {
			if (strtotime($request_date) >= strtotime($date) ) {
				$next_roi[$date] = $value;
			}
		}

		$roi = array_sum($next_roi);
		return $roi;

	}


	public static function user_has_investment_running($user_id, $investment_id)
	{
		$investments = self::running_for($user_id);

		$investments = collect($investments)->pluck('investment')->pluck('id')->toArray();

		return in_array($investment_id, $investments);
	}


	public static function running_for($user_id)
	{
		$running_investments =  InvestmentPackage::for($user_id, null, 0)->get();
		$detail = [];
		foreach ($running_investments as $key => $investment) {

				$detail[$investment->id] = $investment->ExtraDetailArray;
		}

		return $detail;
	}


	public static function for($user_id, $pack_id=null, $is_complete=null, $running= null)
	{

		if ($user_id==null) {

			$query = HotWallet::Category('investment')->Credit();

		}else{

			$query = HotWallet::for($user_id)->Category('investment')->Credit();

		}
		

		if ($pack_id != null) {


			$investment = self::where('pack_id', $pack_id)->first();

		$identfier = <<<EOL
		 {"investment":{"id":$investment->id,"pack_id":$investment->pack_id
EOL;		

		$identfier = trim($identfier);
		
			$query->where('extra_detail', 'like', "%$identfier%");
		}


		if ($is_complete == null) {


		}elseif ($is_complete == 0) {

			$query->UnCompleteInvestment();

		}elseif ($is_complete == 1) {

			$query->CompleteInvestment();

		}


		if ($running == null) {


		}elseif ($running == 0) {

			$query->NotRunning();

		}elseif ($running == 1) {

			$query->Running();

		}





		return $query;

	}


	public function setAmount($amount)
	{
		$this->amount = $amount;
		return $this;
	}

	public function in_range($amount)
	{
		$setting = ($this->DetailsArray);
		$min_capital = $setting['min_capital'];
		$max_capital = $setting['max_capital'];

		if (($min_capital <= $amount) && ($amount <= $max_capital)) {

			return true;
		}else{

			return false;

		}
	}


	public function is_available()
	{
		return (bool) ($this->availablity =='on');
	}



	public function scopeAvailable($query)
	{
		return $query->where('availablity', 'on');
	}


	public function getReturn()
	{
		return $this->roi_percent * 0.01 * $this->price;
	}




	public function spread($interval, $cumulative= false, $value_date = null)
	{

		switch ($interval) {
			case 'annual':
			$return =  ($this->DetailsArray['annual_roi_percent'] * 0.01 * $this->amount);
				break;
			

			case 'weekly':

				$interval_of_week = 9; //9 days because sat and sun onthing happens
				$total_return = $this->getWorth('annual');
				$weekly_return = $this->getWorth('weekly');

				$today = date("Y-m-d");
				$start_date = $value_date ?? $today;
				$weekly = date("Y-m-d", strtotime("$start_date +$interval_of_week days"));
				$spreads = [];

				do{
					$last_sum = array_sum($spreads);
					$possible_sum = $last_sum + $weekly_return;

					if ($possible_sum > $total_return) {
						$weekly_return = $total_return - $last_sum;
						$weekly_return = round($weekly_return, 2);
						$spreads[$weekly] =  $weekly_return;
						break;
					}

					$spreads[$weekly] =  round($weekly_return,2);
					$amount_in_spread = array_sum($spreads);


					$weekly = date("Y-m-d", strtotime("$weekly +$interval_of_week days"));

				}while($amount_in_spread < $total_return);


				$return = $spreads;

				break;
			
			default:
				# code...
				break;
		}


		foreach ($return as $date => $amount) {
			$cumulative_spread[] = $amount;
			$cumulative_spreads[$date] = round(array_sum($cumulative_spread),2);
		}

		if ($cumulative) {
			$return = $cumulative_spreads;
		}


		return $return;
	}



	public function getWorth($interval)
	{

		switch ($interval) {
			case 'annual':
			$return =  ($this->DetailsArray['annual_roi_percent'] * 0.01 * $this->amount);
				break;
			
			case 'weekly':
			$return =  ($this->DetailsArray['weekly_roi_percent'] * 0.01 * $this->amount);
				break;
			
			default:
				# code...
				break;
		}
		return $return;
	}


	public function getDetailsArrayAttribute()
	{
	    if ($this->details == null) {
	        return [];
	    }

	    return json_decode($this->details, true);
	}







}