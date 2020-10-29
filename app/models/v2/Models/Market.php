<?php

namespace v2\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use SiteSettings, User;

use  Filters\Traits\Filterable;

	
class Market extends Eloquent 
{
	use Filterable;

	protected $fillable = [

							'category',
							'seller_id',
							'item',
							'item_id',
							'approval_status',
							'comment',
							'onsale_status',
							'admin_id',
						];


	protected $table = 'market';

	public  static	$register = [
				'course' => [
					'model' => 'Course',
					'name' => 'Course',
				],
				'post' => [
					'model' => 'Post',
					'name' => 'Post',
				],

			];


	public function scopeGetCategory($query, $type ='course')
	{
		return $query->where('category', $type);
	}


	public function getItemArrayAttribute()
	{
		return json_decode($this->item, true);
	}

	public function approval_status_is($status)
	{
		$approval_statuses = [
			'declined' => 0,
			'in_review' => 1,
			'approved' => 2,
		];


		return $this->approval_status == $approval_statuses[$status];
	}


	public function decline()
	{
		$decline = $this->update([
					'approval_status' => 0,
					'onsale_status' => 0,
				]);

		return $decline;
	}


	public function approve()
	{


	 $last_submissions =  Market::where('category', $this->category)
	                  ->where('item_id', $this->item_id)->get();


	                  foreach ($last_submissions as $key => $value) {
					        $value->update([
								'approval_status' => null,
								'onsale_status' => null,
							]);
	                  }

		$aprove = $this->update([
					'approval_status' => 2,
					'onsale_status' => 1,
				]);

		return $aprove;
	}


	public function scopeGoodsBelongingTo($query, $category)
	{
		return $query->where('category', $category);
	}


	//during sale i.e
	public function good()
	{
		
		$register = self::$register;

		$model = $register[$this->category]['model'];

		$good = new $model;
		$content_array = json_decode($this->item, true);
		foreach ($content_array as $key => $value) {
			$good[$key] = $value;
		}

		return $good;
	}

	//preview on sngle page
	public function preview()
	{
		return $this->good();
	}



	public function scopeOnSale($query)
	{
		//2 is approved
		return $query->where('approval_status', 2)->where('onsale_status', 1);
	}






}


















?>