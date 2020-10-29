<?php
@session_start();
/**



*/
class LoginController extends controller
{

	public function __construct(){
	      // print_r($_SESSION);
	}




	public function admin_login()
	{
		
	/*if($this->auth() ){
		Redirect::to('admin-dashboard');
	}*/
	$this->view('admin/login', []);

}



	// authenticateing admnistrators
public function authenticateAdmin()
{

	if(/*Input::exists('admin_login')*/ true){


		$trial = Admin::where('email', Input::get('user'))->first();

		if ($trial == null) {

			$trial = Admin::where('username', Input::get('user'))->first();
		}


		$email = $trial->email;





		$admin = Admin::where('email', $email)->first();
		$password = Input::get('password') ;
		$hash = $admin->password;
		if(password_verify($password, $hash)){



			Session::put('administrator', $admin->id);

			echo $this->admin();

			Session::putFlash('success',"Welcome Admin $admin->firstname");
			Redirect::to('admin-dashboard');

		}else{
			Session::putFlash('danger','Invalid Credentials');
			$this->validator()->addError('credentials' , "<i class='fa fa-exclamation-triangle'></i> Invalid Credentials.");

			Redirect::back();
		}




	}




}



public function index()
{
	
	if($this->auth()){
		Redirect::to("user/dashboard");
	}

	$model = 'courses';
	$this->view('auth/login', compact('model'));
}









	/**
	 * this function handles user authentication
	 * @return instance of eloquent object of the authenticated User model
	 */
	public function authenticate()
	{

		if(/*Input::exists("user_login")  */ true){
// 			print_r(Input::all());

		 	MIS::verify_google_captcha();


			parse_str($_SERVER['HTTP_REFERER'], $referral_url );
			$intended_route =  array_values($referral_url)[0];	
			



			$trial = User::where('username', Input::get('user'))->first();
			
			if ($trial == null) {

				$trial = User::where('email', Input::get('user'))->first();
			}



			$username = $trial->username;
			$result   = $this->authenticate_with($username , Input::get('password') );



			if ($result) {


				if ($intended_route != null) {
					Redirect::to($intended_route);
				}

			}else{

				$this->validator()->addError('user_login' , "<i class='fa fa-exclamation-triangle'></i> Invalid Credentials.");


			}


		}

		print_r($this->validator()->errors());


		Redirect::to("user");

	}



	public function logout($user=''){

		if($user == 'admin'){

			session_destroy();
			Redirect::to('login/admin_login');
			
		}else{

			unset($_SESSION[$this->auth_user()]);
		}



		Redirect::to('login');

		
	}






}























?>