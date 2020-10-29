<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class CMS extends Eloquent 
{
	
	protected $fillable = ['criteria',	'settings', 'description'];
	
	protected $table = 'cms';





	public static function fetch($criteria)
	{
		$item =  self::where('criteria', $criteria)->first();
		return ($item->settings ?? '');
	}

}
?>
