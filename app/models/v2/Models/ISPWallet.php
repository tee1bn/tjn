<?php

namespace v2\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use v2\Traits\Wallet as  BookRecords;
use v2\Models\PayoutWallet;
use SiteSettings;
use Illuminate\Database\Capsule\Manager as DB;
use  Filters\Traits\Filterable;


class ISPWallet extends Eloquent 
{
	
	use BookRecords,Filterable;

	protected $fillable = [
		'user_id',
		'order_id',
		'admin_id',
		'upon_user_id',
		'amount',
		'type',
		'paid_at',
		'earning_category',
		'status',
		'identifier',
		'comment',
		'extra_detail'	
	];


	protected $table = 'isp_wallet';


	public static $statuses = [
							'pending'=> 'pending',
							'completed'=> 'completed',
							 'cancelled'=> 'cancelled'
							];


	public function available_wallets($user = null)
	{
		$wallets = self::$wallets;

		if ($user == null) {
			return $wallets;
		}

		foreach ($wallets as $key => $wallet) {
			$class = $wallet['class'];
			$balance = $class::bookBalanceOnUser($user->id, $wallet['category']);
			$wallets[$key]['balance'] = $balance;
		}

		return $wallets;
	}
	

}


















?>