<?php

use  v2\Models\Market;

/**



*/
class BlogController extends controller
{



	public function __construct(){


		$this->per_page = 10;

	}






	public function update_post()
	{

		$post = Post::find(Input::get('id'));
		$update = 	$post->update_post($_POST, $_FILES['image_path']);

		if ($update === true) {
				Session::putFlash('success','Post Updated Successfully.');
			}
		Redirect::back();
	}




	public function edit_post($post_id)
	{
			try {
				 $post = Post::where('id',$post_id)->where('user_id', $this->auth()->id)->first();
				
			} catch (Exception $e) {
				
				Session::putFlash('warning','Could Not Find Post. Please try again');
				Redirect::back();
			}

			$this->view('auth/edit-post', [
									'post'=>$post,
							]);  //note this is

	}



	public function preview_post($post_id)
	{
		$this->middleware('administrator')->mustbe_loggedin();

		$last_submission =  Market::where('category', 'post')
		                  ->where('item_id', $post_id)
		                  ->latest()
		                  ->first();

			if ($last_submission == null) {
				Redirect::back();
			}

		$post = $last_submission->preview();



		$this->view('guest/single-post', compact('post'));  //note this is
	}




	public function create_post()
	{
	
		if (Input::exists()  || true) {

			$post = Post::create(['user_id'=> $this->auth()->id]);
			Redirect::to("blog/edit_post/{$post->id}");



			$this->validator()->check(Input::all() , array(
														'title'=> [
															'required'=> true,
															'unique'=> 'Post',
															],
														'category'=> [
															'required'=> true,
															],
														'content'=> [
															'required'=> true,
															],

													));
			 if($this->validator->passed()){


					$post_image =  Post::upload_post_images($_FILES['image_path']);

					if (count($post_image['images'])!= 0) {

				 		$product = Post::create([
				 		'title' => Input::get('title'),
				 		'category_id' => Input::get('category'),
				 		'content' => Input::get('content'),
						'image_path'=> json_encode($post_image)
		 				]);
					Session::putFlash('success', "Post Created Successfully!");
				}else{

					Session::putFlash('info', "Please check the images and try again!");
				}
			}else{

					Session::putFlash('info', $this->inputErrors());

			}
		}
		
		Redirect::back();
	}


	public function update_category()
	{

		foreach ($_POST['category'] as $id => $category) {

			Category::updateOrCreate(['id'=> $id], 
									['category' => $category]);
		}

	 		Session::putFlash('success', 'Updated Successfully.');
	 		Redirect::back();
	}


	public function delete_category($category_id)
	 {
	 	if(Category::delete_category([$category_id])){
	 		Session::putFlash('success', 'Deleted Successfully.');
	 	}
	 	Redirect::back();
	 } 

	public function delete_post($post_id)
	 {
	 	if(Post::delete_post([$post_id])){
	 		Session::putFlash('success', 'Deleted Successfully.');
	 	}
	 	Redirect::back();
	 } 

	public function add_category($value='')
	{


		if (Input::exists() || true) {

					$this->validator()->check(Input::all() , Category::$validation_rules);
					if ($this->validator()->passed()) {

						Category::create([
							'category' => $_POST['category']
						]);

						Session::putFlash('success','Category created successfully.');
					}else{

						Session::putFlash('danger', $this->inputErrors());

					}
			}
		 
			Redirect::back();
	}




	
	public function index()
	{
		$for_pages 	= Post::all();	

		$page = ($_GET['page']) ?? 1;

		$posts = Market::latest()
								->GoodsBelongingTo('post')
								->OnSale()
								->get()
								->sortByDesc('created_at')->forPage($page , $this->per_page);



	    $this->view('guest/blog'  , ['posts'=> $posts, 'for_pages'=>$for_pages]);
  	}

	

	
	public function post($post_id)
	{

		$live_post =	Market::where('category', 'post')
									->where('item_id', $post_id)
									->latest()
									->OnSale()
									->first();


			if ($live_post == null) {
				Redirect::back();
			}

		$post = $live_post->preview();


    	$this->view('guest/single-post', compact('post'));
	  }


	 
	
	public function category($category_id)
	{

		$this->category 	= Category::find($category_id) ;
		$posts_ids 				= $this->category->posts->pluck('id')->toArray();


		$posts = Market::latest()
						->GoodsBelongingTo('post')
						->OnSale()
						->whereIn('item_id', $posts_ids)
						->get();

		$for_pages 			= $posts->count();   			
		$page = ($_GET['page']) ?? 1;

		$posts = $posts->sortByDesc('created_at')->forPage($page , $this->per_page);



    	$this->view('guest/blog'  , ['posts'=> $posts, 'for_pages'=>$for_pages]);
	  }







}























?>