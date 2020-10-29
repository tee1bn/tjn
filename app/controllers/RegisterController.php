<?php
@session_start();
/**



*/
class RegisterController extends controller
{

	public function __construct(){


		}



	public function confirm_email($email_verification_token, $email)
	{

 		$user = User::where('email', $email)
			->where('email_verification', $email_verification_token)
			->first();
		if ($user != null) {

			$update = $user->update(['email_verification'=> 1]);

			if ($update) {

				Session::putFlash('success', 'Email verified successfully');

			}else{

				Session::putFlash('danger', 'Email verification unsuccesfully');

			}

		}

		Redirect::to('login');
	}



	public function confirm_phone()
	{


		if (Input::exists('fe') || true ) {

			$this->validator()->check(Input::all() , array(

					'phone_code' =>[

						'required'=> true,
						'exist'=> 'User|phone_verification',
							],
			
						));

		}

		 if($this->validator()->passed()){




				if ($this->auth()->phone_verification == Input::get('phone_code')) {

					$update = $this->auth()->update(['phone_verification'=> 1]);

					if ($update) {

						Session::putFlash('success', 'Phone verified successfully');

					}else{

						Session::putFlash('danger', 'Phone verification unsuccessful.');

					}



					Redirect::to('login');

				}else{

					Session::putFlash('danger', 'Phone verification unsuccessful.');

				}

		}
		Redirect::back();
	}



	public function verify_phone()
	{
		$message = "Dear ".$this->auth()->firstname.", your code is ".$this->auth()->phone_verification." from ".Config::project_name();
		$phone   =  $this->auth()->phone ;

		return (new	SMS)->send_sms($phone, $message);
	}


	public function send_credential($user_id, $password)
	{
		ob_start();



	 $user =  User::find($user_id);
	 $name =  $user->firstname;
	 $email =  $user->email;
	 $username =  $user->username;

	 $subject 	= 'SUCCESSFUL REGISTRATION';
	 $body 		= $this->buildView('emails/credential-message', [
																	'password' => $password,
																	'name' => $name,
																	'username' => $username,
																	'email' => $email,
																	'email_verification_token' => $user->email_verification,
																	]);


		$to 		= $email;




		$mailer = new Mailer;
		$status = $mailer->sendMail($to, $subject, $body, $reply='', $recipient_name='');

		$response =   (! $status) ? 'false' : 'true';

		// ob_end_clean();

		echo $response;
	}


	public function verify_email()
	{


		ob_start();

			 $user =  $this->auth();
			 $name =  $user->firstname;
			 $email = $user->email;

			$subject 	= 'EMAIL VERIFICATION';
	 		$body 		= $this->buildView('emails/email-verification', [
																	'name' => $name,
																	'email' => $email,
																	'email_verification_token' => $user->email_verification,
																	]);


			$to 		= $email;

			$email_verification_token = $user->email_verification ;
			$email = $user->email ;



			/*
			$body = 'Thank you for signing up at '.Conproject_name.', \n please click this link to continue '.domain.'/register/confirm_email/'.$email.'/'.$email_verification_token.'';*/

			// $status =  mail($email, $subject, $link);

			$mailer = new Mailer;
			$status = $mailer->sendMail($to, $subject, $body, $reply='', $recipient_name='');

		

		ob_end_clean();

		if ($status) {
			Session::putFlash('success', "Verification Mail Sent!");
		}else{
			Session::putFlash('danger', "Verification Mail Could not Send.");
		}

	}




	public function generate_phone_code_for($user_id)
	{

	 	$remaining_code_length =   6 -	strlen($user_id) ;
	 	$min = pow(10, ($remaining_code_length-1));
	 	$max = pow(10, ($remaining_code_length)) - 1;
	 	
	 	$remaining_code = random_int($min, $max);

	 	return  $phone_code = $user_id.$remaining_code;
	}



	
	public function index()
	{
		
		$this->view('auth/register');
	}


