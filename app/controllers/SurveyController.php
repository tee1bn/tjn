<?php

use Illuminate\Database\Capsule\Manager as DB;


class SurveyController extends controller
{

	public function __construct(){

	}	




	public function create_questionaire()
	{
		$questionaire = Questionaire::create([]);

		     $code = $questionaire->id.MIS::random_string(20);
             $questionaire->update(['code' => $code]);
            //log in the DB
          
        $link2 = Config::domain()."/survey/edit-questionaire/{$questionaire->id}";


		Redirect::to($link2);
	}



	public function edit_questionaire($questionaire_id)
	{
		$questionaire = Questionaire::find($questionaire_id);

		if ($questionaire == null) {
			Redirect::back();
		}

		
		$this->view('admin/edit_questionaire', compact('questionaire'));
	}
	


	public function preview_questionaire($questionaire_id)
	{

		$questionaire = Questionaire::find($questionaire_id);


		 $form =  $questionaire->html_form() ;



		if ($questionaire == null) {
			Redirect::back();
		}

		$this->view('preview_questionaire', compact('questionaire'));
	}


	public function questionaire_responses($questionaire_id)
	{

		$questionaire = Questionaire::find($questionaire_id);
	    $form =  $questionaire->html_form() ;
		if ($questionaire == null) {
			Redirect::back();
		}
		$this->view('admin/questionaire_responses', compact('questionaire'));

	}


	public function delete_questionaire($questionaire_id)
	{


		$questionaire = Questionaire::find($questionaire_id);
		if ($questionaire == null) {
			Redirect::back();
		}


		DB::beginTransaction();

		try {
			
			$questionaire->delete();
			DB::commit();
			Session::putFlash("primary", "Deleted successfully");
		} catch (Exception $e) {
			DB::rollback();
			Session::putFlash("danger", "Something went wrong");
			
		}

			Redirect::back();
	}
	


	public function questionaire_responses_table($questionaire_id)
	{

		$questionaire = Questionaire::find($questionaire_id);
	    $form =  $questionaire->html_form() ;
		if ($questionaire == null) {
			Redirect::back();
		}


		$this->view('admin/questionaire_responses_table', compact('questionaire'));
	}
	

	public function surveys()
	{

		$this->view('survey/surveys.php');
	}



	public function index()
	{
		echo "we are in survey";
	}

}























?>