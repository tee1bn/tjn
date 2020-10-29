<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Products extends Eloquent 
{
	
		protected $fillable = [
						'name',
						'scheme',
						'price',
						'category_id',
						'ribbon',
						'old_price',
						'description',
						'front_image',
						'downloadable_files',
						'back_image',
						'on_sale',
							];
	
	protected $table = 'products';


    protected $hidden = ['downloadable_files'];



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

	public static function accessible($subscription_id)
	{	
		$sub 	 = SubscriptionPlan::find($subscription_id);
		$sub_ids = SubscriptionPlan::where('hierarchy', '=', (int)$sub->hierarchy)
									->get()
									->pluck('id')
									->toArray();
		$sub_ids[] = 'free';

		$accessibles =  self::whereIn('scheme', $sub_ids);

		return $accessibles;
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
									'scheme' 	=> $inputs['scheme'],
									'category' 	=> $inputs['category_id'],
									'description' => $inputs['description'],
									'ribbon' => $inputs['ribbon'],
									'old_price' => $inputs['old_price'],
					 				]);
			 			$this->update_product_images($files, $inputs['images_to_be_deleted']);
			 			$this->upload_downloadable_files($downloadable_files);

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



	public static function upload_post_images($files)
	{
		$directory = 'uploads/images/products';


		$refined_file = MIS::refine_multiple_files($files);


		$i = 0;
		foreach ($refined_file as  $file) {

			$handle = new Upload ($file);


					$file_type = explode('/', $handle->file_src_mime)[0];
	                if (($file_type == 'image' ) ||($file_type == 'video' ) ) {



						$min_height = 350;
						$min_width  = 263;

					

	                	$handle->Process($directory);
	                	$file_path = $directory.'/'.$handle->file_dst_name;

	                	if ($file_type == 'image') {

	                         // we now process the image a second time, with some other settings
				            $handle->image_resize            = true;
				            // $handle->image_ratio_y           = true;
				            $handle->image_x                 = $min_width;
				            $handle->image_y                 = $min_height;

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






	public function update_product_images($files, $images_to_be_deleted=[])
	{

		$property_media =	$this->upload_post_images($files);

		

	    $new_images = $property_media['images'];


        $previous_images =  $this->images['images'];


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





			$updated_files = [
								'images' => $updated_previous_images
								];

		$this->update(['front_image'=> json_encode($updated_files)]);
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


	public function getimagesAttribute()
	{
		return json_decode($this->front_image, true);
	}



	public static  function default_ebook_pix()
	{
		return 'https://wrappixel.com/demos/admin-templates/monster-admin/assets/images/big/img1.jpg';
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


	public function quickdescription()
	{
		return substr($this->description, 0, random_int(240, 450) ).'...';
	}



	public function url_link()
	{
		return Config::domain()."/shop/product_detail/{$this->id}/{$this->url_title()}";
	}


	public function url_title()
	{
			return str_replace(' ', '-', trim($this->name));
	}


	public  function is_on_sale()
	{
		return (bool)($this->on_sale == 1);
	}

	public static function on_sale()
	{
		return self::where('on_sale' , 1);
	}

	public function category()
	{
		return $this->belongsTo('ProductsCategory' , 'category_id');
	}

}


















?>