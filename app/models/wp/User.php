<?php
namespace wp\Models;

include_once 'app/controllers/home.php';

use  Filters\Traits\Filterable;
use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Config;
class User extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [


		'ID',
		'user_login',
		'user_pass',
		'user_nicename',
		'user_email',
		'user_url',
		'user_registered',
		'user_activation_key',
		'user_status',
		'display_name',
	];
								
	protected $table = 'wp_users';
	protected $connection = 'wp_school';
	protected $primaryKey = 'ID';


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


	public function user_meta()
	{
		return $this->hasMany('wp\Models\UserMeta', 'user_id');
	}

	


}