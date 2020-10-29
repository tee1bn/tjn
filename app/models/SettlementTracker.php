<?php

use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\Wallet;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SettlementTracker extends Eloquent 
{
	
	protected $fillable = [
		'user_id',
		'user_no',
		'period',
		'dump',
		'settled_disagio',
		'settled_license_fee',
		'setup_fee',
		'setup_fee_commission_distributed_at',
		'no_of_merchants',
		'paid_at',
	];
	

	protected $table = 'settlement_tracker';





	public function user()
	{
		return $this->belongsTo('User', 'user_id');

	}

	public function give_setup_fee_commission()
	{

		$settings= SiteSettings::commission_settings();
		$user 	 = $this->user;

		$month_index = date('m', strtotime($this->period));
		$month 	 = date('F Y', strtotime($this->period));

		$tree = $user->referred_members_uplines(3);



		$setup_fee = $this->setup_fee;
		
		$credit = [];

		DB::beginTransaction();

		try {
			

			foreach ($tree as $level => $upline) {
				$percent = $settings[$level]['setup'];
				$amount_earned = $percent * 0.01 * $setup_fee;
				$comment = "{$month} Set up fee Bonus $percent% of set up fee";

				if ($level == 0) {
					$comment = "{$month} Set up fee Self Bonus $percent% of set up fee";
				}

				// ensure  upliner is qualified for commission
				if (! $upline->is_qualified_for_commission($level)) {
					continue;
				}


				//ensure comission eligibility
				
				if (! $upline->commission_eligibility($this->period)) {
					continue;
				}



				//continue if amount is 0
				if ($amount_earned == 0) {continue;}

    			$payment_date_range = MIS::date_range($this->period, 'month', true);
		 		$paid_at = $payment_date_range['end_date'];

				$paid_at = date("Y-m-d H:i:s");
				$identifier = "setup_fee{$upline->id}$this->user_id/$this->period";
				$extra = json_encode([
					'period' => $this->period
				]);


				try {
					

					$credit['setup_fee'][]   = Wallet::createTransaction(	
												'credit',
												$upline['id'],
												$this->user_id,
												$amount_earned,
												'completed',
												'setup_fee',
												$comment ,
												$identifier, 
												$this->id , 
												null,
												$extra,
												$paid_at
											);

				} catch (Exception $e) {

					print_r($e->getMessage());
					
				}


			}


			/**
			 * this means that setup_fee commission have been paid (ie treated )
			 */
			$this->mark_setup_fee_paid();
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
			
		}


		



	}




	public function give_commission()
	{
		$settings= SiteSettings::commission_settings();
		$user 	 = $this->user;

		$month_index = date('m', strtotime($this->period));
		$month 	 = date('F Y', strtotime($this->period));

		$tree = $user->referred_members_uplines(3);

		$disagio = $this->settled_disagio;
		$license_fee = $this->settled_license_fee;

	
		$credit = [];

		DB::beginTransaction();

		echo "string";

		try {
			

			foreach ($tree as $level => $upline) {
				$percent_disagio = $settings[$level]['disagio'];
				$amount_earned = $percent_disagio * 0.01 * $disagio;
				$comment = "{$month} Support Fee Bonus $percent_disagio% of support fee";

				if ($level == 0) {
					$comment = "{$month} Support Fee Self Bonus $percent_disagio% of support fee";
				}

							// ensure  upliner is qualified for commission
				if (! $upline->is_qualified_for_commission($level)) {
					continue;
				}
				
				if (! $upline->commission_eligibility($this->period)) {
					continue;
				}



    			$payment_date_range = MIS::date_range($this->period, 'month', true);
		 		$paid_at = $payment_date_range['end_date'];
		 		
				$identifier = "disagio{$upline->id}$this->user_id/$this->period";
				$extra = json_encode([
					'period' => $this->period
				]);

				try {
					

					$credit['disagio'][]   = Wallet::createTransaction(	
												'credit',
												$upline['id'],
												$this->user_id,
												$amount_earned,
												'completed',
												'disagio',
												$comment ,
												$identifier, 
												$this->id , 
												null,
												$extra,
												$paid_at
											);

				} catch (Exception $e) {
					
				}


				$percent_license = $settings[$level]['license'];
				$amount_earned = $percent_license * 0.01 * $license_fee;
				$comment = "{$month} License Bonus $percent_license% of license ";

				if ($level == 0) {
					$comment = "{$month} License Self Bonus $percent_license% of license ";
				}

				// ensure  upliner is qualified for commission
/*				if (! $upline->is_qualified_for_commission($level)) {
					continue;
				}

*/				$identifier = "license{$upline->id}$this->user_id/$this->period";
				$extra = json_encode([
					'period' => $this->period
				]);


				try {
					

					$credit['license'][]  = Wallet::createTransaction(	
												'credit',
												$upline['id'],
												$this->user_id,
												$amount_earned,
												'completed',
												'license',
												$comment ,
												$identifier, 
												$this->id , 
												null,
												$extra,
												$paid_at
											);

				} catch (Exception $e) {
					
				}


			}
			/**
			 * this means that disagio and license commission have been paid (ie treated )
			 */
			$this->mark_paid();
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
			
		}


	}


	public function mark_setup_fee_paid()
	{
		$this->update(['setup_fee_commission_distributed_at' => date("Y-m-d H:i:s")]);
	}
	public function mark_paid()
	{
		$this->update(['paid_at' => date("Y-m-d H:i:s")]);
	}

	public function getPeriodDaterangeAttribute()
	{
		return MIS::date_range($this->period);
	}


}


















?>