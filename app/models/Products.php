<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as Eloquent;

use  v2\Models\Market;


use  Filters\Traits\Filterable;


require_once "app/controllers/home.php";
class Products extends Eloquent 
{
    use Filterable;
	

	protected $fillable = [
		'name',
		'user_id',
		'price',
		'category_id',
		'description',
		'downloadable_files',
		'versions',
		'settings',
		'cover',
		'extras',
	];
	
	protected $table = 'products';


	protected $hidden = ['downloadable_files'];

	public static $category_in_market = 'product';

	public function user()
	{
		return $this->belongsTo('User','user_id');
	}


	public function getSlugNameAttribute()
	{
		$slug = str_replace(" ", "-", $this->name);
		return $slug;
	}


	public  function getPromotionLinkFor($user_id=null)
	{ 
		if ($user_id == null) {
			return null;
		}

		$domain = Config::domain();
		return "$domain/s/s/{$this->id}-$user_id-$this->SlugName";
	}


	public static function userCreateLink()
	{ 
		$domain = Config::domain();
		return "$domain/user/create_product";
	}


	public static function getCurrencyAttribute()
	{ 
		$currency = Config::currency();
		return "$currency";
	}


	public function getPreviewLinkAttribute()
	{ 
		$domain = Config::domain();
		return "$domain/user/preview-link/$this->id";
	}

	public function getUserEditLinkAttribute()
	{ 
		$domain = Config::domain();
		return "$domain/user/edit-product/$this->id";
	}


	public function getFilesArrayAttribute()
	{

		if ($this->downloadable_files == null) {
			return [];
		}

		return json_decode($this->downloadable_files, true);

	}


	public function getCoverArrayAttribute()
	{

		if ($this->cover == null) {
			return [];
		}

		return json_decode($this->cover, true);

	}


	public function getCoverLinkArrayAttribute()
	{ 
		$domain = Config::domain();

		$files = $this->CoverArray;

		$first_link = $files['file'][0]['file_path'];

		if (strpos("$first_link", "http://")) {
			$link = $first_link;
		}else{

			$link = "$domain/$first_link";
		}

		$type = explode("/", $files['file'][0]['type'])[0];


		$response = compact('link','type');

		return $response;
	}

	public function getDownloadLinkAttribute()
	{ 
		$domain = Config::domain();

		$files = $this->FilesArray;

		$first_link = $files['file'][0]['file_path'];

		if (strpos("$first_link", "http://")) {
			$link = $first_link;
		}else{

			$link = "$domain/$first_link";
		}

		return $link;

		return "$domain/user/download-link/$this->id";
	}



	public function getimageJsonAttribute()
	{   
		$value = $this->image;


		if ((!is_dir($value))  && (file_exists($value))) {

			return ($value);
		}

		return 'uploads/images/courses/course_image.jpeg';
	}



	public static function star_rating($rate,  $scale)
	{
		$stars = '';
		for ($i=1; $i <= $scale ; $i++) { 
			if ($i <= $rate) {
				$stars .= "<i class='fa fa-star'></i>";
			}else{
				$stars .= "<i class='fa fa-star-o'></i>";
			}
		}

		$point = number_format(($rate), 1);
		$stars .= " (<b>$point</b>)";
		$star_rating = compact('rate', 'scale', 'stars', 'point');

		return $star_rating;
	}



	public function quickview()
	{

		$currency = Config::currency();
		$price = MIS::money_format($this->price);
		$by = ($this->instructor == null)? '' : "By {$this->instructor->fullname} ";
		
		$product = $this;
		$controller = new \home;
		$view = $controller->buildView('composed/view_product', compact('product'));

		$last_updated = date("M j, Y h:iA" , strtotime($this->updated_at));
		$quickview = "
		 $view
		<ul>

		</ul>

		";

		return $quickview;
	}

	public function scopeFree($query)
	{
		return $query->where('price', 0);
	}



