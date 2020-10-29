<?php


namespace World;
use Illuminate\Database\Eloquent\Model as Eloquent;

	
	
class State extends Eloquent 
{

	protected $fillable = [ 'country_id','name'];
	
	protected $table = 'states';



	public function cities()
	{
		return $this->hasMany('World\City', 'state_id');
	}
}


















?>