<?php

namespace v2\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use  v2\Traits\Wallet;
use  v2\Models\InvestmentPackage;
use  v2\Models\HeldCoin;
use  v2\Models\Commission;
use Illuminate\Database\Capsule\Manager as DB;
use SiteSettings, Config, Session, MIS;

use  Filters\Traits\Filterable;

class HotWallet extends Eloquent 
{
	
	use Wallet;
	use Filterable;

	protected $fillable = [
		'user_id',
		'order_id',
		'admin_id',
		'upon_user_id',
		'amount',
		'cost',
		'type',
		'paid_at',
		'earning_category',
		'status',
		'identifier',
		'comment',
		'running_status',
		'extra_detail',	
		'transferred_from',	
	];


	protected $table = 'wallet_for_hot_wallet';




	public function give_referral_commission()
	{
		$today = date("Y-m-d H:i:s");

		$detail = $this->ExtraDetailArray;
		$sale = $detail['capital'];


		$setting = SiteSettings::all()->keyBy('criteria');
		$buyer = $this->user;


		$uplines = collect($this->user->referred_members_uplines(3 ,'enrolment'));
		
		$is_paid_every = 'monday';
		$pay_date = date("Y-m-d 20:00:00" , strtotime("next $is_paid_every"));


		//direct bonus
		$direct_bonus = $setting['direct_bonus']->settingsArray['direct_bonus'];
		foreach ($direct_bonus as $level => $bonus) {
			if (! isset($uplines[$level])) {continue;}

			$receiver = $uplines[$level];

			//ensure receiver is qualified for compensational bonuses
			if (! $receiver->can_received_compensation()) {continue;}


			$days_from_registration = intval((time() - strtotime($receiver['created_at']))/ (24*60*60));

			if ($days_from_registration <= $bonus['x_days'] ) {
				$percent = $bonus['first_x_days_percent'];
			}if ($days_from_registration > $bonus['x_days'] ) {
				$percent = $bonus['after_x_days_percent'];
			}

			if ($percent == 0) {continue;}


			$extra_detail = json_encode([
				'reason' => 'direct_bonus'
			]);




			$direct_bonus_earned = $percent * 0.01 * $sale;

			$identifier="DB#O$this->id#B$buyer->id#L$level#R$receiver[id]";
			//credit Direct Bonus
			$comment = "Level $level Direct Bonus";
			$direct_bonus_commission =Commission::createTransaction(
				'credit',
				$receiver['id'],
				$buyer['id'],
				$direct_bonus_earned,
				'completed',
				'direct_bonus',
				$comment,
				$identifier, 
				$this->id, 
				null,
				$extra_detail,
				$pay_date
			);

			if ($direct_bonus_commission == false) {
				throw new Exception("Could give direct_bonus_commission", 1);
			}

		}

	/*	//binary bonus
		//binary bonus is not this way
		if (true == false){

			$binary_bonus = $setting['binary_bonus']->settingsArray;
				foreach ($binary_bonus['binary_bonus'] as $level => $bonus) {
					$pack_id = "pack_".$detail['investment']['pack_id'];
		
					if (! isset($uplines[$level])) {continue;}
		
					$receiver = $uplines[$level];
		
					//ensure receiver is qualified for compensational bonuses
					if (! $receiver->can_received_compensation()) {continue;}
		
					
					//ensure receiver has 2 personally sponsored active members
					if (! $receiver->is_qualified_distributor()) {continue;}
		
		
					$percent = $bonus[$pack_id];
					if ($percent == 0) {continue;}
		
					$days_from_registration = intval((time() - strtotime($receiver['created_at']))/ (24*60*60));
					if ($days_from_registration > $binary_bonus['expiry_in_days']) {continue;}
		
					$is_paid_every = $binary_bonus['is_paid_every'];
					$pay_date = date("Y-m-d 20:00:00" , strtotime("next $is_paid_every"));
		
					$binary_bonus_earned = $percent * 0.01 * $sale;
		
					$identifier="BB#O$this->id#B$buyer->id#L$level#R$receiver[id]";
		
		
		
					$extra_detail = json_encode([
						'reason' => 'binary_bonus'
					]);
		
		
					//credit Direct Bonus
					$comment = "Level $level Binary Bonus";
					$binary_bonus_commission =Commission::createTransaction(
						'credit',
						$receiver['id'],
						$buyer['id'],
						$binary_bonus_earned,
						'completed',
						'binary_bonus',
						$comment,
						$identifier, 
						$this->id, 
						null,
						$extra_detail,
						$pay_date
					);
		
					if ($binary_bonus_commission == false) {
						throw new Exception("Could give binary_bonus_commission", 1);
					}
				}
				
		}
*/


		//matching bonus
		/*$matching_bonus = $setting['matching_bonus']->settingsArray;
		foreach ($matching_bonus as $level => $bonus) {
			$pack_id = "pack_".$detail['investment']['pack_id'];
			if (! isset($uplines[$level])) {continue;}
			$receiver = $uplines[$level];
			if (! isset($bonus[$pack_id])) {continue;}
			 $percent = $bonus[$pack_id];
			if ($percent == 0) {continue;}

			//ensure receiver is qualified for compensational bonuses
			if (! $receiver->can_received_compensation()) {continue;}


			$matching_bonus_earned = $percent * 0.01 * $sale;

			$identifier="MB#O$this->id#B$buyer->id#L$level#R$receiver[id]";



			$extra_detail = json_encode([
				'reason' => 'matching_bonus'
			]);


			//credit Matching Bonus
			$comment = "Level $level Matching Bonus";
			$matching_bonus_commission =Commission::createTransaction(
				'credit',
				$receiver['id'],
				$buyer['id'],
				$matching_bonus_earned,
				'completed',
				'matching_bonus',
				$comment,
				$identifier, 
				$this->id, 
				null,
				$extra_detail,
				$pay_date
			);

			if ($matching_bonus_commission == false) {
				throw new Exception("Could give matching_bonus_commission", 1);
			}
		}
*/




		//auto bonus
		$auto_bonus = $setting['auto_bonus']->settingsArray;
		foreach ($auto_bonus['auto_bonus'] as $level => $bonus) {
			$pack_id = "pack_".$detail['investment']['pack_id'];

			if (! isset($uplines[$level])) {continue;}
			$receiver = $uplines[$level];

			if (! isset($bonus['billing_percent'])) {continue;}
			echo $percent = $bonus['billing_percent'];
			if ($percent == 0) {continue;}
		

			//ensure receiver is qualified for compensational bonuses
			if (! $receiver->can_received_compensation()) {continue;}


			$auto_bonus_earned = $percent * 0.01 * $sale;

			$identifier="AB#O$this->id#B$buyer->id#L$level#R$receiver[id]";

			$extra_detail = json_encode([
				'reason' => 'auto_bonus'
			]);

			//credit Direct Bonus
			$comment = "Level $level Auto Bonus";
			$auto_bonus_commission =Commission::createTransaction(
				'credit',
				$receiver['id'],
				$buyer['id'],
				$auto_bonus_earned,
				'completed',
				'auto_bonus',
				$comment,
				$identifier, 
				$this->id, 
				null,
				$extra_detail,
				$pay_date
			);

			if ($auto_bonus_commission == false) {
				throw new Exception("Could give auto_bonus_commission", 1);
			}
		}

	}



