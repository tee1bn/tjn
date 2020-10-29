<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class AvailableCurrency extends Eloquent 
{
	
	protected $fillable = [ 'currency_name', 'currency_code', 'html_code', 'availability_status'];
	
	protected $table = 'systems_currencies';


public function available()
{
	return self::where('availability_status', 1);
}


}


















?>