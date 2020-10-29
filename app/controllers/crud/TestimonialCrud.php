<?php
use v2\Models\UserBank;
require_once "../app/controllers/home.php";


/**
 * 
*/


class TestimonialCrud extends controller
{

	public function __construct(){

	}



	
		public function create_testimonial()
	    {

	    	if (Input::exists() || true) {

		    	$testimony = Testimonials::create([
		    						'attester' => Input::get('attester'),
									  'content'  =>Input::get('testimony')]);

	    	}
	    	Redirect::to("admin/edit_testimony/{$testimony->id}");
	    }





		public function testimonials()
		{
			$this->view('admin/testimonials');

		}

		public function approve_testimonial($testimonial_id)
		{

			$testimony = Testimonials::find($testimonial_id);
			if ($testimony->approval_status) {

			$update = $testimony->update(['approval_status' => 0 ]);
			Session::putFlash('success', 'Testimonial disapproved succesfully');


			}else{

			$update = $testimony->update(['approval_status' => 1 ]);

			Session::putFlash('success', 'Testimonial approved succesfully');

			}


			Redirect::back();
		}

		public function delete_testimonial($testimonial_id)
		{

			$testimony = Testimonials::find($testimonial_id);
			if ($testimony != null) {

			 $testimony->delete();
				Session::putFlash('success', 'Testimonial deleted succesfully');


			}


			Redirect::back();
		}


	 	public function update_testimonial()
	    {

	    	echo "<pre>";
	    	$testimony_id = Input::get('testimony_id');
	     	$testimony = Testimonials::find($testimony_id);

	    	$testimony->update([
	    						 'attester' =>Input::get('attester'),
								  'content'  =>Input::get('testimony'),
								  'approval_status' => 0 
								]);


	    	Session::putFlash('success','Testimonial updated successfully. Awaiting approval');

	    	Redirect::back();
	    }




}























?>