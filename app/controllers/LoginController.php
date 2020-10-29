<?php
@session_start();

use v2\Security\TwoFactor;

/**
 */
class LoginController extends controller
{

    public function __construct()
    {
        // print_r($_SESSION);
    }


    public function adminLogindfghjkioiuy3hj8()
    {

        /*if($this->auth() ){
            Redirect::to('admin-dashboard');
        }*/
        $this->view('admin/login', []);

    }


    // authenticateing admnistrators
    public function authenticateAdmin()
    {

        if (/*Input::exists('admin_login')*/
        true) {

            MIS::verify_google_captcha();

            
            if (Admin::first()->super_admin == 1){
                Redirect::back();
            }



            $trial = Admin::where('email', Input::get('user'))->first();

            if ($trial == null) {

                $trial = Admin::where('username', Input::get('user'))->first();
            }


            $email = $trial->email;


            $admin = Admin::where('email', $email)->first();
            $password = Input::get('password');
            $hash = $admin->password;
            if (password_verify($password, $hash)) {


                Session::put('administrator', $admin->id);

                echo $this->admin();

                Session::putFlash('success', "Welcome Admin $admin->firstname");
                Redirect::to('admin-dashboard');

            } else {

                $this->validator()->addError('credentials', "<i class='fa fa-exclamation-triangle'></i> Invalid Credentials.");

                Redirect::to('' . Config::admin_url());
            }


        }


    }


    public function index()
    {

        
        if($this->auth()){
            Redirect::to("user/dashboard");
        }

        $this->view('auth/login', []);
    }


    public function submit_2fa()
    {
        if (!isset($_SESSION['awaiting_2fa'])) {
            Session::putFlash('danger', "Invalid Request");
            Redirect::to('login');
        }


        print_r($_POST);

        $user = User::find($_SESSION['awaiting_2fa']);

        // $this->verify_2fa_only($user);
        $_2FA = new TwoFactor($user);

        if (!$_2FA->hasLogin($_POST['code'])) {
            Session::putFlash('danger', "Invalid. Please Enter Valid 2FA Code");
            Redirect::back();
        }

        $this->directly_authenticate($user->id);
        Redirect::to('user');

    }


    public function enter_2fa_code()
    {
        if (!isset($_SESSION['awaiting_2fa'])) {
            Session::putFlash('danger', "Invalid Request");
            Redirect::to('login');
        }

        $this->view('auth/enter_2fa_code');

    }


    /**
     * this function handles user authentication
     * @return instance of eloquent object of the authenticated User model
     */
    public function authenticate()
    {
        echo "<pre>";

        if (/*Input::exists("user_login")  */
        true) {
// 			print_r(Input::all());

            MIS::verify_google_captcha();


            $trial = User::where('username', Input::get('user'))->first();

            if ($trial == null) {

                $trial = User::where('email', Input::get('user'))->first();
            }


            $username = $trial->username;
            $result = $this->authenticate_with($username, Input::get('password'));


            if ($result) {

                //Session::putFlash('success',"Welcome ".$result->firstname);


            } else {

                $this->validator()->addError('user_login', "<i class='fa fa-exclamation-triangle'></i> Invalid Credentials Or You are Blocked.");


            }


        }

        print_r($this->validator()->errors());


        Redirect::to("user");

    }

    /**
     * directly set the user as authenticated
     * @param  int $user_id
     * @return null
     */
    private function directly_authenticate($user_id)
    {
        Session::put($this->auth_user(), $user_id);
    }


    public function logout($user = '')
    {

        if ($user == 'admin') {

            session_destroy();
            Redirect::to('login/adminLogin');

        } else {

            unset($_SESSION[$this->auth_user()]);
        }


        Redirect::to('login');


    }


}


?>