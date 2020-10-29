<?php
namespace wp\Models;

include_once 'app/controllers/home.php';

use  Filters\Traits\Filterable;
use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Terms extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [

		'term_id',
		'name',
		'slug',
		'term_group',

	];
								
	protected $table = 'wp_terms';
	protected $connection = 'wp_school';


    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;







	public function scopeLevels($query)
	{
		return $query->where('name','like' ,'level%');
	}



/*
$related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null,
                                  $parentKey = null, $relatedKey = null, $relation = null*/

	public function terms_relationships()
	{
		return $this->belongsToMany('wp\Models\Post', 'wp_term_relationships', 'term_taxonomy_id','object_id' ,'term_id', 'ID');
	}


}