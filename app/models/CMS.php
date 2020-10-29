<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class CMS extends Eloquent 
{
	
	protected $fillable = ['criteria',	'settings', 'description', 'availability'];
	
	protected $table = 'cms';



	public function scopeAvailable($query)
	{
		return $query->where('availability', 1);
	}



	public static function fetch($criteria)
	{

		$item =  self::where('criteria', $criteria)->first();
		return ($item->settings ?? null);
	}

}
?>
