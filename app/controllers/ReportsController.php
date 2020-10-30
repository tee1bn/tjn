<?php


/**
 */
class ReferralController extends controller
{


    public function __construct()
    {
    }


    public function index($referral_username = null)
    {


        $referral_username = explode("/", $_GET['url'])[1] ?? null;
        $referral_username = str_replace("_", " ", $referral_username);

        $cookie_name = Config::cookie_name();

        if ($referral_username != null) {

            $referral = User::where('username', $referral_username)->first();

            // return;
            if ($referral != null) {
                setcookie($cookie_name, $referral_username, time() + (86400 * 30), "/"); // 86400 = 1 day
            } else {
                setcookie($cookie_name, $referral_username, time() - (86400 * 30 * 365)); // 86400 = 1 day
            }

        }

        // print_r($_COOKIE);

        Redirect::to('register');


    }


}


?>