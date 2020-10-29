<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class LevelIncomeReport extends Eloquent 
{
	
		protected $fillable = [
							'owner_user_id',
							'downline_id',
							'amount_earned',
							'status',
							'availability',
							'commission_type',
							'extra_detail',
							'proof',
							'order_id',
							'payment_month', //when this got earned
							];
	
	protected $table = 'level_income_report';



	public function payout_for_month($user_id, $month)
	{
	  	return LevelIncomeReport::where('owner_user_id', $user_id)
	  							->where('status','Credit')
	  							->whereMonth('created_at', $month);
	 }




	public function general_payout_for_month($month)
	{

		$date_range = MIS::date_range($month);
		$payout =   self::where('status','Credit')
						->whereDate('payment_month', '>=', $date_range['start_date'])
						->whereDate('payment_month', '<=' ,$date_range['end_date']);
											
		return $payout;
	 }



	public function scopeCredits($query)
	{
		return $query->where('status', 'Credit');
	}

	public function scopeDebits($query)
	{
		return $query->where('status', 'Debit');
	}


	public static function all_withdrawals()
	{
		return self::where('status','Debit');

	}


    public static function available_balance($user_id)
    {
    
    	return 	self::sum_total_earnings($user_id) - self::total_withdrawals($user_id);
	}

	
    public static function total_withdrawals($user_id)
    {
    
    	return 	self::withdrawals($user_id)->sum('amount_earned');
	}




   public static function withdrawals($user_id)
   {

  		return LevelIncomeReport::where('owner_user_id', $user_id)
  								->where('status','Debit')
  								->where('commission_type','!=', 'Withdrawal Cancelled');
	}


 	public static function withdrawals_history($user_id)
   	{

  		return LevelIncomeReport::all_withdrawals()->where('owner_user_id', $user_id);
	}


	/**
	 * [sum_total_earnings calculates the total earnings of this user]
	 * @return [int] [description]
	 */
	public static function sum_total_earnings($user_id)
	{

		return self::earnings($user_id)->sum('amount_earned');
	}


	  /**
	   * [earnings returns records of this users earnings]
	   * @return [query buider] [description]
	   */
	  public static function earnings($user_id)
	  {
	  	return LevelIncomeReport::where('owner_user_id', $user_id)
	  							->where('status','Credit');
	  	}





	public function create_withdrawal_request($user_id, $amount, $extra_detail=null )
	{

			$balance = self::available_balance($user_id);

			$currency = Config::currency();
			$settings = SiteSettings::site_settings();
			$available_balance =  $settings['withdrawable_percent'] * 0.01 * $balance;      


	 	if ($amount > $available_balance) {
			Session::putFlash('danger',"Sorry, You cannot withdraw more than your available balance  $currency$withdrawable_balance. ");
	 		return;
	 	}


		$withdrawal_request = self::create([
							'owner_user_id'	=> $user_id,
							'amount_earned'	=> $amount,
							'status'	=> 'Debit',
							'commission_type'	=> 'Withdrawal Request',
							'extra_detail'	=> $extra_detail,
							]);
		Session::putFlash('success', 'Withdrawal request successful');

		return $withdrawal_request;

	}



	public static function credit_user($user_id, $amount, $comment , $downline_id=null, $order_id=null, $payment_month=null)
	{
		$credit= null;
		try {
			

			$credit = self::create([
								'owner_user_id'	=> $user_id,
								'downline_id'	=> $downline_id,
								'amount_earned'	=> $amount,
								'status'	=> 'Credit',
								'commission_type'	=> $comment,
								'order_id'	=> $order_id,
								'payment_month'	=> $payment_month,
								]);
		} catch (Exception $e) {
			
		}

		return $credit;
	}


	public function cancel_withdrawal_request()
	{
			if (($this->status == 'Debit') && ($this->commission_type == 'Withdrawal Request')) {

				$this->update(['commission_type' => 'Withdrawal Cancelled']);			
				
				Session::putFlash('success',"#{$this->id} Withdrawal Cancelled Successfully!");
				return $this;
			}
			Session::putFlash('danger',"#{$this->id} Withdrawal Not Cancelled!");
	}


	public function mark_withdrawal_paid()
	{
			if (($this->status == 'Debit') && ($this->commission_type == 'Withdrawal Request')) {

				$this->update(['commission_type' => 'Withdrawal Paid']);			
				
				// Session::putFlash('success',"#{$this->id} Payout marked Paid Successfully!");
				return $this;
			}
			// Session::putFlash('danger',"#{$this->id} Payout Not marked!");
	}


	public function upload_withdrawal_payment_proof($file)
	{
				$directory  = 'uploads/images/withdrawal_proofs';
				$handle = new Upload($file);

                //if it is image, generate thumbnail
                if (explode('/', $handle->file_src_mime)[0] == 'image') {

					$handle->Process($directory);
			 		$original_file  = $directory.'/'.$handle->file_dst_name;

					(new Upload($this->proof))->clean();
					$this->update(['proof' => $original_file]);


					return $this;
				}

	}



	public function total_credits($user_id)
	{
			return LevelIncomeReport::where('owner_user_id', $user_id)->where('status','Credit');
	}




	public function owned_by()
	{
		return $this->belongsTo('User', 'owner_user_id');
	}





	public function earned_off()
	{
		return $this->belongsTo('User', 'downline_id');
	}





	public function getuplinelevelAttribute($value)
    {
	if ($value == 0 ) {
	        return 'Self';
    	}

	   	return $value;

    }




}


















?>