	public function is_free()
	{
		return $this->price == 0;
	}



	public function getViewLinkAttribute()
	{
		$domain = Config::domain();

		$url_friendly = MIS::encode_for_url($this->title);
		$category_in_market = self::$category_in_market;
		$singlelink = "$domain/shop/full-view/$this->id/$category_in_market/$url_friendly";

		return $singlelink;  
	}


	public function market_details()
	{
		$product = $this;
		$domain = Config::domain();
		$thumbnail = "$this->mainimage";
		$controller = new \home;
		$auth = $controller->auth();


		$market_details = [
			'id' => $this->id,
			'user_id' => $this->user_id, //seller
			'model' => self::class,
			'name' => $this->name,
			'short_name' => substr($this->name, 0, 34),
			'description' =>  $this->description,
			'short_description' => substr($this->description, 0, 50).'...',
			'quick_description' => substr($this->description, 0, 250).'...',
			'price' => $this->price,
			'old_price' => $this->old_price,
			'by' => ($this->instructor == null)? '' : "By {$this->instructor->fullname}",
			'star_rating' => self::star_rating(4, 5),
			'quickview' =>  $this->quickview(),
			'single_link' =>  $this->ViewLink,
			'thumbnail' =>  $thumbnail,
			'promotional_link' =>  $this->getPromotionLinkFor($auth->id ?? null),
            'unique_name' =>  'product',  // this name is used to identify this item in cart and at delivery
        ];

        return $market_details;
    }   






    public function download()
    {
    	$type = MIS::custom_mime_content_type( $this->downloadable_files);

    	$filename = end(explode('/', $this->downloadable_files));

    	if (! file_exists($this->downloadable_files)) {
    		Session::putFlash('danger', "could not fetch file");
    		return;
    	}

    	header("Content-type: $type");
    	header('Content-Disposition: attachment; filename="'.$filename.'"');

    	readfile($this->downloadable_files);
    	exit();
    }



    public function scheme_attached()
    {
    	return $this->belongsTo('SubscriptionPlan', 'scheme');
    }



    public static function validate_cart($cart_items)
    {
    	$errors = [];
    	$totals = [];
    	foreach ($cart_items as $key => $item) {
    		$real_product =  self::find($item['id']);
    		$totals[] = $real_product->price * $item['qty'];
    		if (
    			($real_product->price != $item['price'])
    		) {
    			$errors['price'] = "incorrect";

    			return false;
    		}

    		return true;
    	}



    }

    public function getpercentdiscountAttribute()
    {
    	if (($this->old_price==null) ||($this->old_price <= $this->price) ) {
    		return 0;
    	}		

    	return  (int) (($this->old_price - $this->price) * (100 / $this->old_price));
    }


    public function is_ready_for_review()
    {
    	return true;
    }

    public function update_product($inputs, $files, $downloadable_files)
    {


    	if (Input::exists('')  || true) {
    		$validator = new Validator;
    		$validator->check(Input::all() , array(

    			'name' =>[

    				'required'=> true,
    				'min'=> 2,
    			],
    			'price' =>[

    				'required'=> true,
    				'min'=> 1,
    				'max'=> 20,	
    				'numeric'=> true,
    			],

    			'description' => [
    				'required'=> true,
    				'min'=> 4,
    			]
    		));
    		if($validator->passed()){

    			DB::beginTransaction();
    			try{
    				$this->update([
    					'name' 		=> $inputs['name'],
    					'price' 	=> $inputs['price'],
									// 'category' 	=> $inputs['category_id'],
    					'description' => $inputs['description'],
    				]);

    				$this->update_product_files_attribute($files, [], 'cover');
    				$this->update_product_files_attribute($downloadable_files, [], 'downloadable_files');
			 			// $this->upload_downloadable_files($downloadable_files);

    				DB::commit();
    				Session::putFlash('success','Changes Saved Successfully.');

    				return true;
    			}catch(Exception $e){
    				DB::rollback();
    				Session::putFlash('danger', "Seems {$inputs['name']} already exist.");
    				print_r($e->getMessage());
    				return false;
    			}

    		}else{

    			Session::putFlash('danger',Input::inputErrors());

    		}
    	}


    }



