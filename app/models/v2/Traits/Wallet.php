<?php

namespace v2\Traits;
include_once 'app/controllers/home.php';
use Illuminate\Database\Capsule\Manager as DB;

use SiteSettings, User, Config, Notifications, Session, home, MIS, Mailer;


use  v2\Models\InvestmentPackage;
use  v2\Models\Wallet as WalletMap;


/**
 * 
 */
trait Wallet 
{


	public function getgetOrderIdAttribute()
	{

		if ($this->order_id == null) {
			return false;
		}	

		return $this->order_id;
	}




	public function order()
	{

		if ($this->order_id == null) {
			return false;
		}

		$domain = Config::domain();

		$detail = $this->ExtraDetailArray;

		$item_purchased = $detail['item_purchased'] ?? 'default';

		$pages = [
			'default' => "investment-purchases"
		];

		// $item = ""

		$page_link = $pages[$item_purchased];
		$admin_link = "$domain/admin/$page_link?ref={$this->order_id}";



		$user_link = "";

		return $admin_link;

	}


	
	public function upon()
	{
		return $this->belongsTo('User', 'upon_user_id');

	}
	

	
	public function user()
	{
		return $this->belongsTo('User', 'user_id');

	}


	public function is_complete()
	{
		return $this->status == 'completed';
	}

	public function is_pending()
	{
		return $this->status == 'pending';
	}
	


	public function getExtraDetailArrayAttribute()
	{
		if ($this->extra_detail == null) {
			return [];
		}

		return json_decode($this->extra_detail, true);
	}

	public function getcheckoutUrlAttribute()
	{


		$callback_param = http_build_query([
			'item_purchased'=> $this->name_in_shop,
			'order_unique_id'=> $this->id,
			'payment_method'=> $this->payment_method,
		]);

		$domain = Config::domain();
		$checkout_url = "$domain/shop/make_livepay_payment?$callback_param";

		return $checkout_url;


	}
	
	public function invoice()
	{

		$detail = $this->ExtraDetailArray;
		$summary = [
			[
				'item' => $detail['investment']['name'],
				'description' => $this->comment,
				'rate' => $detail['capital'],
				'qty' => 1,
				'amount' => $detail['capital'],
			]
		];

		$subtotal = [
			'subtotal'=> $detail['capital'],
			'lines' => [
				'tax'=> [
					'name'=> 'TAX (0%)',
					'percent'=> 0,
					'value'=> 0,
				],
			],

			'total'=> $detail['capital'],
		];

		$invoice = [
			'order_id' => $this->id,
			'invoice_id' => $this->id,
			'order_date' => $this->created_at,
			'payment_status' => "PAID",
			'summary' => $summary,
			'subtotal' => $subtotal,
		];

		return $invoice;

	}

	

	public  function getInvoice()
	{

		$controller = new home;
		$order = $this;
		$view  =	$controller->buildView('auth/order_detail', compact('order'));
		
		$mpdf = new \Mpdf\Mpdf([
			'margin_left' => 5,
			'margin_right' => 5,
			'margin_top' => 10,
			'margin_bottom' => 20,
			'margin_header' => 10,
			'margin_footer' => 10
		]);

		$company_name = Config::project_name();
		$logo = Config::logo();

		$mpdf->AddPage('P');
		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("{$company_name}");
		$mpdf->SetAuthor($company_name);
		// $mpdf->SetWatermarkText("{$company_name}");
		// $mpdf->watermarkImg("$logo");
		$mpdf->showWatermarkText = true;
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');

		$date_now = (date('Y-m-d H:i:s'));

		$mpdf->SetFooter("Date Generated: " . $date_now . " - {PAGENO} of {nbpg}");



		$mpdf->WriteHTML($view);
		$mpdf->Output("invoice#$order->id.pdf", \Mpdf\Output\Destination::INLINE);			

	}


	
	
