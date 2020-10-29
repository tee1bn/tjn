<?php
@session_start();

// use Illuminate\Database\Eloquent\Model as Eloquent;

class administrator extends controller
{
	

	public function __construct(){

	}
	
	


public function mustbe_loggedin(){

if($this->admin()){

	return true;
		
		}else{

		Redirect::to(Config::admin_url());
		exit();
		}

}



public function mustbe_super_admin(){

if($this->admin()->id === 1){

	return true;
		
		}else{

		Redirect::to(Config::admin_url());
		exit();
		}

}





}


















?>