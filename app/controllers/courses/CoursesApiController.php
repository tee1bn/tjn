<?php


/**
 * this class is the default controller of our application,
 * 
*/
class CoursesApiController extends controller
{


	public function __construct(){

	}


	public function add_to_cart($course_id)
	{
		$course = Course::find($course_id);
		$image = $course->image;
		$course->image = $image ;


		foreach ($_SESSION['cart'] as $item) {
				$item = json_decode($item , true);
				if ($item['id'] == $course_id) {
					echo "Item already in cart!";

					return;
				}


		}

		$_SESSION['cart'][] =	$course->toJson();
		echo "Added successfully!";
	}



	public function retrieve_cart_in_session()
	{

// echo "<pre>";
header("content-type:application/json");
	$cart = $_SESSION['cart'];

	foreach ($cart as  $item) {

		 $item_array =  json_decode($item, true);
		unset($item_array['$$hashKey']);
		$items[] = $item_array;
	}

print_r(json_encode($items));
	

	}


	public function update_cart()
	{

		print_r($_POST);
		$_SESSION['cart'] = ($_POST['items']);

	}


	public function all_categories($page=1)
	{
		header("Content-type: application/json");
		// $per_page = 100;
		echo ProductsCategory::all();
		// ->forPage($page , $per_page);
	}


	public function find($course_id)
		{

		header("Content-type: application/json");
		// $per_page = 100;
			$course =  Course::find($course_id);
			$course->goal = $course->GoalJson;
			$course->curriculum = $course->CurriculumJson;
			$course->quizes = Questionaire::get();

			echo $course;
		}	


public function  index()
{

echo "<pre>";
		// header("Content-type: application/json");
		// $per_page = 100;



		$curriculum = [
				1 =>[

					'lectures'=>[

						0 => [
							'content'=>
								[
								'content'=>'uploads/dsds',
								'type'=>'pdf',
								],

							'title'=>'Lecture Title',
								],

				1 => [
							'content'=>
								[
								'content'=>'uploads/dsds',
								'type'=>'vidoe',
								],

							'title'=>'second Lecture Title',
								],


						],

						'title'=> 'First Section'
						],


	2=>[

					'lectures'=>[

						0 => [
							'content'=>
								[
								'content'=>'uploads/dsds',
								'type'=>'pdf',
								],

							'title'=>'Lecture Title',
								],

				1 => [
							'content'=>
								[
								'content'=>'uploads/dsds',
								'type'=>'vidoe',
								],

							'title'=>'second Lecture Title',
								],


						],

						'title'=> 'First Section'
						],



							];



print_r($curriculum);


		// echo json_encode( ($curriculum));
			



}

}























?>