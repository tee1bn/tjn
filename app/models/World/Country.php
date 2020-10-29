<?php

namespace World;

use Illuminate\Database\Eloquent\Model as Eloquent;

	
	
class Country extends Eloquent 
{

	protected $fillable = [ 'sortname','name'];
	
	protected $table = 'countries';



	public function states()
	{
		return $this->hasMany('World\State', 'country_id');
	}
}


















?>