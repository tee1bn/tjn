<?php
@session_start();

use v2\Security\TwoFactor;

	/**
	 * this is the base controller which other conrtollers extends
	 */
	require_once 'operations.php';

	class controller extends operations
	{


	public function verify_2fa_only($auth=null)
	{
		if ($auth == null) {
			$auth = $this->auth();
		}


			$_2FA = new TwoFactor($auth);

			if (! $_2FA->hasLogin($_POST['code'])) {
				Session::putFlash('danger', "Invalid 2FA Code");
				Redirect::back();
			}


	}

	public function verify_2fa()
	{
		$auth = $this->auth();

		if ($auth->has_2fa_enabled()){

			$this->verify_2fa_only();

		}else{

			print_r($_SESSION['twofa']);

			$this->validator()->check(Input::all() , array(	

					'email_code' => [
								 'required'=> true,
								 // 'equals'=> $_SESSION['twofa']['email_code'],
								]
					));


			if ($_SESSION['twofa']['email_code'] != trim($_POST['email_code'])) {
				Session::putFlash('danger', "Invalid Email Code");
				Redirect::back();
			}

			if (!$this->validator()->passed()) {
				Session::putFlash('danger', "Email Code is required");
				Redirect::back();
			}

			unset($_SESSION['twofa']);

		}
	}




	public function use_2fa()
	{

		if (!$this->auth()->has_2fa_enabled()){return;}

		$form = <<<FORM
		  <div class="form-group">
		    <label>2FA Code</label>
		    <input type="" name="code" required="" placeholder="Enter Google 2FA 6 digit code" class="form-control">
		  </div>
FORM;
		return $form;
	}
	


public function use_2fa_protection()
{

	if ($this->auth()->has_2fa_enabled()) {

		$form = $this->use_2fa();

	}else{

		$form = $this->use_email_as_2fa();
	}

	return $form;
}

public function create_2fa_code()
{
	$_SESSION['twofa']['expiry_time'] = $expiry_time = date("Y-m-d H:i:s", strtotime("+ 10 min"));
	$_SESSION['twofa']['email_code'] = MIS::random_string(6, 'numeric');
	$code = $_SESSION['twofa']['email_code'];

	return $code;
}


public function create_email_code()
{
	$mailer = new Mailer;
	$auth = $this->auth();
	$to = $auth->email;
	$subject = "Authorization Email Code";


	if (isset($_SESSION['twofa']['expiry_time'])) {
		$expiry_time = $_SESSION['twofa']['expiry_time'];
		if (strtotime($expiry_time) <= time() ) {
			$code =	$this->create_2fa_code();
		}else{
			$code = $_SESSION['twofa']['email_code'];
		}
	}else{
		$code = $this->create_2fa_code();
	}


	$content = "
				<p>Dear $auth->firstname,</p>

				<p>Kindly enter the code below to authorize the pending action.</p>
				<p>Email Code: $code </p>

	";


	$content = MIS::compile_email($content);

	//client
	$response =$mailer->sendMail(
				    "{$to}",
					"$subject",
				    $content,
				    "{$document->user->firstname}",
				    "{$support_email}",
				    "$project_name"
				);
	if ($response== true) {

		Session::putFlash("success","Email Code sent to your email");

	}else{

		Session::putFlash("danger","Email Code could not be sent. Please try again.");
	}
}



public function use_email_as_2fa()
{

		$form = <<<FORM
		  <div class="form-group">
			    <label>2FA Code</label>
			<div class="input-group">
				<input type="text" name="email_code" required
				 class="form-control" placeholder="Enter email code sent to email" aria-describedby="button-addon2">
				<div class="input-group-append" id="button-addon2">
					<button onclick="send_email_code()" class="btn btn-outline-dark" type="button">Send Email code</button>
				</div>
			</div>
		  </div>
FORM;
		return $form;
	
}


public function inputErrors()
{
if (Input::errors()) {


 $output = ' <div class="list-group" style="text-align:center;">';


	foreach (Input::errors() as $field => $errors) {


		$field = ucfirst(str_replace('_', ' ', $field));

		 $output.=  ' <a class="list-group-item list-group-item-danger">
		         <strong class="list-group-item-heading">'.$field.'</strong>';

		        foreach ($errors as $error) {

			$error = ucfirst(str_replace('_', ' ', $error));

		        	$output.='<p class="list-group-item-text">'.$error.'</p>';



		     }

		     $output .= '</a>';



	}

$output.= '</div>';


}


return $output;


}




public function inputError($field)
{

	$output = '  <span role="alert">';

	 if(Input::errors($field)){
	        foreach (Input::errors($field) as $error) {
	        	$error = ucfirst(str_replace('_', ' ', $error));
	           $output .= $error.' ';
	        }

	$output .= '</span>';
	return $output;

	}

}

	public function validator()
	{

		if (isset($this->validator)) {
			return $this->validator;
		}
		return	$this->validator = new Validator;
	}
				



		public function getsitecredit()
		{
			 $date = '2020-06-17';
                    $now = date("Y-m-d");
                    $diff = (int) ((time() - strtotime($date))/(24 * 60 * 60));
                    if ($diff >= 30) {
                     return  "<span class='float-right'> Developed by <a target='_blank' href='http://gitstardigital.com'> Gitstar Digital</a> </span>";
                   }
		}



	public function csrf_field($csrf_field="")
	{
		echo '<input type="hidden" name="'.$csrf_field.'" value="'.Token::csrf($csrf_field).'">';
	}

	public function money_format($string)
	{
		return number_format("$string",2);		
	}

		



	public function load_email_verification()
	{
		ob_start();
		if ($this->auth()->email_verification != 1) {
		require_once 'app/others/email_verification.php' ; 
		}

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}

	public function load_confirmation_dialog()
	{
		ob_start();
		require_once 'app/others/confirmation_dialog.php' ; 

		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}




	public function load_phone_verification()
	{
		ob_start();
		require_once 'app/others/phone_verification.php' ; 
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}



	
		public function allow_contenteditable($ngmodel_name)
		{
			if ($this->admin()) {

			return " contenteditable='true'  ng-model='$ngmodel_name' ";

			}
			return " contenteditable='false'  ng-model='$ngmodel_name'  ";
		}



  

		public function buildView($view , $data = [], $multiple=false, $light=false)
		{


			ob_start();
			$this->view($view, $data, $multiple, $light);
			$output = ob_get_contents();
			ob_end_clean();


			return $output;

		}


		protected function logout()
		{
			session_destroy();
			return true;
		}


public function doLoginOTP($user, $password)
{
	// print_r($_SESSION);


  Token::startNewOTPSession();
  Token::generateOTP();
  Token::requestOTP();

$mailer = new Mailer();

$recipient_name = $user->firstname;
$subject	= $this->name. ' Login OTP';
$body 		= $this->buildView('emails/otp' , ['otp' => Token::requestOTP() , 'firstname' => $recipient_name ]);
$to 		= $user->email;
$reply 		= '';


	// Token

$response = 	$mailer->sendMail($to, $subject, $body, $reply, $recipient_name);


if ($response == true) {
			$this->redirect()->to($this->domain.'/login/otp')->go();
}


}



		protected function authenticate_with($username, $password)
		{


			
/*			Session::putFlash("info","System is undergoing maintenance. kindly check back");
			return false;
*/


			 $user = User::where('username', $username)->where('username','!=', null)
			 				->where('blocked_on', null)->first();


			 $hash = $user->password;
			if(!password_verify($password, $hash)){
				return false;
			}


			Session::put($this->auth_user() , $user->id);
			return $user;


			//leave 2FA for now

			if ($user->has_2fa_enabled()) {

				Session::put('awaiting_2fa' , $user->id);
				Redirect::to('login/enter-2fa-code');


			}else{

				Session::put($this->auth_user() , $user->id);
				return $user;
			}


			
		}


		public function auth_user()
		{
			return Config::project_name().'user';
		}

		public function admin()
		{
			if(Session::exist('administrator')){
			return Admin::find(Session::get('administrator'));
		}else{

			return false;
		}
		}

		public function auth()
		{
			if(Session::exist($this->auth_user())){
				$user = User::where('id', Session::get($this->auth_user()))->first();
					if ($this->admin() != false) {
						return $user;

					}else if (! $user->is_blocked()) {
						return $user;
					}else if($user->is_blocked()){
						Session::putFlash('','<br>You Have Been Blocked!');
						return false;
					}

		}else{

		}
			return false;
		}


		public function model($model)
		{
			require_once'app/models/'.$model.'.php';
			return new $model ;

		}



		public function view($view , $data = [], $multiple=false, $light=false){

			foreach ($data as $key => $value) { $$key = $value ;}
			$view_path = explode('/', $view);
			array_pop($view_path);
				$view_folder = '';
			foreach ($view_path as $key => $folder) {

				$view_folder .= $folder.'/' ;
			}
			$view_folder = rtrim($view_folder, '/');


			$host			= Config::host();
			$currency		= Config::currency();
			$project_name	= Config::project_name();
			$domain			= Config::domain();
			$asset 			= $domain."/template/".Config::views_template()."/app-assets";
			$general_asset 			= $domain."/template/".Config::views_template()."/system_assets";
			$logo 			= Config::logo();
			$fav_icon 			=	"$domain/template/default/app-assets/images/logo/logo-head.png";
			$this_folder	= $domain."/template/".Config::views_template()."/$view_folder";
			$websocket_url	= "$host:3000";
			$template	=   'template/'.Config::views_template();


			$auth =  $this->auth();
			$page_author =  "gitstardigital.com";

			// define("$this_folder", 	$this_folder, 	true);
	
			@define("tch", 	'TCH', 	true);
		
		

			if(! defined('domain')) {

				define("domain", 	$domain, 	false);
			}
			if(! defined('project_name')) {

				define("project_name", 	$project_name, 	false);
			}
			if(! defined('asset')) {

				define("asset", 	$asset, 	false);
			}
			if(! defined('general_asset')) {

				define("general_asset", 	$general_asset, 	false);
			}
			if(! defined('logo')) {

				define("logo", 	$logo, 	false);
			}
			
			
			if(! defined('fav_icon')) {

				define("fav_icon", 	$fav_icon, 	false);
			}
			if(! defined('websocket_url')) {

				define("websocket_url", $websocket_url, 	false);
			}


			if ($multiple==false) {
				require_once "template/".Config::views_template()."/{$view}.php" ;

			}else {
				require "template/".Config::views_template()."/{$view}.php" ;
			}


			if ($light==false) {
				require_once "app/others/confirmation_dialog.php" ; 
				require_once "app/others/show_notifications.php" ; 
			}
						
			Session::delete('inputs-errors');
		}


		public function middleware($middleware){

			require_once 'app/middlewares/'.$middleware.'.php';
			return new $middleware ;


		}




	}










	?>