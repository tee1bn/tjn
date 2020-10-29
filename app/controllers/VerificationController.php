<?php


/**
 * this class is the default controller of our application,
 *
 */
class VerificationController extends controller
{


    public function __construct()
    {

        if (!$this->admin()) {

            $this->middleware('current_user')
                ->mustbe_loggedin();
        }


        $this->setting = SiteSettings::site_settings();


    }


    public function send_welcome_email()
    {

        ob_start();

        $user = User::where('email', $email)->first();
        $name = $this->auth()->fullname;

        $subject = 'WELCOME EMAIL';
        $body = $this->buildView('emails/welcome', compact('name'));

        $to = $this->auth()->email;


        $mailer = new Mailer;
        $status = $mailer->sendMail($to, $subject, $body, $reply = '', $recipient_name = '');

        ob_end_clean();


        if ($status) {
            // Session::putFlash('success', "Mail Sent!");
        } else {
            // Session::putFlash('danger', "Verification Mail Could not Send.");
        }

        Redirect::to('user');

    }


    public function verify_email_code()
    {

        $auth = $this->auth();

        if (($this->setting['email_verification'] == 1) &&
            (intval($this->auth()->email_verification) == 1)) {


            $this->send_welcome_email();
            Redirect::to('user');


        }


        if (($_POST['email_code'] == $auth->email_verification)) {

            $this->auth()->update(['email_verification' => 1]);
            Session::putFlash('success', "Email Verified Successfully.");

            $this->send_welcome_email();

            Redirect::to('user');


        } else {

            Session::putFlash('danger', "Email Could not Verify Successfully.");
            Redirect::back();
        }

    }


    public function write_letter_of_happiness()
    {

        $this->view('auth/write-testimony');

    }


    public function phone()
    {

        $this->view('auth/verify_phone');

    }


    public function company()
    {


        $company = $this->auth()->company;
        Session::putFlash('info', "You must fill your company profile and submit for verification");
        $this->view('auth/company', compact('company'));
    }


    public function email()
    {

        if($this->auth()->has_verified_email()){

            Redirect::to('user');
        }


        $this->view('auth/verify_email');

    }


}


?>