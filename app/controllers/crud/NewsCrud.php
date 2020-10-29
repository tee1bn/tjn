<?php
use v2\Models\UserBank;
require_once "../app/controllers/home.php";


/**
 * 
*/


class NewsCrud extends controller
{

	public function __construct(){

	}



	public function toggle_news($new_id)
	{

		$news = BroadCast::find($new_id);
		if ($news->status) {

		$update = $news->update(['status' => 0 ]);
		Session::putFlash('success', 'News unpublished succesfully');


		}else{

		$update = $news->update(['status' => 1 ]);

		Session::putFlash('success', 'News published succesfully');

		}

		Redirect::back();
	}




	public function delete_news($new_id)
	{

		$news = BroadCast::find($new_id);
		if ($news != null) {

		$update = $news->delete();
		Session::putFlash('success', 'Deleted succesfully');


		}


		Redirect::back("admin/news");
	}



	public function create_news(){

		print_r(Input::all());
		BroadCast::create([
						'broadcast_message' => Input::get('news'),
						'admin_id' => $this->admin()->id
						]);
		Session::putFlash('success', 'News Created succesfully');

		Redirect::back();
	}




}























?>