    public function upload_downloadable_files($file)
    {
    	$directory = 'uploads/images/downloadable_files';


    	$handle = new Upload ($file);

    	$handle->Process($directory);
    	$file_path = $directory.'/'.$handle->file_dst_name;

    	$this->update(['downloadable_files' => $file_path]);
    	return ($file_path);


    }



    public static function upload_file($files)
    {
    	$directory = 'uploads/products';


    	$refined_file = MIS::refine_multiple_files($files);

    	if ($refined_file[0]['error']==4 ) {
    		return [];
    	}

    	$i = 0;
    	foreach ($refined_file as  $file) {

    		$handle = new Upload ($file);


    		$file_type = explode('/', $handle->file_src_mime)[0];

    		$min_height = 350;
    		$min_width  = 263;

    		$handle->file_name_body_add = uniqid();
    		$handle->Process($directory);

    		$file_path = $directory.'/'.$handle->file_dst_name;


    		$uploaded_file[$i]['file_path'] = $file_path;
    		$uploaded_file[$i]['type'] = $handle->file_src_mime;
    		if ($file_type == 'image') {

	             // we now process the image a second time, with some other settings
    			$handle->image_resize            = true;
				            // $handle->image_ratio_y           = true;
    			$handle->image_x                 = $min_width;
    			$handle->image_y                 = $min_height;

    			// $handle->Process($directory);

    			// $resized_path    = $directory.'/'.$handle->file_dst_name;

    			// $uploaded_file[$i]['thumbnail'] = $resized_path;
    		}

							// $uploaded_file[$i]['file'] = $file;
    		$i++;
    	}



    	$property_media = [
    		'file' => $uploaded_file,
    	];

    	return ($property_media);
    }






    public function update_product_files_attribute($files, array $images_to_be_deleted=[], $category='image')
    {


    	$property_media =	$this->upload_file($files);


    	$new_images = $property_media['file'];

    	$previous_images =  $this->FilesArray['file'];


	    //delete necessary ones
    	foreach ($images_to_be_deleted as $value) {
    		$images_in_previous = $previous_images[$value];
    		foreach ($images_in_previous as $image_path) {
    			$handle =  new Upload($image_path);
    			$handle->clean();
    		}

    		unset($previous_images[$value]);
    	}

		($updated_previous_images = array_values($previous_images)); //after removing some

		if (array_values($previous_images) == null) {
			$updated_previous_images =  [];
		}


		foreach ($new_images as  $image) {
			array_unshift($updated_previous_images, $image);
		}

		//delete others and keep the latest one
		foreach ($updated_previous_images as $key => $file) {
			if ($key== 0) {continue;}
			$handle =  new Upload($file['file_path']);
			$handle->clean();
			unset($updated_previous_images[$key]);

		}

			$updated_files = [
				'file' => $updated_previous_images
			];


			$this->update([$category => json_encode($updated_files)]);
		}




		public function getdeletelinkAttribute($value)
		{
			return  Config::domain()."/admin-products/deleteProduct/{$this->id}";
		}


		public function related_products()
		{
			return	self::where('id', '!=' ,$this->id)
			->whereRaW("(category_id = '$this->category_id' OR id != $this->id )")
			->latest()->take(20)->get()->shuffle()->take(4);
		}





		public static  function default_ebook_pix()
		{
			return 'https://wrappixel.com/demos/admin-templates/monster-admin/assets/images/big/img1.jpg';
		}



		public function getApprovalStateAttribute()
		{
			$last_submission =  Market::where('category', $this::$category_in_market)
			->where('item_id', $this->id)
			->latest()
			->first();

			return $last_submission;
		}


