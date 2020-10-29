<?php
namespace v2\Models;

include_once 'app/controllers/home.php';
use v2\Models\Wallet;
use v2\Models\Commission;
use v2\Models\HotWallet;
use v2\Models\HeldCoin;
use v2\Models\PayoutWallet;
use  Filters\Traits\Filterable;
use  Filters\Traits\CSVExportable;

use SiteSettings, Session;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;




class Withdrawal extends Eloquent 
{
	use Filterable;
	use CSVExportable;
	
	protected $fillable = [
		'user_id',
		'amount',
		'fee',
		'withdrawal_method_id',
		'method_details',
		'detail',
		'admin_id',
		'completed_at',
		'status'
	];
	
	protected $table = 'users_withdrawals';


	public static $statuses = [
							'pending'=> 'pending',
							'completed'=> 'completed',
							 'declined'=> 'declined'
							];



	public static function csv_structure(array $ids =[])
	{

		$header = [
			'sn',
			'id',
			'firstname',
			'lastname',
			'username',
			'amount',
			'fee',
			'payable',
			'bankcode',
			'bank',
			'nuban',
			'account holder',
			'status',
			'date',
		];
		

			
		$all = self::whereIn('id', $ids)->get();


		$csv_records = [];
		$i = 1;
		foreach ($all as $key => $record) {
			$method = $record->withdrawal_method->MethodDetails;
			$csv_records[] = [
				$i,
				$record->id,
				$record->user->firstname,
				$record->user->lastname,
				$record->user->username,
				$record->amount,
				$record->fee,
				$record->AmountToPay,
				"{$method['bank_code']}",
				$method['bank'],
				$method['account_number'],
				$method['account_name'],
				$record->status,
				$record->created_at,
			];

		}

		$filename = 'withdrawals';

		return compact('csv_records','header', 'filename');

	}


	public static function push_status(array $ids =[], $action)
	{
		echo "<pre>";
		print_r($_POST);

		DB::beginTransaction();
		$new_status = [
			'pend' => [
				'status' => 'pending',
			],
			'complete' => [
				'status' => 'completed',
			],
			'decline' => [
				'status' => 'declined',
			],
		];

		try {
			
		$all = self::whereIn('id', $ids);

		$all->update(['status'=> $new_status[$action]['status']]);

		DB::commit();
		Session::putFlash("success","{$all->count()} rows marked as {$new_status[$action]['status']}");
		return true;
		} catch (Exception $e) {
		DB::rollback();
		print_r($e->getMessage());
		Session::putFlash("danger","Something went wrong");
			
		}

		return false;
	}

	
	//bulk actions registers
	public static function bulk_action($action , array $ids =[])
	{
		$register=[
			'export_csv' => [
				'function' => 'export_to_csv',
			],
			'pend' => [
				'function' => 'push_status',
			],
			'complete' => [
				'function' => 'push_status',
			],
			'decline' => [
				'function' => 'push_status',
			],
		];


		$method = $register[$action]['function'];
		return self::$method($ids, $action);
	}




	public static function payoutBalanceFor($user_id)
	{


		$rules_settings =  SiteSettings::find_criteria('rules_settings');
		$setting = $rules_settings->settingsArray;
		$withdrawal_fee = $setting['withdrawal_fee_percent'];
		$min_withdrawal = $setting['min_withdrawal_usd'];


		$commission_balance =  Commission::bookBalanceOnUser($user_id);

		$commission_credits = Commission::onUser($user_id)->Credit()->Cleared()->sum('amount') ;

		$total_earnings =  $commission_credits;

		$completed_withdrawal = self::where('user_id' , $user_id)->Completed()->sum('amount');
		$pending_withdrawal = self::where('user_id' , $user_id)->Pending()->sum('amount');


		$total_amount_withdrawn = $completed_withdrawal + $pending_withdrawal ;

		$payout_wallet    =  Commission::availableBalanceOnUser($user_id);

		$payout_balance = $payout_wallet  - $total_amount_withdrawn;

		$payout_book_balance = $payout_wallet  - $completed_withdrawal;

		$available_payout_balance = ($payout_balance >= $min_withdrawal)? $payout_balance: 0 ;



		$state = compact(
			'withdrawal_fee',
			'min_withdrawal',
			'commission_balance',
			'total_earnings',
			'payout_balance',
			'payout_book_balance',
			'available_payout_balance',
			'completed_withdrawal'
		);

		return $state;


	}
	




	public function getDetailArrayAttribute()
	{
		if ($this->detail == null) {
			return [];
		}

		return json_decode($this->detail, true);
	}



	

	public function admin()
	{
		return $this->belongsTo('Admin', 'admin_id');

	}
	




	public function getAmountToPayAttribute()
	{
		$payable = $this->amount - $this->fee;
		return $payable;
	}

	public function is_complete()
	{
		return $this->status == 'completed';
	}
	public function scopeCompleted($query)
	{
		return $query->where('status','completed');
	}



	public function mark_completed($verification=null)
	{
		$controller = new home;

		$withdrawal->update([
			'status'=> 'completed',
			'admin_id'=> $controller->admin()->id,
			'detail' =>  $verification
		]);


		return true;
	}


	public function scopePending($query)
	{
		return $query->where('status','pending');
	}



	public function scopeDeclined($query)
	{
		return $query->where('status','declined');
	}


	public function getDisplayStatusAttribute()
	{

		switch ($this->status) {
			case 'completed':
			$return = "<span class='badge badge-success'>completed</span>";

			break;
			case 'pending':
			$return = "<span class='badge badge-warning'>pending</span>";

			break;
			case 'declined':
			$return = "<span class='badge badge-danger'>declined</span>";

			break;
			
			default:
				# code...
			break;
		}

		return $return;
	}



	public function getwithdrawalDetailsAttribute()
	{
		$method =  UserWithdrawalMethod::$method_options[$this->withdrawal_method->method];
		$detail = $method['display'];
		$line = '';
		$method_details = json_decode($this->MethodDetailsArray['details'], true);

		

		foreach ($detail as $key => $label) {
			$value = $method_details[$key];
			$line .= "<li>
						$label:
						$value
					</li>";
		}

		return $line;
	}


	public function getMethodDetailsArrayAttribute()
	{
		if ($this->method_details == null) {
			return [];
		}

		return json_decode($this->method_details, true);
	}



	
	public function user()
	{
		return $this->belongsTo('User', 'user_id');

	}


	
	public function withdrawal_method()
	{
		return $this->belongsTo('v2\Models\UserWithdrawalMethod', 'withdrawal_method_id');

	}



}
?>
