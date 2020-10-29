<?php

use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;


use  Filters\Traits\Filterable;


class CampaignCategory extends Eloquent 
{
	use Filterable;
	protected $fillable = [
							'title',
							'sql_query',
							'binds',
							'description',
							'status',
							'admin_id',
						];
	
	protected $table = 'campaign_categories';

	

	public function scopeActive($query)
	{
		return $query->where('status', 1);
	}



	public function getAdminViewUrlAttribute()
	{	
		$href =  Config::domain()."/admin/view_category/".$this->id;
		return $href ;
	}


	public function getBindsArrayAttribute()
	{	
		if ($this->binds=='') {
			return [];
		}
		return json_decode($this->binds, true);
	}


	public function rows()
	{
		return count( DB::select($this->sql_query, $this->BindsArray));
	}


	public function admin()
	{
		return $this->belongsTo('Admin', 'admin_id');
	}





}


















?>