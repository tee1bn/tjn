<?php

use  v2\Models\Market;
use Illuminate\Database\Capsule\Manager as DB;


/**
 * this class is the default controller of our application,
 * 
*/
class CoursesController extends controller
{


	public function __construct(){


			$this->middleware('current_user')
				->mustbe_loggedin()
				->must_have_verified_email();
	}




	public function add_publish_details()
	{
						// $this->middleware('current_user')->mustbe_loggedin();
		echo "<pre>";	

		print_r($_POST);

		if (Input::exists('publish_details_form')) {

			print_r(Input::all());
			$course_id =  Input::get('course_id');
			$course = Course::find($course_id);


			$course->update(Input::all());
			$course->update([
				'offers'=> json_encode($_POST['offers']),
			]);
			$course_thumnail = $this->upload_course_thumnail($_FILES['image'], $course);
			$course->update(['image' => $course_thumnail, 'status' => 'Draft' ]);

			Session::putFlash('success' , 'Course Publish details saved  successfully! You should submit for review to finally go Live');
		}


		Redirect::to("courses/$course_id/publish");
	}


public function upload_course_thumnail($file, $course)
{
					// $this->middleware('current_user')->mustbe_loggedin();

	(new Upload($course->image))->clean();

	$directory = 'uploads/files/courses_thumbnails';
	$handle =  new Upload($file);
	$handle->process($directory);

	$destination = $directory.'/'.$handle->file_dst_name;
	return $destination;
}


	public function add_course_curriculum()
	{
		// $this->middleware('current_user')->mustbe_loggedin();

		echo "<pre>";
		$curriculum = json_decode($_POST['curriculum'], true);

		$course =	Course::find(Input::get('course_id'));


		// print_r($curriculum);

		// print_r($_POST);
		// print_r(MIS::refine_multiple_files($_FILES['section']));

		// return;	

		$course->update([
							'status' => 'Draft', 
							'curriculum'=> json_encode( ($curriculum['$sections']))
						]);
		Session::putFlash('info', "Curriculum Saved successfully!");

		// echo $course;

		Redirect::back();
	}



public function upload_lecture_file_content($file , $section=null , $lecture=null)
{
					//$this->middleware('current_user')->mustbe_loggedin();

		$directory = 'uploads/files/courses_lectures';
		$handle = new Upload($file);
		$handle->allowed  = ['application/pdf', 'video/*'];
		$handle->mime_check = true;
	// $new_name=	$handle->file_new_name_body = uniqid(32);
		$handle->process($directory);

		if (! $handle->process()) {
			Session::putFlash("info" ,"Pls Ensure files are either pdf or a video less than");
		}

		$path = $directory.'/'.$handle->file_dst_name;

		return [$handle, $path];

}




	private function fetch_lecture_content($section, $lecture)
	{

			$file['name'] = $_FILES['sections']['name'][$section][$lecture];
			$file['type'] = $_FILES['sections']['type'][$section][$lecture];
			$file['tmp_name'] = $_FILES['sections']['tmp_name'][$section][$lecture];
			$file['error'] = $_FILES['sections']['error'][$section][$lecture];
			$file['size'] = $_FILES['sections']['size'][$section][$lecture];

			return $file;
		


	}



	public function create()
	{

				//$this->middleware('current_user')->mustbe_loggedin();
	
	$course =	Course::create([
						'instructor_id' => $this->auth()->id,
						]);

	//set the goal for this course
	Redirect::to("courses/{$course->id}/goal");
	}






	public function update($course_id='')
	{
						// $this->middleware('current_user')->mustbe_loggedin();

echo "<pre>";
		print_r(Input::all());




	 	$course = Course::find($course_id);
		
		$input = Input::all();
		unset($input['course_id']);

		$goal =	json_encode($input);

		$course->update(['goal' => $goal, 'status' => 'Draft']);

		Session::putFlash('success',"Changes saved sucessfully!");

		Redirect::to("courses/$course_id/goal");

	}



