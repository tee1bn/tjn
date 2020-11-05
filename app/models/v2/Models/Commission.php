<?php

namespace v2\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use  v2\Traits\Wallet;
use  v2\Models\PayoutWallet;
use SiteSettings;
use Illuminate\Database\Capsule\Manager as DB;
use  Filters\Traits\Filterable;


class Commission extends Eloquent 
{
	
	use Wallet,Filterable;

	protected $fillable = [
		'user_id',
		'order_id',
		'admin_id',
		'upon_user_id',
		'amount',
		'type',
		'paid_at',
		'earning_category',
		'binary_leg',
		'binary_points',
		'status',
		'identifier',
		'comment',
		'extra_detail'	,
		'transferred_from'	,
	];


	protected $table = 'wallet_for_commissions';




}


















?>