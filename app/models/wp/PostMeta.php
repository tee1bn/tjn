<?php
namespace wp\Models;

include_once 'app/controllers/home.php';

use  Filters\Traits\Filterable;
use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;

class PostMeta extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [
		'meta_id',
		'post_id',
		'meta_key',
		'meta_value',
	];
								
	protected $table = 'wp_postmeta';
	protected $connection = 'wp_school';
	protected $primaryKey = 'meta_id';


    const CREATED_AT = NULL;
    const UPDATED_AT = NULL;






	public function post()
	{
		return $this->belongsTo('wp\Models\Post', 'post_id');
	}




}