	public function preview($course_id, $section_index, $lecture_index)
	{
echo "<pre>";
		
		$own_courses = $this->auth()->created_courses->pluck('id')->toArray();
		if (in_array($course_id, $own_courses)) {

			$this->download_file($course_id, $section_index, $lecture_index);

		}else{

			Session::putFlash('' ,'You do not have access to view the file');

			Redirect::to('courses');
		}


	}




public function get_file($course_id, $section_index, $lecture_index)
{
		$this->middleware('current_user')->mustbe_loggedin();

	if(! $this->auth()->is_enrolled_on($course_id)){
		Session::putFlash('',"Denied Access !");
		Redirect::to("courses/$course_id/access");
	};
		

			$this->download_file($course_id, $section_index, $lecture_index);

Redirect::to("courses/$course_id/access");
}




public function get_file_for_admin($course_id, $section_index, $lecture_index)
{
		//$this->middleware('administrator')->mustbe_loggedin();

	
			$this->download_file($course_id, $section_index, $lecture_index);

Redirect::to("courses/$course_id/view");
}













private function download_file($course_id, $section_index, $lecture_index)
{
	if ($course_id !== null) {
				$course = Course::find($course_id);
			}

	$curriculum_array 	=	json_decode(json_encode($course->curriculum), true);
	$content 			= $curriculum_array[$section_index]['lectures'][$lecture_index]['content']['path'];
	$mime_type 			= $curriculum_array[$section_index]['lectures'][$lecture_index]['content']['content'];
	$lecture_title 		= $curriculum_array[$section_index]['lectures'][$lecture_index]['title'];
	$lecture_title 		=  str_replace( ' ', '-', Config::project_name()) .'-'.str_replace( ' ', '-', $lecture_title);
	$pathinfo 			= pathinfo($content);

print_r($pathinfo);


 if(file_exists($content)) {
        header('Content-Description: File Transfer');
        header("Content-Type: $mime_type");
        header('Content-Disposition: attachment; filename="'.$lecture_title.'.'.$pathinfo['extension'].'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        flush(); // Flush system output buffer
        readfile($content);
        exit;
    }else{
    	Session::putFlash('','Seems this file is not available at the moment pls try again');
    }

}



public function access_course($course_id)
{


	$accessible_courses_ids = $this->auth()->enrolled_courses()->pluck('id')->toArray();
	$course = Course::find($course_id);



	if((! in_array($course_id, $accessible_courses_ids)) || ($course == null)){
		Session::putFlash('info',"You should purchase a lifetime access to this course !");
		Redirect::to($course->ViewLink);
	};


	$item_on_sale =	Market::where('category', 'course')
								->where('item_id', $course_id)
								->latest()
								->OnSale()
								->first();

	if ($item_on_sale == null) {

		Session::putFlash("danger", "Denied Access! More attempts will lead to blockage of account");
		Redirect::back();
	}


	$course = $item_on_sale->good();

 $this->view('auth/single-course', ['course' => $course, 'access' => 'granted']);
}





public function read($course_id=null, $chapter= 1)
{
	// return;
	$accessible_courses_ids = $this->auth()->enrolled_courses()->pluck('id')->toArray();
	$course = Course::find($course_id);

	
	if((! in_array($course_id, $accessible_courses_ids)) || ($course == null)){
		Session::putFlash('info',"You should purchase a lifetime access to this course !");
		Redirect::to($course->ViewLink);
	};




		$item_on_sale =	Market::where('category', 'course')
								->where('item_id', $course_id)
								->latest()
								->OnSale()
								->first();



	if ($item_on_sale == null) {
		Session::putFlash("danger", "Denied Access More attempts will lead to blockage of account");
		Redirect::back();
	}


	$course = $item_on_sale->good();

	
	$this->view('auth/read-course', compact('course', 'chapter'));
}


	/**
	 * this is the default landing point for all request to our application base domain
	 * @return a view from the current active template use: Config::views_template()
	 * to find out current template
	 */
	public function index($course_id=null, $action=null )
	{

		if ($course_id !== null) {
			$course = Course::find($course_id);



			switch ($action) {
				case 'goal':
				$this->view('auth/course-goal', ['course' => $course]);
				return;
				break;
				
				case 'access':

				$this->access_course($course_id);

				return;
				break;

				case 'structure':
				$this->view('auth/course-structure', ['course' => $course]);
				return;
				break;
				
				case 'curriculum':
				$this->view('auth/course-curriculum', ['course' => $course]);

				return;
				break;
				
				case 'publish':
				$this->view('auth/publish-course', ['course' => $course]);
				return;
				break;
				
				case 'view':
				$this->view('guest/single-course',['course' => $course]);
				return;
				break;
				
				default:
					# code...
					break;
			}

		}

		$this->view('auth/courses');
	}














		public function details($course_id=null)
		{
			$this->view('guest/course-detail');
		}

}























?>