	/**
	 * handles the first stage of user registration
	 * @return [type]
	 */
	public function register()
	{

		if (Input::exists('user_registration') || true) {
			// print_r(Input::all());
			
			// MIS::verify_google_captcha();

			$this->validator()->check(Input::all() , array(


				'firstname' =>[
						'required'=> true,
						'max'=> '32',
						'min'=> '2',
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
							],
			
				/*
				'username' => [
								'required'=> true,
								'min'=> 3,
								'one_word'=> true,
								'no_special_character'=> true,
								'unique'=> 'User',
							],*/


				'email' => [
								'required'=> true,
								'email'=> true,
								'min'=> 3,
								'unique'=> 'User',
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
				
				'city' =>[
						// 'required'=> true,
							],
				

				'password' => [

							'required'=> true,
							'min'=> 3,
							'max'=> 32,
							]
							,

				/*'introduced_by' => [
								'exist'=> 'User|username',
							],*/

			));


			$enroler =  User::where('username', Input::get('introduced_by'))->first();



		 	if($this->validator->passed()  ){


				$introduced_by  =  $this->get_referral(Input::get('introduced_by'));

				$referred_by = User::where_to_place_new_user_within_team_introduced_by($introduced_by);
				$placement_sponsor = User::where('mlm_id', $referred_by)->first();
				$former_downline_id =  (@array_values($placement_sponsor->placement_cut_off))[0];

				$username  					=  $this->generate_username_from_email(Input::get('email'));
			 	$user_details 				=  Input::all();
			 	$user_details['referred_by'] 	=  $referred_by ;
			 	$user_details['introduced_by'] 	=  $introduced_by ;
			 	$user_details['username'] 	=  $username ;
			 	$user_details['country'] 	=  160; //Nigeria

			 	$user_details['email_verification'] = MIS::random_string();

		 		
		 		 $new_user  =  User::create($user_details);
			 	$phone_verification = User::generate_phone_code_for($new_user->id);
			
				 $new_user->update(['mlm_id' => $new_user->id , 'phone_verification' => $phone_verification]) ;


				if ($former_downline_id != '') { //sponsor has an void place position
						User::replace_any_cutoff_mlm_placement_position($referred_by, $new_user->id);
				}

		 	

			 	if($new_user){

			 		Session::putFlash('success', "Registration Successful!.");
			 		$this->directly_authenticate($new_user->id);
			 		// Redirect::to("login");

			 		$status = 1 ;
			 		header('content-type:application/json');
			 		echo  json_encode(compact('status'));
			 		return;
			 	}


			}else{
			 	Session::putFlash('danger', Input::inputErrors());
			}			
		}

		Redirect::back();
	}


public function get_referral($referral_username='')
{


 return User::where('username', Input::get('introduced_by'))->first()->mlm_id;





}

/**
 * directly set the user as authenticated
 * @param  int $user_id
 * @return null
 */
private function directly_authenticate($user_id)
{
 		Session::put($this->auth_user() , $user_id);
}


public function generate_username_from_email($email)
{

 	$username = explode('@', $email)[0];

	$i = 1;
 do{
 	$loop_username = ($i==1)? "$username" :"$username".($i-1);
 	$i++;
 	}while(User::where('username', $loop_username)->get()->isNotEmpty());


	return $loop_username;

 }




public function sendWelcomeEmail($user_id , $password)
{


 $new_user= User::find($user_id);


		$mailer  = new Mailer();
		$subject = $this->name." SUCCESSFUL REGISTRATION!!";

		$body    = $this->buildView('emails/registration-welcome-mail', [
															'firstname' => $new_user->firstname,
															'user_id' 	=> $new_user->username,
															'password' 	=> $password,
																]);

		$to = $new_user->email;
		$recipient_name = $new_user->firstname;

 	if($mailer->sendMail($to, $subject, $body, $reply='', $recipient_name)){
 		return ;
 	}



 }

}




















?>