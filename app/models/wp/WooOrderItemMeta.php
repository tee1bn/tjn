<?php
namespace wp\Models;

include_once 'app/controllers/home.php';

use  Filters\Traits\Filterable;
use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;

class WooOrderItemMeta extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [
				'meta_id',
				'order_item_id',
				'meta_key',
				'meta_value',
				];
								
	protected $table = 'wp_woocommerce_order_itemmeta';
	protected $connection = 'wp_school';
	protected $primaryKey = 'meta_id';


    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;



	public function woo_order_item()
	{
		return $this->belongsTo('wp\Models\WooOrderItem', 'order_item_id');
	}




}