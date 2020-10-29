<?php
	namespace classes\Auth;

	use Session;
	use Config;
	use User;
	use Admin;



/**
 * 
 */
class Auth 
{
	
	function __construct()
	{

	}


	public static function user()
	{

			if(Session::exist(self::auth_user())){
				$user = User::where('id', Session::get(self::auth_user()))->first();
					if (self::admin() != false) {
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



	public static function auth_user()
	{
		return Config::project_name().'user';
	}


	public static function admin()
	{
		if(Session::exist('administrator')){

			return Admin::find(Session::get('administrator'));
		}else{

			return false;
		}
	}

}











;?>