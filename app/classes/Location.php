<?php

/**
* 
*/
class Location
{


	public function __construct()
	{
		
	}




	public  static function location($field='')
	{



// $gen_userIP = getenv('REMOTE_ADDR');

$gen_userIP = '154.118.63.89';



/* =================GRAB VISITOR'S LOCATION==================*/
	//Retieving visitor's location from IP Address
	$geopluginURL='http://www.geoplugin.net/php.gp?ip='.$gen_userIP;
	$gen_visitoInfo = unserialize(file_get_contents($geopluginURL)); 
	
	$gen_city = $gen_visitoInfo['geoplugin_city'];
	$gen_state = $gen_visitoInfo['geoplugin_region'];
	$gen_country = $gen_visitoInfo['geoplugin_countryName'];
	$gen_countryCode = $gen_visitoInfo['geoplugin_countryCode'];
	$gen_currencyValue = $gen_visitoInfo['geoplugin_currencyConverter'];


return $gen_visitoInfo;
	}


	

}