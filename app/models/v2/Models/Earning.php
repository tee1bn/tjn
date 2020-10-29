<?php

namespace v2\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use SiteSettings, User;

class Earning extends Eloquent 
{
	
	protected $fillable = [
							'user_id',
							'order_id',
							'admin_id',
							'upon_user_id',
							'amount',
							'type',
							'earning_category',
							'status',
							'identifier',
							'comment',
							'extra_detail'	
						];


	protected $table 	  = 'earnings';


	public static function give_bonus($user_id, $upon_user_id=null)
	{

		$identifier = "$user_id welcome bonus";
		$amount = 500;
		$comment = "welcome bonus";
		try {
			
			$credit  = self::createTransaction(
												'credit',
												$user_id,
												$upon_user_id,
												$amount,
												'pending',
												'bonus',
												$comment,
												$identifier 
											);
			return $credit;
		} catch (Exception $e) {

			print_r($e->getMessage());
			die();
		}


	}


	public static function bookBalanceOnUser($user_id)
	{
		$credits = self::scopeCompletedCreditOnUser($user_id)->sum('amount');
		$debits = self::scopeCompletedDebitOnUser($user_id)->sum('amount');

		$book_balance = $credits - $debits;
		return $book_balance;
	}	



	public static function accruedBookBalanceOnUser($user_id)
	{
		$credits = self::onUser($user_id)->Credit()->where('status', '!=', 'cancelled')->sum('amount');
		$initiated_debits = self::scopeInitiatedDebitOnUser($user_id)->sum('amount');

		return $credits - $initiated_debits;
	}	

	

	public static function availableBalanceOnUser($user_id)
	{
		$credits = self::scopeCompletedCreditOnUser($user_id)->sum('amount');
		$initiated_debits = self::scopeInitiatedDebitOnUser($user_id)->sum('amount');

		$available =  $credits - $initiated_debits;
		$available =  max($available , 0);

		$settings = SiteSettings::site_settings();


		$withdrawable = $settings['min_withdrawable'] * 0.01 * $available;

		//use percent withdrawable if applicable

		return $withdrawable ;	
	}	

	
	/**
	 * Debits including completed and pending
	 *
	 * @param      <type>  $user_id  The user identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public  static function scopeInitiatedDebitOnUser($user_id)
	{
		return 	self::onUser($user_id)->Debit()->where('status', '!=', 'cancelled');
	}



	public  static function scopeCompletedCreditOnUser($user_id)
	{
		return 	self::onUser($user_id)->Credit()->Completed();
	}


	public  static function scopePendingCreditOnUser($user_id)
	{
		return 	self::onUser($user_id)->Credit()->Pending();
	}


	public  static function scopeCancelledCreditOnUser($user_id)
	{
		return 	self::onUser($user_id)->Credit()->Cancelled();
	}





	public  static function scopeCompletedDebitOnUser($user_id)
	{
		return 	self::onUser($user_id)->Debit()->Completed();
	}


	public  static function scopeCancelledDebitOnUser($user_id)
	{
		return 	self::onUser($user_id)->Debit()->Cancelled();
	}


	public  static function scopePendingDebitOnUser($user_id)
	{
		return 	self::onUser($user_id)->Debit()->Pending();
	}


	public static function setBalanceTo($user_id , $balance, $comment=null, $admin_id=null)
	{
		$book_balance = self::bookBalanceOnUser($user_id);


			$amount = abs($book_balance - $balance);

		if ($book_balance > 0) {
			$type = 'debit';

		}elseif ($book_balance < 0) {
			$type = 'credit';

		}else{
			return ;
		}


		$transaction =self::createTransaction(
									$type,
									$user_id,
									null,
									$amount,
									'completed',
									'bonus',
									$comment,
									null,
									null,
									$admin_id
								);

		return $transaction;
	}



	public static  function createTransaction(	$type,
									$user_id,
									$upon_user_id,
									$amount,
									$status,
									$earning_category = null,
									$comment = null,
									$identifier = null, 
									$order_id = null, 
									$admin_id = null)
	{

		if ($amount == 0) {
			return;
		}


		if ($type=='debit') {
			//confirm available balance

		}



		try{

			$earning =		self::create([
								'type'	=> $type,
								'user_id'=>	$user_id,
								'upon_user_id'=> $upon_user_id,
								'amount' => $amount,
								'status' => $status,
								'earning_category' => $earning_category,
								'comment' => $comment,
								'identifier' => $identifier ,
								'order_id' => $order_id ,
								'admin_id' => $admin_id ,
							]);

			return $earning;

		}catch(Exception $e){
			print_r($e->getMessage());
		}

		return false;
	}


	public function scopeCompleted($query)
	{
		return $query->where('status', 'completed');
	}

	public function scopePending($query)
	{
		return $query->where('status', 'pending');
	}

	public function scopeCancelled($query)
	{
		return $query->where('status', 'cancelled');
	}


	public function scopeCredit($query)
	{
		return $query->where('type', 'credit');
	}

	public function scopeDebit($query)
	{
		return $query->where('type', 'debit');
	}


	public static function for($user_id)
	{
		return self::where('user_id', $user_id);
	}

	public static function onUser($user_id)
	{
		return self::where('user_id', $user_id);
	}




    public function getdisplayedTypeAttribute()
    {

        switch ($this->type) {
            case 'credit':
            return "<span class='badge badge-sm badge-primary'>Credit</span>";
                break;
            
            case 'debit':
            return "<span class='badge badge-sm badge-danger'>Debit</span>";
                break;            
        }
        
    }



}


















?>