	public function give_speaker_bonus()
	{	

		$today = date("Y-m-d H:i:s");

		$detail = $this->ExtraDetailArray;
		$sale = $detail['capital'];


		$setting = SiteSettings::all()->keyBy('criteria');
		$uplines = collect($this->user->referred_members_uplines(7))->toArray();
		$buyer = $this->user;

		//ensure receiver is qualified for compensational bonuses
		// if (! $receiver->can_received_compensation()) {continue;}


		$speaker_bonus = $setting['speaker_bonus']->settingsArray;

		$conference_date = "2020-03-01";

	  	$diff_registration_and_purchase = intval((strtotime($buyer['created_at'])- strtotime($conference_date) )/ (24*60*60));


		if (($diff_registration_and_purchase > $speaker_bonus['until_x_days_after_presentation']) || ($diff_registration_and_purchase < 0)) {return;}

		print_r($speaker_bonus);
		$percent = $speaker_bonus['speaker_receives_percent'];
		$conference_turnover = $speaker_bonus['turnover_of_conference_percent'];

		$speaker_bonus_earned = $percent * 0.01 * $sale;


		$identifier="SB#O$this->id#B$buyer->id#L0#R$receiver[id]";

		$extra_detail = json_encode([
			'reason' => 'speaker_bonus'
		]);



		//credit speaker Bonus
		$comment = "Self Speaker Bonus";
		$speaker_bonus_commission =Commission::createTransaction(
			'credit',
			$receiver['id'],
			$buyer['id'],
			$speaker_bonus_earned,
			'completed',
			'speaker_bonus',
			$comment,
			$identifier, 
			$this->id, 
			null,
			$extra_detail,
			$today
		);

		if ($speaker_bonus_commission == false) {
			throw new Exception("Could give speaker_bonus_commission", 1);
		}

	}




