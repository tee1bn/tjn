<?php


/**



*/
class ReferralController extends controller
{



	public function __construct(){
	}



	public function index($referral_username=null){


		if ($referral_username != null) {

			$referral = User::where('username', $referral_username)->first();

			if ($referral != null) {
				setcookie('referral', $referral_username, time() + (86400 * 30 ), "/"); // 86400 = 1 day
			}else{
				setcookie('referral', $referral_username, time() - (86400 * 30 * 365)); // 86400 = 1 day
			}

		}

		// print_r($_COOKIE);

	Redirect::to('register');


	}









}























?>