<?php


/**
 * this class is the default controller of our application,
 * 
*/
class UserProfileController extends controller
{


	public function __construct(){

	}

	public function update_payment_info()
	{
		echo "<pre>";

		print_r(Input::all());
		print_r($_FILES);
		if (Input::exists('update_payment_info')) {


	$this->validator()->check(Input::all() , array(

		'account_name' =>[
				'required'=> true,
				'min'=> 3,
				'max'=> 32,					
					],
		'bank_name' =>[
				'required'=> true,
				'min'=> 3,
				'max'=> 32,					
					],
		'account_number' =>[
				'required'=> true,
				'numeric'=> true,
				'min'=> 3,
				'max'=> 32,					
					],
));


	 if($this->validator->passed()){

	 	$this->auth()->payment_information->update([
						'bank_account_name' 	=> Input::get('account_name'),
						'bank_account_number' 	=> Input::get('account_number'),
						'bank_name' 			=> Input::get('bank_name'),
						]);


	 	if ($_FILES['upload']['error'] !==4 ) {
		 $original_file =	$this->upload_userid_proof($_FILES);
		 	$this->auth()->payment_information->update(['id_proof' => $original_file]);

	 	}

	 	Session::putFlash('info','Payment Information updated successfully!');
	}else{



	}


		}


Redirect::to('user/payment-information');

	}




public function upload_userid_proof($files)
{

	print_r($files);



	$directory = 'uploads/images/users/id_proofs';
	$handle = new Upload($files['upload']);

                //if it is image, generate thumbnail
                if (explode('/', $handle->file_src_mime)[0] == 'image') {
			$handle->Process($directory);
	 		$original_file  = $directory.'/'.$handle->file_dst_name;

(new Upload($this->auth()->payment_information->id_proof))->clean();

return $original_file;

                }

}












public function change_password()
{

		if(/*Input::exists('change_password')*/ true){

	$this->validator()->check(Input::all() , array(

		'current_password' =>[
				'required'=> true,
				'min'=> 3,
				'max'=> 32,					
					],

		'new_password' =>[

				'required'=> true,
				'min'=> 6,
				'max'=> 32,					
					],

		'confirm_password' => [
						 'required'=> true,
					     'matches'=> 'new_password',
						]

		));



	if (! password_verify(Input::get('current_password'), $this->auth()->password)){
		$this->validator()->addError('current_password' , "current password do not match");

	}

 if($this->validator()->passed()){

 		User::find($this->auth()->id)->update(['password' => Input::get('new_password')]);

 		$user = User::where('id' , $this->auth()->id)->first();

 		 	Session::putFlash('success', "Password changed successfully!");

 }else{

 	// Session::putFlash('danger', "Please try again ");

 }


	
		}
		Redirect::back();

	}

	public function update_profile()
	{

echo "<pre>";
		if (/*Input::exists('update_user_profile')*/ true) {
		
		// print_r($_FILES);

			$user = User::find(MIS::dec_enc('decrypt', $_POST['user_id']));

			if ($user == null) {
				Redirect::back();
			}

	$this->validator()->check(Input::all() , array(


		'firstname' =>[
				'required'=> true,
				'max'=> '32',
				'min'=> '2',
					],


/*
		'username' => [
						// 'required'=> true,
						'min'=> 1,
						'one_word'=> true,
						'no_special_character'=> true,
						'replaceable'=> 'User|'.$this->auth()->id,
					],*/


		'email' => [
						'required'=> true,
						'email'=> true,
						'replaceable'=> 'User|'.$user->id,
					],

					
					'country' =>[
							// 'required'=> true,
							'country_or_state'=> true,
								],
					
					'state' =>[
							// 'required'=> true,
							'country_or_state'=> true,
								],

					'address' =>[
							// 'required'=> true,
								],
					
					'title' =>[
							// 'required'=> true,
								],
					'gender' =>[
							// 'required'=> true,
								],
					'birthdate' =>[
							// 'required'=> true,
							'date'=> 'Y-m-d',
							'min_age'=> '18',
								],

		'lastname' =>[
				'required'=> true,
				'max'=> '32',
				'min'=> '2',
					],

		'phone' =>[
				'required'=> true,
				'numeric'=> true,
				'max'=> '32',
				'min'=> '2',
				'replaceable'=> 'User|'.$user->id,
					],

		'bank_name' =>[
					// 'required'=> true,
					'max'=> '32',
					'min'=> '2',
						],

		'bank_account_name' =>[
				// 'required'=> true,
				'max'=> '32',
				'min'=> '2',
					],

		'bank_account_number' =>[
				// 'required'=> true,
				'numeric'=> true,
				'max'=> '32',
				'min'=> '2',
					],


	
		));


	 if($this->validator->passed()){
	 	if ($user->email != $_POST['email']) {

	 		$user->update(['email_verification'=>    md5(uniqid()) ]);
	 	}


	 	if ($user->phone != $_POST['phone']) {

	 		$user->update(['phone_verification'=> User::generate_phone_code_for($user->id)]);
	 	}



		$user->update(Input::all());




		Session::putFlash('success', 'Profile updated successfully!');

	}else{

// print_r($this->validator->errors());
		Session::putFlash('info', $this->inputErrors()." oo");
	}



	}



		Redirect::back();

	}

public function update_profile_picture()
{

	if ($_FILES['profile_pix']['error']!=4) {
		$profile_pictures =	$this->update_user_profile($_FILES);
		Session::putFlash('success','Profile Picture Updated Successfully.');
	}

	Redirect::back();
}


public function update_user_profile($file)
{
	$directory = 'uploads/images/users/profile_pictures';
	$handle = new Upload($file['profile_pix']);

                //if it is image, generate thumbnail
                if (explode('/', $handle->file_src_mime)[0] == 'image') {

				// $handle->file_new_name_body = "{$this->auth()->username}";

			$handle->Process($directory);
	 		$original_file  = $directory.'/'.$handle->file_dst_name;

                         // we now process the image a second time, with some other settings
                $handle->image_resize            = true;
                $handle->image_ratio_y           = true;
                $handle->image_x                 = 50;

				// $handle->file_new_name_body = "{$this->auth()->username}";
                $handle->Process($directory);

                $resize_file    = $directory.'/'.$handle->file_dst_name;


                }


$profile_pictures = ['original_file' =>$original_file , 'resize_file'=>$resize_file];


if ($this->auth()->profile_pix != Config::default_profile_pix()) {
(new Upload($this->auth()->profile_pix))->clean();
}

if ($this->auth()->resized_profile_pix != Config::default_profile_pix()) {
(new Upload($this->auth()->resized_profile_pix))->clean();
}

	$this->auth()->update([
				'profile_pix' => $profile_pictures['original_file'],
				'resized_profile_pix' => $profile_pictures['resize_file']
				]);



return $profile_pictures;
}

}























?>