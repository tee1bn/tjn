<?php

use World\Country;
use World\City;
use World\State;



/**
 * 
*/
class WorldAPi extends controller
{


	public function __construct()
	{
		header("content-type:application/json");
	}



	public function countries()
	{

		// $country = ['cambodia']
		$countries =  Country::where('id',160)->get();
		$auth =  $this->auth();

		echo json_encode(compact('countries','auth'));
	}


	public function states()
	{
		$country_id = $_REQUEST['country_id'];

		$country = Country::find($country_id);
		$states =  $country->states;

		echo json_encode(compact('states'));
	}


	public function cities()
	{
		$state_id = $_REQUEST['state_id'];

		$state = State::find($state_id);
		$cities =  $state->cities;

		echo json_encode(compact('cities'));
	}



	public function index()
	{

		echo "foldr gome";

	}



}























?>