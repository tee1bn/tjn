<?php


use Illuminate\Database\Eloquent\Model as Eloquent;
use v2\Models\Market;

use  Filters\Traits\Filterable;
    

class Post extends Eloquent 
{
	use Filterable;
		
		protected $fillable = ['title', 'category_id','user_id', 'image_path' , 'content', 'author_type'];


    public static $category_in_market = 'post';

    //to be worked on
    public function is_ready_for_review()
    {
       $required =  [                   'title',
                                        'category_id',
                                        'content',
                                        // 'image',
                                    ];

        foreach ($required as $field) {
            if ($this->$field == null) {

                return false;
            }
        }


        return true ;
    }



    public function getauthorAttribute()
    {
    	switch ($this->author_type) {
    		case 'admin':
    				return Admin::find($this->user_id);
			    	// return $this->belongsTo('Admin', 'user_id');
    			break;
    		case 'user':
    				return User::find($this->user_id);
			    	// return $this->belongsTo('User', 'user_id');
    			break;
    		
    		default:
    			# code...
    			break;
    	}

    }


	public function update_post($inputs, $files)
	{	

		$files = MIS::refine_multiple_files($files);
			if (Input::exists('')  || true) {
				$validator = new Validator;
			$validator->check(Input::all() , array(
														'title'=> [
															'required'=> true,
															],
														'category_id'=> [
															'required'=> true,
															],
														'content'=> [
															'required'=> true,
															],

													));
			 if($validator->passed()){
			 	
			 		try{
					 	$this->update([
									'title' 		=> $inputs['title'],
									'category_id' 	=> $inputs['category_id'],
									'content' 		=> $inputs['content']
					 				]);
			 			$this->update_post_images($files, $inputs['images_to_be_deleted']);

			 			return true;
			 		}catch(Exception $e){

			 		}

			 }else{


			 }
		}
	}



	public function getAdminPreviewLinkAttribute()
	{		
    		$href =  Config::domain()."/admin/preview_post/".$this->id;
    		return $href ;
	}

	public function getUserPreviewLinkAttribute()
	{		
    		$href =  Config::domain()."/user/preview_post/".$this->id;
    		return $href ;
	}


	public function getApprovalStatusAttribute()
	{

	      $last_submission =  Market::where('category', $this::$category_in_market)
	                        ->where('item_id', $this->id)
	                        ->latest()
	                        ->first();
	                       if ($last_submission == null) {
			                    $status = "<span class='badge badge-sm badge-dark'>Draft</span>";
			                    return $status;
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




	public function update_post_images($files, $images_to_be_deleted=[])
	{

		$property_media =	$this->upload_post_images($files);

		
	    $new_images = $property_media['images'];


        $previous_images =  $this->image_path['images'];
        if (empty($previous_images)) {
        	$previous_images = [];
        }


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
			

        foreach ($new_images as  $image) {
        		array_unshift($updated_previous_images, $image);
	        }

			$updated_files = [
								'images' => $updated_previous_images
								];

		$this->update(['image_path'=> json_encode($updated_files)]);
	}



	public function category(){

		return $this->belongsTo('\Category', 'category_id');
	}

	public function comment(){

		return $this->hasMany('comment')->orderBy('created_at' , DESC)->take(5);
	}
		
	public function no_oF_comment(){

		return $this->hasMany('comment')->get()->count();
	}

	public static function recent_posts($qty = 3){


		$posts = Market::latest('updated_at')
								->GoodsBelongingTo('post')
								->OnSale()
								->take($qty)->get();
		return $posts;								
	}

	public function intro()
	{
	
		return substr(strip_tags($this->content), 0, random_int(180, 250) ).'...';
	}
	public function getshortIntroAttribute()
	{
	
		return substr(strip_tags($this->content), 0, random_int(40, 45) ).'...';
	}

	public function getshortTitleAttribute()
	{
	
		return substr($this->title, 0, random_int(25, 50) ).'...';
	}


	public function other_posts()
	{

		$posts = Market::latest()
								->GoodsBelongingTo('post')
								->OnSale()
								->where('item_id', '!=' ,$this->id)
								->get()->shuffle()->take(3);
		return $posts;			

	}


	public function url()
	{
		return "blog/post/{$this->id}/{$this->url_title()}";
	}

	public function format_created_at()
	{
		return date("M d, Y", strtotime($this->created_at)) ;
	}

	public function url_title()
	{
			return str_replace(' ', '-', trim($this->title));
	}



	public static function default_main_image()
	{
			return "asset/img/image1.jpg";
	}





	public static function upload_post_images($files)
	{
		$directory = 'uploads/images/posts';

		$i = 0;
		foreach ($files as  $file) {

			$handle = new Upload ($file);


					$file_type = explode('/', $handle->file_src_mime)[0];
	                if (($file_type == 'image' ) ||($file_type == 'video' ) ) {



						$min_height = 350;
						$min_width  = 263;

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


	public function getdeletelinkAttribute()
	{
		return  Config::domain()."/blog/delete_post/{$this->id}";

	}



	public function geteditlinkAttribute()
	{
		return  Config::domain()."/admin/edit_post/{$this->id}";

	}


	public function gettitleAttribute($value='')
	{
		return ucfirst($value);
	}


	public function delete_post(array $ids)
	{
		foreach ($ids as $key => $id) {
			$post = self::find($id);
				if ($post != null) {

					try{
					 $post->delete();
					}catch(Exeception $e){

					}
				}
			}
			return true;
	}



	public function getimagepathAttribute($value)
	{
		if ($value==null) {
			return [];
		}
      return  json_decode($value, true);       
	}


	public function getmainimageAttribute($value)
	{
        if ((!is_dir($this->image_path['images'][0]['main_image']))  && (file_exists($this->image_path['images'][0]['main_image']))) {

        return ($this->image_path['images'][0]['main_image']);
        }

    	return self::default_main_image();

	}

	public function getmainimagesmallAttribute($value)
	{
        if ((!is_dir($this->image_path['images'][0]['thumbnail']))  && (file_exists($this->image_path['images'][0]['thumbnail']))) {

        return ($this->image_path['images'][0]['thumbnail']);
        }

    	return self::default_main_image();
	}


	public function next_post()
	{


	}
	public function prev_post()
	{

		
	}

	



}

 




?>