	public function getTokenAmountAttribute()
	{

		$rules_settings =  SiteSettings::find_criteria('rules_settings');
		$setting = $rules_settings->settingsArray;

		$trucash_exchange = $setting['one_trucash_is_x_usd'];

		$token_amount = $this->amount / $trucash_exchange ;
		return $token_amount;
	}


	



	public static function makeTransfer($from, $to, $amount, $earning_category, $recipient_wallet)
	{

		DB::beginTransaction();

		$sending_user = User::find($from);
		$receiving_user = User::find($to);
		$comment = "$amount Transfer From $sending_user->username to $receiving_user->username";



		$rules_settings =  SiteSettings::find_criteria('rules_settings');
		$transfer_fee_percent = $rules_settings->settingsArray['user_transfer_fee_percent'];
		$min_transfer = $rules_settings->settingsArray['min_transfer_usd'];


		$users_involved = "$from&$to";
		$unique_journal_id = uniqid($users_involved);
		$extra_detail = json_encode([
			"from" => $from,
			"to" => $to,
			"from_wallet" => $earning_category,
			"to_wallet" => $recipient_wallet,
			'unique_journal_id'=>$unique_journal_id

		]);


		try {



			$transfer_fee = $transfer_fee_percent * 0.01 * $amount;
			$amount_plus_fee =   $transfer_fee + $amount;

			//make debit first
			$debit =	self::createTransaction(
				'debit',
				$from,
				null,
				$amount,
				'pending',
				$earning_category,
				$comment,
				null, 
				null, 
				null,
				$extra_detail
			);


			if ($debit == false) {
				return false;
			}

			$debit->update([
				'payment_method' => 'transfer',
			]);




				//remove transfer fee
			$transfer_fee_comment ="$comment TransferFee";
			$transfer_fee = $transfer_fee_percent * 0.01 * $amount;
			$fee =	self::createTransaction(
				'debit',
				$from,
				null,
				$transfer_fee,
				'pending',
				$earning_category,
				$transfer_fee_comment,
				null, 
				null, 
				null,
				$extra_detail
			);

			$fee->update([
				'payment_method' => 'transfer',
			]);


			if ($debit == false) {
				return false;
			}



			$wallet_to_use =  WalletMap::$wallets[$recipient_wallet];
			$wallet_class = $wallet_to_use['class'];
			$wallet_category = $wallet_to_use['category'];

			//then make credit 
			$credit = $wallet_class::createTransaction(
				'credit',
				$to,
				null,
				$amount,
				'pending',
				$wallet_category,
				$comment,
				null, 
				null, 
				null,
				$extra_detail
			);

			$credit->update([
				'paid_at' => date("Y-m-d H:i:s"),
				'payment_method' => 'transfer',
			]);

			DB::commit();


			$sender_subject = "Transfer of $amount$ [DEBIT]";
			$receiver_subject = "Transfer of $amount$ [CREDIT]";
			$mailer = new Mailer;
			$controller = new home;

			$sender_content =  $controller->buildView('emails/user_transfer_sender', compact('debit','credit','fee'), true);
			$receiver_content =  $controller->buildView('emails/user_transfer_receiver', compact('debit','credit','fee'), true);


        //sender email
			$mailer->sendMail(
				"{$debit->user->email}",
				"$sender_subject",
				$sender_content,
				"{$debit->user->firstname}"
			);

        //receiver email
			$mailer->sendMail(
				"{$credit->user->email}",
				"$receiver_subject",
				$receiver_content,
				"{$credit->user->firstname}"
			);





		} catch (Exception $e) {
			DB::rollback();

			return false;
		}

		return true;
	}


	public function scopeCategory($query, $category)
	{
		if ($category==null) {
			return $query;
		}

		if (is_array($category)) {

			$up = array_map(function($item){
				$string = "earning_category='$item'";
				return $string;
			}, $category);

			$clause = implode(" OR ", $up);

			return $query->whereRaw("($clause)");
		}

		return $query->where('earning_category', $category);
	}



	
	public function scopeClearedWithin($query, array $daterange)
	{
		extract($daterange);
		$column = 'paid_at';
		return $query->whereDate($column,'>=',  $start_date)->whereDate($column, '<=',$end_date);
	}



