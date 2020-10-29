<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class ProductsCategory extends Eloquent 
{
	
		protected $fillable = ['category'];
	
	protected $table = 'categories';





	public function products()
	{
		return $this->hasMany('Products' , 'category_id');
	}

}


















?>