	public function give_office_bonus()
	{	

		$today = date("Y-m-d H:i:s");

		$detail = $this->ExtraDetailArray;
		$sale = $detail['capital'];


		$setting = SiteSettings::all()->keyBy('criteria');
		$uplines = collect($this->user->referred_members_uplines(7))->toArray();
		$buyer = $this->user;

		$office_bonus = $setting['office_bonus']->settingsArray;
			//ensure receiver is qualified for compensational bonuses
			// if (! $receiver->can_received_compensation()) {continue;}



		$percent = $office_bonus['office_opener_receives_percent'];
		$turnover = $office_bonus['turnover_of_country_or_city_percent'];

		$office_bonus_earned = $percent * 0.01 * $sale;

		$identifier="OB#O$this->id#B$buyer->id#L0#R$receiver[id]";


		$extra_detail = json_encode([
			'reason' => 'office_bonus'
		]);

		//credit Direct Bonus
		$comment = "Self Office Bonus";
		$office_bonus_commission =Commission::createTransaction(
			'credit',
			$receiver['id'],
			$buyer['id'],
			$office_bonus_earned,
			'completed',
			'office_bonus',
			$comment,
			$identifier, 
			$this->id, 
			null,
			$extra_detail,
			$today
		);

		if ($office_bonus_commission == false) {
			throw new Exception("Could give office_bonus_commission", 1);
		}

	}










	public function give_direct_bonus($sale)
	{

		echo "string";



	}


	public function scopeNotRunning($query)
	{
		return $query->where('running_status', 0);
	}

	public function scopeRunning($query)
	{
		return $query->where('running_status', 1);
	}

	public function is_completed()
	{
		$response = self::CompleteInvestment()->where('id', $this->id)->count() > 0;
		return $response;
	}

	public function scopeCompleteInvestment($query)
	{

		$is_complete_identifier = '"is_complete":1';
		return	$query->where('extra_detail', 'like', "%$is_complete_identifier%");

	}

	public function scopeUnCompleteInvestment($query)
	{

		$is_complete_identifier = '"is_complete":0';
		return	$query->where('extra_detail', 'like', "%$is_complete_identifier%");

	}