	public function scopeCleared($query , $date = null, $range=null)
	{	
		if ($date==null) {
			$today = date("Y-m-d");

		}else{
			$today = $date;
		}

		if ($range == null) {
			
			return $query->whereDate('paid_at','<=', $today);

		}elseif(is_string($range)){

			$daterange = MIS::date_range($today, $range, true);

			return $query->ClearedWithin($daterange);
		}else{
			
			return $query->ClearedWithin($daterange);
		}

	}



	public function scopePaid($query)
	{
		return $query->where('paid_at','!=',null);
	}




	public function scopeUnPaid($query)
	{
		return $query->where('paid_at', '=' ,null);
	}



	//expected money paid(already earned)
	public static function bookBalanceOnUser($user_id, $category=null, $as_at=null, $daterange=null)
	{

		if ($category==null) {
			$credits = self::scopeCompletedCreditOnUser($user_id)->Paid();
			$debits = self::scopeCompletedDebitOnUser($user_id);

		}else{

			$credits = self::scopeCompletedCreditOnUser($user_id)->Category($category)->Paid();
			$debits = self::scopeCompletedDebitOnUser($user_id)->Category($category);

		}


		$credits->Cleared($as_at, $daterange);
		$debits->Cleared($as_at, $daterange);


		$credits = $credits->sum('amount');
		$debits = $debits->sum('amount');


		$book_balance = $credits - $debits;
		$book_balance = round($book_balance, 2);
		return $book_balance;
	}	


