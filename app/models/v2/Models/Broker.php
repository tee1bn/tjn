<?php


namespace v2\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Broker extends Eloquent 
{
	
	protected $fillable = [
						'name',
						'email',
						'phone'	,
						'website',
						'others',
						'details',
						'created_at',
						'updated_at'
					];
	

	protected $table = 'brokers';
	

	//for multiple page banners
	public static $brokers_links = [
		'octafx'=> [
			'banner'=> '<iframe src="https://octaengine.com/ib/300x250/ib2547685" allowtransparency="true" framespacing="0"
			 frameborder="no" scrolling="no" width="300" height="250"></iframe>',

		],


	];


	public function getWrittenArrayAttribute()
	{
		$broker_key = $this->DetailsArray['key'];
		return self::$brokers_links[$broker_key];
	}


	public function getClientCabinetAttribute()
	{
		return $this->DetailsArray['client_cabinet'];
	}


	public function getDetailsArrayAttribute()
	{
		return json_decode($this->details, true);
	}


	public function getAccountOpeningPage()
	{
		$pages = [
			1 => 'firstfx',
			2 => 'secondfx',
		];

		return $pages[$this->id];
	}


	public function scopeActive($query)
	{
		return $query->where('active_status', 1);
	}

	public function getOpenAccountLink()
	{
		$domain = \Config::domain();
		return "$domain/user/open_trading_account/{$this->id}"	;
	}

}


















?>