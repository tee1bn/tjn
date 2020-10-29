<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class LicenseKey extends Eloquent 
{
	
	protected $fillable = [
							'product_id',
							'licence_key',

							'order_id', //the order which has the product
							'purchased_product_id', // product finally having the key
							'purchased_product_index', // product index in order_cart having the key
				];
	
	protected $table = 'licence_keys';







	public function available_keys($product_id)
	{

		$keys = self::where('product_id', $product_id)
					->where('order_id', null)
					->where('purchased_product_id', null)
					->where('purchased_product_index', null)
					->get();

		return $keys;
	}




	public function product()
	{

		return $this->belongsTo('Products', 'product_id');
	}


	public function order()
	{

		return $this->belongsTo('Orders', 'order_id');
	}




}


















?>