		//market approval status
		public function getApprovalStatusAttribute()
		{

			$last_submission = $this->ApprovalState;
			
			if ($last_submission == null) {
				return "<span class='badge badge-sm badge-dark'>Drafting</span>";
			}

			switch ($last_submission->approval_status) {
				case 2:
				$status = "<span class='badge badge-sm badge-success'>Approved</span>";
				break;

				case 1:
				$status = "<span class='badge badge-sm badge-warning'>In review</span>";
				break;

				case 0:
				$status = "<span class='badge badge-sm badge-danger'>Declined</span>";
				break;

				case null:
				$status = "<span class='badge badge-sm badge-info'>unknown</span>";
				break;


				default:
	            # code...
				break;
			}

			return $status;

		}


		public static function approved()
		{
			return self::where('status', 'Approved');
		}

		public static function in_review()
		{
			return self::where('status', 'In review');
		}


		public  static function draft()
		{
			return self::where('status', 'Draft');
		}


		public  static function denied()
		{
			return self::where('status', 'Denied');
		}



		public function getmainimageAttribute()
		{
			$value =  $this->images['images'][0]['main_image'];

			if (! file_exists($value) &&  (!is_dir($value))) {
				return (self::default_ebook_pix());
			}

			$pic_path = Config::domain()."/".$value;
			return $pic_path;
		}



		public function getsecondaryimageAttribute()
		{
			if (($this->images['images'][1] !=null ) && ( file_exists($this->images['images'][1]['main_image']))) {
				return $this->images['images'][1];
			}
			return $this->mainimage;
		}





		public function getregularpriceAttribute()
		{	
			if ($this->old_price != '') {
				return  Config::currency().' '.number_format($this->old_price,2);		
			}
		}




		public static function upload_product_images($files)
		{
			$directory = 'uploads/images/products';

			foreach ($files as $attribute => $attributes) {
				foreach ($attributes as $key => $value) {
					$refined_file[$key][$attribute] = $value;
				}

			}

			$i = 0;
			foreach ($refined_file as  $file) {

				$handle = new Upload ($file);


				$file_type = explode('/', $handle->file_src_mime)[0];
				if (($file_type == 'image' ) ||($file_type == 'video' ) ) {



					$min_height = 335;
					$min_width  = 270;

						// echo $handle->image_src_x;

					if (($handle->image_src_x < $min_width) || ($handle->image_src_y < $min_height) ) {

						Session::putFlash('info', "Item image $i) must be or atleast {$min_width}px min 
							width x {$min_height}px min height for best fit!");
						continue;
					}


					$handle->Process($directory);
					$file_path = $directory.'/'.$handle->file_dst_name;

					if ($file_type == 'image') {

	                         // we now process the image a second time, with some other settings
						$handle->image_resize            = true;
				            // $handle->image_ratio_y           = true;
						$handle->image_x                 = 350;
						$handle->image_y                 = 263;

						$handle->Process($directory);

						$resized_path    = $directory.'/'.$handle->file_dst_name;

						$images[$i]['main_image'] = $file_path;
						$images[$i]['thumbnail'] = $resized_path;
					}

				}
				$i++;
			}



			$property_media = [
				'images' => $images,
			];




			return ($property_media);


		}


		public function getShortDescriptionAttribute()
		{
			return strip_tags(substr($this->description, 0, random_int(100, 150) )).'...';
		}

		public function quickdescription()
		{
			return substr($this->description, 0, random_int(240, 450) ).'...';
		}



		public function url_link()
		{
			return Config::domain()."/shop/full_view/{$this->id}/{$this->url_title()}";
		}


		public function url_title()
		{
			return str_replace(' ', '-', trim($this->name));
		}


		public function category()
		{
			return $this->belongsTo('ProductsCategory' , 'category_id');
		}

	}


















	?>