<?php
@session_start();
/**
* 
*/
class Session 
{
	



	public static function flash()
	{
		if(isset($_SESSION['flash'])){
			$flash = $_SESSION['flash'];

			unset($_SESSION['flash']);
			return $flash ;

		}
	}

		public static function putFlash($title, $message)
		{
			$_SESSION['flash'][]= [	'title' => $title,
									'message'=>$message
												] ;

			}

public static function hasFlash()
		{
			if(isset($_SESSION['flash'])){

				return true;
			}else{

				return false;
			}

			}



	

	public static function exist($name)
	{
		return (isset($_SESSION["$name"]))	? true : false;
	}

	public static function put($name, $value)
	{
		return $_SESSION["$name"] = $value;

	}


	public static function get($name)
	{
		return (isset($_SESSION["$name"])) ? $_SESSION["$name"] :'' ;
	}

	public static function delete($name)
	{
		 unset($_SESSION["$name"]);
	}


	


	
}