	//expected money, not yet paid(Possible earnings)
	public static function accruedBookBalanceOnUser($user_id, $category=null, $as_at=null , $daterange=null)
	{


		if ($category==null) {

			$credits = self::onUser($user_id)->Credit()->where('status', '!=', 'cancelled');
			$initiated_debits = self::scopeInitiatedDebitOnUser($user_id);
		}else{


			$credits = self::onUser($user_id)->Credit()->Category($category)->where('status', '!=', 'cancelled');
			$initiated_debits = self::scopeInitiatedDebitOnUser($user_id)->Category($category);
		}


		$credits->Cleared($as_at, $daterange);
		$initiated_debits->Cleared($as_at, $daterange);

		$credits = $credits->sum('amount');
		$initiated_debits = $initiated_debits->sum('amount');


		return $credits - $initiated_debits;
	}	

	
	//usable money paid and cleared
	public static function availableBalanceOnUser($user_id, $category=null, $as_at=null, $daterange=null)
	{


		if ($category==null) {

			$credits = self::scopeCompletedCreditOnUser($user_id)->Paid();
			$initiated_debits = self::scopeInitiatedDebitOnUser($user_id);

		}else{

			$credits = self::scopeCompletedCreditOnUser($user_id)->Category($category)->Paid();
			$initiated_debits = self::scopeInitiatedDebitOnUser($user_id)->Category($category);

		}


		$credits->Cleared($as_at, $daterange);
		$initiated_debits->Cleared($as_at, $daterange);

		$credits = $credits->sum('amount');
		$initiated_debits = $initiated_debits->sum('amount');


		$available =  $credits - $initiated_debits;

		$available =  max($available , 0);
		$withdrawable =  $available;


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
	public  static function scopeInitiatedDebitOnUser($user_id, $category=null)
	{



		if ($category==null) {


			$initiated_debits =	self::onUser($user_id)->Debit()->where('status', '!=', 'cancelled');

		}else{

			$initiated_debits =	self::onUser($user_id)->Debit()->Category($category)->where('status', '!=', 'cancelled');

		}

		
		return $initiated_debits;
	}



	public  static function scopeCompletedCreditOnUser($user_id, $category=null)
	{


		if ($category==null) {


			$completed_credits =  self::onUser($user_id)->Credit()->Completed();

		}else{

			$completed_credits =	self::onUser($user_id)->Credit()->Completed()->Category($category);

		}

		return 	$completed_credits;
	}




	public  static function scopePendingCreditOnUser($user_id, $category=null)
	{


		if ($category==null) {


			$pending_credits =  self::onUser($user_id)->Credit()->Pending();

		}else{

			$pending_credits =	self::onUser($user_id)->Credit()->Pending()->Category($category);

		}


		return 	$pending_credits;
	}


	public  static function scopeCancelledCreditOnUser($user_id, $category=null)
	{

		if ($category==null) {


			$cancelled_credits =  self::onUser($user_id)->Credit()->Cancelled();

		}else{

			$cancelled_credits =	self::onUser($user_id)->Credit()->Cancelled()->Category($category);

		}


		return 	$cancelled_credits;
	}





	public  static function scopeCompletedDebitOnUser($user_id, $category=null)
	{
		if ($category==null) {
			$completed_debits =  self::onUser($user_id)->Debit()->Completed();
		}else{
			$completed_debits =	self::onUser($user_id)->Debit()->Completed()->Category($category);
		}

		return 	$completed_debits;
	}


	public  static function scopeCancelledDebitOnUser($user_id)
	{

		if ($category==null) {


			$cancelled_debits =  self::onUser($user_id)->Debit()->Cancelled();

		}else{

			$cancelled_debits =	self::onUser($user_id)->Debit()->Cancelled()->Category($category);

		}


		return 	$cancelled_debits;

	}


	public  static function scopePendingDebitOnUser($user_id)
	{


		if ($category==null) {

			$pending_debits =  self::onUser($user_id)->Debit()->Pending();

		}else{

			$pending_debits =	self::onUser($user_id)->Debit()->Pending()->Category($category);

		}


		return 	$pending_debits;
	}




	public static function setBalanceTo($user_id , $balance, $comment=null, $admin_id=null, $earning_category=null)
	{
		if ($earning_category ==null) {

			$book_balance = self::bookBalanceOnUser($user_id);
			$earning_category = "adjustment";
		}else{

			$book_balance = self::bookBalanceOnUser($user_id, $earning_category);
		}



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
			$earning_category,
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
		$admin_id = null,
		$extra_detail = null,
		$paid_at = null,
		$transferred_from = null,
		$allow_with_sufficient_balance=true,
		$use_whole_wallet = false
	)
	{

		if (($amount == 0) && ($earning_category != 'investment')) {
			return;
		}


		if ($allow_with_sufficient_balance) {

			if ($type=='debit') {
				//confirm available balance
				if ($earning_category!=null) {
			//confirm available balance

					if ($earning_category!=null) {
						$book_balance = self::bookBalanceOnUser($user_id, $earning_category);

						$amount = round($amount, 2);
						$book_balance = round($book_balance, 2);


						
						if ($amount > $book_balance) {
							Session::putFlash("danger", "Insufficient Balance: $book_balance <code>$earning_category</code>");
							return false;
						}
					}
				}
			}
		}

		if ($paid_at==null) {
			$paid_at = date("Y-m-d H:i:s");
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
				'extra_detail' => $extra_detail ,
				'paid_at' => $paid_at,
				// 'transferred_from' => $transferred_from,
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
			return "<span class='badge badge-sm badge-success'>Credit</span>";
			break;

			case 'debit':
			return "<span class='badge badge-sm badge-danger'>Debit</span>";
			break;            
		}

	}


	public function getdisplayedStatusAttribute()
	{

		switch ($this->status) {
			case 'completed':
			return "<span class='badge badge-sm badge-success'>Completed</span>";
			break;

			case 'cancelled':
			return "<span class='badge badge-sm badge-danger'>Cancelled</span>";
			break;

			case 'pending':
			return "<span class='badge badge-sm badge-warning'>Pending</span>";
			break;            
		}

	}




}