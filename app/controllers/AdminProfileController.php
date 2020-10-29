<?php


/**



*/
class AdminProfileController extends controller
{



	public function __construct(){


		
	$this->middleware('administrator')->mustbe_loggedin();
		// $this->middleware('administrator')->mustbe_super_admin();




	}
	
	
	

	public function suspending_admin($admin_id=null)
	{


		$admin = Admin::find($admin_id);
		if ($admin == null) {
				Redirect::back();
		}

		if ($admin->is_owner()) {
			Session::putFlash('danger', "Invalid Request");
			Redirect::back();
		}


		if ($admin->status ==1) {

			$admin->update(['status' => null]);
		}


		if ($admin->status !=1) {

			$admin->update(['status' => 1]);
		}


		Session::putFlash('success', "Changes saved succesfully");
		Redirect::back();
	}


	public function delete_admin($admin_id)
	{
		$admin = Admin::find($admin_id);
		if ($admin == null) {
				Redirect::back();
		}

		if ($admin->is_owner()) {
			Session::putFlash('danger', "Invalid Request");
			Redirect::back();
		}else{

			$admin->delete();
			Session::putFlash('success', "Deleted Succesfully");
		}

		Redirect::back();
		
	}





	public function updatePassword()
	{
			if (Input::exists('admin_update_password') || true) {

				$this->validator()->check(Input::all() , array(
					'current_password' => [

											'required'=> true,
									],
					'new_password' => [

											'required'=> true,
											'min'=> 3,
											'max'=> 32,
									],
					'confirm_password' => [

											'required'=> true,
											'min'=> 3,
											'max'=> 32,
											'matches'=> 'new_password',
									]
				));

				if (! password_verify(Input::get('current_password'), $this->admin()->password)){
					$this->validator()->addError('current_password' , "current password do not match");

				}

			 	if($this->validator->passed()){

				 	$admin  = $this->admin()->update([
				 				'password' => Input::get('new_password') ,
				 				]);
				 	if($admin){
				 		Session::putFlash('success', "Password updated succesfully.");
				 	}
			 	}else{


		 		}
			}

				Redirect::back();
	}

	



	public function index()
	{
		
	
		$this->view('admin/admin-profile');  
	}

		

	public function add_admin()
	{
		echo "<pre>";
		print_r($_POST);


		$this->validator()->check(Input::all() , array(

				'firstname' =>[

					'required'=> true,
					'min'=> 2,
					'max'=> 32,
						],
				'lastname' =>[

						'required'=> true,
						'min'=> 2,
						'max'=> 32,
							],

				'email' => [

								'required'=> true,
								'email'=> true,
								'unique'=> 'Admin',
							],

				'username' => [

								// 'required'=> true,

								'min'=> 3,
								// 'one_word'=> true,
								'no_special_character'=> true,
								'unique'=> 'Admin',
							],

				'phone' => [

								'required'=> true,
								'min'=> 9,
								'max'=> 14,
								'unique'=>'Admin',

							],

		));



		if(! $this->validator->passed()){

			Session::putFlash('danger', Input::inputErrors());
			Redirect::back();
		}

			try {
				
					$password = 111;
				 	$admin_updated =  Admin::create([
					 				'firstname' => Input::get('firstname') ,
					 				'lastname' => Input::get('lastname') ,
					 				'email' => Input::get('email') ,
					 				'phone' => Input::get('phone') ,
					 				'password' => $password ,
				 				
				 				]);


			} catch (Exception $e) {
				print_r($e->getMessage());

				Session::putFlash('danger', "Something went wrong");
			}

		Redirect::back();
	}



	public function updateAdminProfile($admin_id){


		print_r(Input::all());
		if (Input::exists('update_admin_profile') || true) {


		echo		$admin = Admin::find($admin_id);



			$this->validator()->check(Input::all() , array(

					'firstname' =>[

						'required'=> true,
						'min'=> 2,
						'max'=> 32,
							],
					'lastname' =>[

							'required'=> true,
							'min'=> 2,
							'max'=> 32,
								],

					'email' => [

									'required'=> true,
									'email'=> true,
									'replaceable'=> 'Admin|'.$admin->id,
								],

					'username' => [

									// 'required'=> true,

									'min'=> 3,
									// 'one_word'=> true,
									'no_special_character'=> true,
									'replaceable'=> 'Admin|'.$admin->id,
								],

					'phone' => [

									'required'=> true,
									'min'=> 9,
									'max'=> 14,
									'replaceable'=>'Admin|'.$admin->id,

								],

			));

			if($this->validator->passed()){

				try {
					

					 	$admin_updated =  $admin->update([
					 				'firstname' => Input::get('firstname') ,
					 				'lastname' => Input::get('lastname') ,
					 				'email' => Input::get('email') ,
					 				'phone' => Input::get('phone') ,
					 				
					 				]);

				} catch (Exception $e) {
					print_r($e->getMessage());
				}
			 	if($admin_updated){

			 		Session::putFlash('success', "Updated succesfully.");

			 	}
		 	}else{


		 		Session::putFlash('info', Input::inputErrors());
			}
		}

		// Redirect::back();
	}



}























?>