	public static function split_investment($user_id,$date=null)
	{
		
		$rules_settings =  SiteSettings::find_criteria('rules_settings');
		$setting = $rules_settings->settingsArray;


		$heldcoin_percent =  $setting['income_split_percent']['trucash_percent'];  //put in held coin
		$hotwallet_percent =  $setting['income_split_percent']['cash_percent'];  //put in held coin

		$grace_period = $setting['income_split_percent']['grace_period_to_sell_hot_wallet']; 

		$today = date("Y-m-d");
		$daterange = MIS::date_range($today, 'month', true);

		$this_month = date("m");
		$this_year = date("Y");



		$identfier = <<<EOL
		 {"reason":"split_investment","iteration":"1"
EOL;		

		$identfier = trim($identfier);
		


		$already_splitted = HeldCoin::for($user_id)
									->Credit()
									->Category('hot_wallet')
									->whereDate('paid_at','>=',  $daterange['start_date'])->whereDate('paid_at', '<=',$daterange['end_date'])
									->where('extra_detail', 'like', "%$identfier%")
									->first();
									



		$diff = (time() - strtotime($already_splitted->paid_at)) /(24* 60*60) ;

		//ensure left coin has stayed for graceperiod
		if (($diff < $grace_period)) {
			return;
		}



		if ($already_splitted != null) {
			//not first time
	    	$remaining_in_hot_wallet = self::availableBalanceOnUser($user_id, 'hot_wallet') ;

			$amount_going_to_heldcoin = $remaining_in_hot_wallet;

			$comment = "Move balance from HotWallet to Heldcoin";



			if ($amount_going_to_heldcoin <= 0) {
				echo "secondtime";
				return;
			}

			// return;
			self::moveUnsoldWallet($user_id);

		}else{
			echo "firsttime";
			//first time

			self::SplitInvestmentRoi($user_id);

		}


	}


	private static function SplitInvestmentRoi($user_id)
	{

		$rules_settings =  SiteSettings::find_criteria('rules_settings');
		$setting = $rules_settings->settingsArray;


		$heldcoin_percent =  $setting['income_split_percent']['trucash_percent'];  //put in held coin
		$hotwallet_percent =  $setting['income_split_percent']['cash_percent'];  //put in held coin



		$book_balance = self::availableBalanceOnUser($user_id, 'investment');
		$amount_going_to_heldcoin = $heldcoin_percent * 0.01 * $book_balance;
		$amount_going_to_hotwallet = $hotwallet_percent * 0.01 * $book_balance;


		if ($book_balance == 0) {
			return;
		}

		$today = date("Y-m-d H:i:s");


		$month = date("Y-m", strtotime($today));
		$identifier = "1_split_investment_roi_{$user_id}_$month";

		DB::beginTransaction();
		try {

			$comment = "Split investment roi to $hotwallet_percent% hotwallet and $heldcoin_percent% heldcoin";

			$extra_detail = json_encode([
				'reason' => 'split_investment',
				'iteration' => '1',
			]);
			
			$debit =self::createTransaction(
				'debit',
				$user_id,
				null,
				$book_balance,
				'completed',
				'investment',
				$comment,
				$identifier.'d', 
				null, 
				null,
				$extra_detail,
				$today
			);

			if ($debit == false) {
				throw new \Exception("Could not debit HotWallet investment", 1);
			}

			$comment = "Move $hotwallet_percent% from Investment ROI to HotWallet";
			

			$credit =self::createTransaction(
				'credit',
				$user_id,
				null,
				$amount_going_to_hotwallet,
				'completed',
				'hot_wallet',
				$comment,
				$identifier.'c', 
				null, 
				null,
				$extra_detail,
				$today
			);

			if ($credit == false) {
				throw new \Exception("Could not credit from hotwallet investment to  hotwallet", 1);
			}

			$comment = "Move $heldcoin_percent% from HotWallet to Heldcoin";
			$credit =HeldCoin::createTransaction(
				'credit',
				$user_id,
				null,
				$amount_going_to_heldcoin,
				'completed',
				'hot_wallet',
				$comment,
				$identifier, 
				null, 
				null,
				$extra_detail,
				$today
				
			);

			if ($credit == false) {

				throw new \Exception("Could not credit split fomr hotwallet to Heldcoin", 1);
			}




			DB::commit();
		} catch (Exception $e) {

			print_r($e->getMessage());

			DB::rollback();
			
		}
	}

	/**
		$date is the datestring which month is the month 
		to consider when moving hotwallet balance not sold to company
	*/
	private static function moveUnsoldWallet($user_id)
	{

		

		$comment = "Move from HotWallet to Heldcoin";

		$book_balance = self::availableBalanceOnUser($user_id, ['hot_wallet']);

		$amount_going_to_heldcoin  = $book_balance;

		$extra_detail = json_encode([
			'reason' => 'split_investment',
			'iteration' => '2',
		]);
		

		$today = date("Y-m-d H:i:s");

		$month = date("Y-m", strtotime($today));
		$identifier = "2_split_investment_roi_{$user_id}_$month";
		DB::beginTransaction();
		try {

			
				
			$debit =self::createTransaction(
				'debit',
				$user_id,
				null,
				$amount_going_to_heldcoin,
				'completed',
				'hot_wallet',
				$comment,
				$identifier, 
				null, 
				null,
				$extra_detail,
				$today
			);

			if ($debit == false) {
				throw new \Exception("Could not debit", 1);
			}

				
			$credit =HeldCoin::createTransaction(
				'credit',
				$user_id,
				null,
				$amount_going_to_heldcoin,
				'completed',
				'hot_wallet',
				$comment,
				$identifier, 
				null, 
				null,
				$extra_detail,
				$today
				
			);

			if ($credit == false) {

				throw new \Exception("Could not credit", 1);
			}




			DB::commit();
		} catch (Exception $e) {

			print_r($e->getMessage());

			DB::rollback();
			
		}




	}

    public function getPauseUrlAttribute()
    {
    		$href =  Config::domain()."/package_crud/pause_package/".$this->id;
    		return $href ;
	  
    }



    public function pause()
    {

    	if ($this->is_completed()) {

    		Session::putFlash("danger","unable to pause completed pack");
    		return;
    	}

    	DB::beginTransaction();

    	try {
    		
    		$this->update(['running_status'=> 0]);

    		DB::commit();
    		Session::putFlash("success","Pack paused successfully");

    		return true;
    	} catch (Exception $e) {
    		DB::rollback();
    		Session::putFlash("danger","unable to pause the pack");
    		return false;
    	}


    }

    public function play()
    {

    	if ($this->is_completed()) {

    		Session::putFlash("danger","unable to pause completed pack");
    		return;
    	}


    	DB::beginTransaction();

    	$current_return  = $this->amount; //return  before paused
    	$today = date("Y-m-d"); 


    	//determine the last paid date
    	$detail = $this->ExtraDetailArray;
    	$amount_paid = [];
    	foreach ($detail['spread'] as $date_paid => $value) {
    			$total_paid = array_sum($amount_paid) ;
    			$pay = $total_paid ;
    		if ($pay > $current_return ) {
    			$last_pay_date = [
    					'date' =>	$last_date,
    					'amount' =>	$total_paid
    			];
    			break;
    		}
    		$last_date = $date_paid;
    		$amount_paid[] = $value;
    	}

    	$new_spread = [];
    	$start_date = date("Y-m-d");
		$weekly = date("Y-m-d", strtotime("$start_date +7 days"));


		 $last_pay_date['date'];
    	$new_spread = $detail['spread'];
    	//generate a new spread
    	foreach ($new_spread as $date_paid => $value) {
    		if (strtotime($last_pay_date['date']) >= strtotime($date_paid) ) {    			
    			$continued_spread[$date_paid] = $value;
    		}else{
    			$continued_spread[$weekly] = $value;    		
				$weekly = date("Y-m-d", strtotime("$weekly +7 days"));
    		}
    	}


    	$new_total =  array_sum($continued_spread);
    	if (round($detail['total_worth'],2) != round( $new_total, 2)) {
    		return;
    	}


    	$new_detail = $detail;
    	$new_detail['spread'] = $continued_spread;


    	try {
    		
    		$this->update([
    						'running_status'=> 1 , 
    						'extra_detail'=>  json_encode($new_detail)
    					]);

    		DB::commit();
    		Session::putFlash("success","Pack resumed successfully");

    		return true;
    	} catch (Exception $e) {
    		DB::rollback();
    		Session::putFlash("danger","unable to resume the pack");
    		return false;
    	}
    }


	public function getPlayStatusAttribute()
	{

		if ($this->running_status == 1) {

			$return = "<span class='badge badge-success'>Running</span>";
		}else{

			$return = "<span class='badge badge-info'>Paused</span>";
		}

		return $return;
	}


	public function getRoiStatusAttribute()
	{

		$status = InvestmentPackage::is_roi_complete_on($this->id);

		if ($this->maturity >= 100) {

			$return = "<span class='badge badge-success'>completed</span>";
		}else{

			$return = "<span class='badge badge-info'>ongoing</span>";
		}

		return $return;
	}

	public function getLastPaidDateAttribute()
	{
		$returns = HotWallet::bookBalanceOnUser($this->user, 'hot_wallet');
		return $returns;
	}


	public function getReturnsAttribute()
	{
		return $this->amount;
		$returns = HotWallet::bookBalanceOnUser($this->user, 'hot_wallet');
		return $returns;
	}


	public function getmaturityAttribute()
	{

		$target = $this->ExtraDetailArray['total_worth'];
		$growth = (($this->Returns / $target) * 100 );
		$maturity = round($growth, 2);
		return $maturity;
	}





}


















?>