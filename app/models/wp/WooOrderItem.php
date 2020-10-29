<?php
namespace wp\Models;

include_once 'app/controllers/home.php';

use  Filters\Traits\Filterable;
use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;
use wp\Models\Terms;
class WooOrderItem extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [

		'order_item_id',
		'order_item_name',
		'order_item_type',
		'order_id',
	];
								
	protected $table = 'wp_woocommerce_order_items';
	protected $connection = 'wp_school';
	protected $primaryKey = 'order_item_id';


    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;



    public function get_level()
    {

    	$tags = Terms::Levels()->get();

    	$item_detail = $this->woo_order_item_meta->keyBy('meta_key')->toArray();

    	$item_id = $item_detail['_course_id']['meta_value'];

    	$item_tags = Post::find($item_id)->terms_relationships->KeyBy('term_id');


    	$terms_ids_array = $item_tags->pluck('term_id')->toArray();

    	$level_tags_array = $tags->pluck('term_id')->toArray();


    	$intersecting_level = array_intersect($terms_ids_array, $level_tags_array);
    	$first_key = array_values($intersecting_level)[0];

    	$level_array = $tags->keyBy('term_id')->toArray() [$first_key];



    	return $level_array;
    }



	public function woo_order_item_meta()
	{
		return $this->hasMany('wp\Models\WooOrderItemMeta', 'order_item_id');
	}




}