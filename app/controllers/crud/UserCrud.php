<?php
use v2\Models\UserBank;
require_once "../app/controllers/home.php";


/**
 * 
*/


class UserCrud extends controller
{

	public function __construct(){

	}




	public function suspending_user($user_id){


		if (User::find($user_id)->blocked_on) {

		$update = User::find($user_id)->update(['blocked_on' => null ]);
		Session::putFlash('success', 'Ban lifted succesfully');


		}else{

		$update = User::find($user_id)->update(['blocked_on' => date("Y-m-d")]);

		Session::putFlash('success', 'User Blocked succesfully');

		}


		if ($update) {	
		}else{
		Session::putFlash('flash', 'Could not Block this User');
		}


		Redirect::back();
	}



}























?>