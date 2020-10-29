<?php


namespace World;
use Illuminate\Database\Eloquent\Model as Eloquent;

	
	
class City extends Eloquent 
{

	protected $fillable = [ 'state_id','name'];
	
	protected $table = 'cities';
}


















?>