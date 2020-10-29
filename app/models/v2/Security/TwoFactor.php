<?php
declare(strict_types=1);

namespace v2\Security;

require 'template/vendor/GoogleAuthenticator-master/_init_.php';
/**
 * 
 */
class TwoFactor 
{
	private $ga;
	
	function __construct($user)
	{

		    $AppName = \Config::project_name();
		    $UserName = $user->email;

		    $this->ga = new \GoogleAuth($AppName,$UserName);
		   /* if(!$this->ga->hasLogin($code)){
		       echo "NOT LOGIN !<br>Please Scan This QrCode Again ! <br>";
		       $this->ga->showQr();
		    }else{
		       echo "LOGIN SUCCESSFULY!";
		    }


		    echo "string";*/

	}


	public function hasLogin($code)
	{
		return  ($this->ga->hasLogin($code));
	}

	public function getQrCode()
	{
		return $this->ga->showQr();
	}

}