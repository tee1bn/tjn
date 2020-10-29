<?php
namespace wp\Models;

include_once 'app/controllers/home.php';

use  Filters\Traits\Filterable;
use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Config;
class LearnPressOrderItem extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [

		'order_item_id',
		'order_item_name',
		'order_id',
	];
								
	protected $table = 'wp_learnpress_order_items';
	protected $connection = 'wp_school';
	protected $primaryKey = 'order_item_id';


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


	public function meta()
	{
		return $this->hasMany('wp\Models\LearnPressOrderItemMeta', 'order_item_id');
	}

	


}