<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent 
{
	
	protected $fillable = [ 'category', 'note' ];	
	protected $table = 'post_categories';


	public static	$validation_rules = [
					'category'=> [
						'unique'=> 'Category',
							],
						];

	public function getdeletelinkAttribute()
	{
		return  Config::domain()."/blog/delete_category/{$this->id}";

	}


	public function delete_category(array $ids)
	{
		foreach ($ids as $key => $id) {
			$category = Category::find($id);
				if ($category != null) {
					 $category->delete();
					 return true;
				}
			}
	}

	public function posts(){

		return $this->hasMany('Post');
	}

	public function url_link()
	{
		return "blog/category/{$this->id}/{$this->url_title()}";

	}


	public function geturllinkAttribute()
	{
		return "blog/category/{$this->id}/{$this->url_title()}";

	}

	public function url_title()
	{
			return ucfirst(str_replace(' ', '-', $this->category));
	}

}


















?>