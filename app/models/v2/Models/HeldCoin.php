<?php

namespace v2\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use  v2\Traits\Wallet;
use  Filters\Traits\Filterable;


class HeldCoin extends Eloquent 
{
	
	use Wallet, Filterable;

	protected $fillable = [
		'user_id',
		'order_id',
		'admin_id',
		'upon_user_id',
		'amount',
		'type',
		'earning_category',
		'status',
		'paid_at',
		'identifier',
		'comment',
		'extra_detail',	
		'transferred_from',	
	];


	protected $table = 'wallet_for_held_coin';



}


















?>