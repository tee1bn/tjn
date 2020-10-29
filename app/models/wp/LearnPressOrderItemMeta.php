<?php
namespace wp\Models;

include_once 'app/controllers/home.php';

use  Filters\Traits\Filterable;
use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Config;
class LearnPressOrderItemMeta extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [
		'meta_id',
		'learnpress_order_item_id',
		'meta_key',
		'meta_value',


	];
								
	protected $table = 'wp_learnpress_order_itemmeta';
	protected $connection = 'wp_school';
	protected $primaryKey = 'meta_id';


    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;





/*
$related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null,
                                  $parentKey = null, $relatedKey = null, $relation = null*/
/*
	public function terms_relationships()
	{
		return $this->belongsToMany('wp\Models\Terms', 'wp_term_relationships', 'object_id', 'term_taxonomy_id','ID','term_id');
	}

*/


	public function order_item()
	{
		return $this->belongsTo('wp\Models\LearnPressOrderItem', 'learnpress_order_item_id');
	}

	


}