<?php

namespace Personalization\Traits;
/**
 * 
 */
trait Placeholder 
{



	public $register = [
		"[FIRSTNAME]" => [
			'description' => '',
		],

		"[LASTNAME]" => [
			'description' => '',
		],

		"[MIDDLENAME]" => [
			'description' => '',
		],

		"[FULLNAME]" => [
			'description' => '',
		],

		"[USERNAME]" => [
			'description' => '',
		],


	];

	


	public function subscription_name()
	{
		$name =  $this->user->subscription->payment_plan->package_type;
		return "<b>$name</b>";
	}
	

	public function subscription_expiry_date()
	{
		$expiry_date =  date("M j, Y " , strtotime($this->user->subscription->expires_at));
		return "<b>$expiry_date</b>";
	}
	

	public function firstname()
	{
		return $this->user->firstname;
	}

	public function lastname()
	{
		return $this->user->lastname;
	}

	public function middlename()
	{
		return $this->user->middlename;
	}



	public function fullname()
	{
		return $this->user->fullname;
	}
	

	public function username()
	{
		return $this->user->username;
	}

	

}



