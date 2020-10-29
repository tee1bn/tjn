<?php
namespace wp\Models;

include_once 'app/controllers/home.php';

use  Filters\Traits\Filterable;
use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Config;
class Post extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [
		'ID',
		'post_author',
		'post_date',
		'post_date_gmt',
		'post_content',
		'post_title',
		'post_excerpt',
		'post_status',
		'comment_status',
		'ping_status',
		'post_password',
		'post_name',
		'to_ping',
		'pinged',
		'post_modified',
		'post_modified_gmt',
		'post_content_filtered',
		'post_parent',
		'guid',
		'menu_order',
		'post_type',
		'post_mime_type',
		'comment_count',
	];
								
	protected $table = 'wp_posts';
	protected $connection = 'wp_school';
	protected $primaryKey = 'ID';


    const CREATED_AT = 'post_date';
    const UPDATED_AT = 'post_modified';





/*
$related, $table = null, $foreignPivotKey = null, $relatedPivotKey = null,
                                  $parentKey = null, $relatedKey = null, $relation = null*/

	public function terms_relationships()
	{
		return $this->belongsToMany('wp\Models\Terms', 'wp_term_relationships', 'object_id', 'term_taxonomy_id','ID','term_id');
	}


	public function quickview()
	{
		$quickview = <<<EL
		<h3> $this->post_title</h3> <br>
		<small>$this->post_excerpt</small>
		<hr>
		$this->post_content;

EL;

		return $quickview;
	}

    public function market_details()
    {

        $domain = Config::domain();
        $post_meta = $this->post_meta->keyBy('meta_key')->toArray();

        // print_r($post_meta);
        $price = $post_meta['_lp_price']['meta_value'] ?? 0;

        $thumbnail = Config::logo();
        $market_details = [
            'id' => $this->ID,
            'model' => self::class,
            'name' => $this->post_title,
            'short_name' => ($this->post_title),
            'description' => $this->post_content,
            'short_description' => substr($this->post_excerpt, 0, 50).'...',
            'quick_description' => substr($this->post_content, 0, 250).'...',
            'price' => $post_meta['_lp_sale_price']['meta_value'] ?? $price,
            'old_price' => (isset($post_meta['_lp_sale_price']['meta_value'])) ? $post_meta['_lp_price']['meta_value'] : null,
            'by' => ($this->instructor == null)? '' : "By {$this->instructor->fullname}",
            'star_rating' => '',
            'quickview' =>  $this->quickview(),
            'single_link' =>  $this->ViewLink,
            'thumbnail' =>  $thumbnail,
            'unique_name' =>  'product',  // this name is used to identify this item in cart and at delivery
        ];

        return $market_details;
    }   





	public function scopeOrder($query)
	{
		return $query->where('post_type', 'shop_order');
	}



	public function scopeCourses($query)
	{
		return $query->where('post_type', 'lp_course');
	}



	public function scopeCompleted($query)
	{
		return $query->where('post_status', 'wc-completed');
	}


	public function post_meta()
	{
		return $this->hasMany('wp\Models\PostMeta', 'post_id');
	}


	public function order_items()
	{
		return $this->hasMany('wp\Models\WooOrderItem', 'order_id');
	}


}