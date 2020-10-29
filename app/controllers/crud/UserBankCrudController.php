<?php
use v2\Models\UserBank;
use v2\Models\AdminComment;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * 
*/
class UserBankCrudController extends controller
{


	public function __construct(){

	}


	public function push_to_state()
	{
	
		$doc_id = $_POST['doc_id'];
		$state = $_POST['status'];
		$comment = $_POST['comment'];
		$doc = UserBank::find($doc_id);

		if (($doc == null) ) {
			Session::putFlash('danger','File Not Found');
			Redirect::back();
		}


		DB::beginTransaction();	
		try {

			AdminComment::create([
						'admin_id' => $this->admin()->id,
						'model' => 'bank',
						'model_id' => $doc->id,
						'comment' => $comment,
						'status' => $state						
			]);
			
			$doc->update([
				'status'=> $state
			]);

			Session::putFlash('success','Changes saved successfully');


			DB::commit();	
		} catch (Exception $e) {
			DB::rollback();	
			print_r($e->getMessage());
			Session::putFlash('danger','Something went wrong');
		}

		Redirect::back();
	}


	public function add_user_bank()
	{

		$auth = $this->auth();

		echo "<Pre>";


		if (true) {

			$this->validator()->check(Input::all() , array(

				'bank_id' =>[
						'required'=> true,
						'min'=> 1,
						'max'=> 32,					
							],
				'account_number' =>[
						'required'=> true,
						'numeric'=> true,
						'min'=> 10,
						'max'=> 10,					
							],
			));


			if($this->validator->passed()){

			 	$bank_detail = Input::all();
			 	$bank_detail['user_id'] = $auth->id;
			 	$b = UserBank::create_or_update($bank_detail);

			 	if ($b) {
					Session::putFlash('success', "Changes Saved Successfully" );
			 	}

		print_r($_POST);

			}else{
				Session::putFlash('danger', Input::inputErrors());


			}


		}


		Redirect::back();

		


	}




	public function index()
	{

		$this->view('auth/error');

	}




}























?>