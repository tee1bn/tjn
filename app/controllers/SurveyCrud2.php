<?php

use Illuminate\Database\Capsule\Manager as DB;


class SurveyCrud2 extends controller
{
	public function __construct(){


	}	



	



	public function fetch_response($questionaire_id)
	{


		$questionaire = $this->find_questionaire($questionaire_id);

		$questionaire_response  = QuestionaireResponse::where('questionaire_id', $questionaire_id)->get();

	/*	echo "<pre>";
		print_r($questionaire_response->toArray());

*/

		$response = compact('questionaire','questionaire_response');

	/*	echo "<pre>";

		print_r($response);
		print_r(func_get_args());
		print_r($this);*/

		echo  json_encode($response);
	}




	public function find_questionaire($questionaire_id)
	{


		$questionaire = Questionaire::find($questionaire_id);

		if ($questionaire == null) {
			Redirect::back();
		}

		$form_fields = [
							'input',
							'select',
							'textarea' 
					];
			
			$questionaire->questions = ($questionaire->decodeQuestions);

			$response = compact('questionaire', 'form_fields');

			return $response;
	}




	public function fetch_questions($questionaire_id)
	{


		$response  = $this->find_questionaire($questionaire_id);

		header("content-type:application/json");

		echo json_encode($response);

	}


	public function update()
	{
		echo "<pre>";
		$questionaire_array = json_decode($_POST['questionaire'], true);


		$questions = $questionaire_array['$questions'];

		foreach ($questions as $key => $question) {
			$questions[$key]['$index'] = $key;
		}

		$questionaire = Questionaire::find($_POST['id']);


		if ($questionaire == null) {
			Redirect::back();
		}

		DB::beginTransaction();

		try {
			
				 $questionaire->update([
									'title' => $_POST['title'],
									'success_response_note' => $_POST['success_response_note'],
									'is_published' => $_POST['is_published'],
									'description' =>  $_POST['description'],
									'alotted_time' =>  $_POST['alotted_time'],
									'questions_served' =>  $_POST['questions_served'],
									'questions' => json_encode($questions),
									]);

			DB::commit();
			Session::putFlash("primary", "Saved Successfully");
		} catch (Exception $e) {

			print_r($e->getMessage());
			DB::rollback();
			Session::putFlash("danger", "Something went wrong.");
			
		}



	}



	public function update_questionaire()
	{

		 $questionaire = Questionaire::find($_POST['id']);

		if ($questionaire == null) {
			Redirect::back();
		}

		DB::beginTransaction();

		try {
			

				 $questionaire->update([
									'title' => $_POST['title'],
									'is_published' => $_POST['is_published'],
									'description' =>  $_POST['description'],
									]);

			DB::commit();
			Session::putFlash("success", "Saved Successfully");
		} catch (Exception $e) {

			print_r($e->getMessage());
			DB::rollback();
			Session::putFlash("danger", "Something went wrong.");
			
		}

		Redirect::back();
	}



	public function index()
	{

		echo "<pre>";
		$questionaire_array = json_decode($_POST['questionaire'], true);


		$questions = $questionaire_array['$questions'];

		foreach ($questions as $key => $question) {
			$questions[$key]['$index'] = $key;
		}

		$questionaire = Questionaire::find($_POST['id']);


		if ($questionaire == null) {
			Redirect::back();
		}

		DB::beginTransaction();

		try {
			
				 $questionaire->update([
									'title' => $_POST['title'],
									'success_response_note' => $_POST['success_response_note'],
									'is_published' => $_POST['is_published'],
									'description' =>  $_POST['description'],
									'alotted_time' =>  $_POST['alotted_time'],
									'questions_served' =>  $_POST['questions_served'],
									'questions' => json_encode($questions),
									]);

			DB::commit();
			Session::putFlash("primary", "Saved Successfully");
		} catch (Exception $e) {

			print_r($e->getMessage());
			DB::rollback();
			Session::putFlash("danger", "Something went wrong.");
			
		}



			}

}























?>