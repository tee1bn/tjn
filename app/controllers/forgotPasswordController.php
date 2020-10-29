<?php


/*
* * this class is the default controller of our application,
 * 
*/

class forgotPasswordController extends controller
{


    public function __construct()
    {

    }


    public function reset_password()

    {
        if (/*Input::exists('change_password')*/
        true) {

            $this->validator()->check(Input::all(), array(

                'new_password' => [
                    'required' => true,
                    'max' => '32',
                    'min' => '6',
                ],
                'confirm_new_password' => [
                    'required' => true,
                    'max' => '32',
                    'min' => '6',
                    'matches' => 'new_password',
                ],


            ));


            if ($this->validator->passed()) {

                $email = $_SESSION['change_password_email'];

                $user = User::where('email', $email)->first();

                /*echo*/
                $user->update(['password' => Input::get('new_password')]);

                //delete token
                try {

                    PasswordReset::where('email', $email)->first()->delete();
                } catch (Exception $e) {

                }

                Session::putFlash('success', 'Pasword changed successfully!');

                Redirect::to('login');

            } else {

                // print_r($this->validator->errors());

            }


        }

        Session::putFlash('danger', 'Pls Try again!');

        $this->change_password($email);


    }


    private function change_password($email)
    {
        $this->view('auth/change-password', ['email' => $email]);

    }

    public function confirm_reset($email, $token)
    {

        $password_reset = PasswordReset::where('email', $email)->where('token', $token)->first();

        if ($password_reset) {
            $_SESSION['change_password_email'] = $email;
            $this->change_password($email);

        } else {

            // Session::putFlash('' , 'Pls Try again');
            Redirect::to('forgot-password');
        }

    }

    public function send_link()
    {

        MIS::verify_google_captcha();
        print_r($_POST);
        $email = Input::get('user');
        $user = User::where('email', $email)->first();
        $token = uniqid();

        if ($user) {
            PasswordReset::updateOrCreate(['email' => $email],
                ['email' => $email,
                    'token' => $token]);

            $mailer = new Mailer();

            $link = Config::domain() . "/forgot-password/confirm_reset/$email/$token";


            $to = $email;
            $subject = "RESET PASSWORD";

            $body = $this->buildView('emails/password-reset', compact('link', 'email', 'token','user'));

            if ($mailer->sendMail($to, $subject, $body)) {
                Session::putFlash('success', 'Reset link has been sent to your email. ');
            }else{
                echo "not sent";
            }
            
        } else {

            echo "not exist";

        }


        Redirect::to('forgot-password');
    }


    public function index()
    {
        $this->view('auth/forgot-password');

    }


}


?>