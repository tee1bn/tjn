<?php
@session_start();
/**
* 
*/
class Session 
{
	

	function show_flash()
	{
	            
	    if (! isset($_SESSION['flash'])) {
	        return;
	    }


	    $message = '';
	    foreach($_SESSION['flash'] as $flash){

	        $message .= $flash['message'];
	    }

	    $type = end($_SESSION['flash'])['title'];


	    $notification = "
	                    <div id='gitstar-notice' style='display:block;' class='alert alert-$type alert-dismissible' >
	                    <a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>×</a>
	                        <span>$message</span>    
	                    </div>";

	    unset($_SESSION['flash']);
	    return $notification;
	}


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