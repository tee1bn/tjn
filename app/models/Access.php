<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Access extends Eloquent 
{
    
            protected $fillable = [
									'name',	
									'category',	
									'url',	
									'status',	
									'sidenav',	
									'updated_by'
								];
    
    protected $table = 'accesses';

    
    public static function access_check_on($admin)
    {
    	
    	if (! self::admin_has_access($admin)) {

    		Session::putFlash('danger','Access Denied !');
    		Redirect::back();
    	}

    }

    public function scopeActive($query)
    {
    	return $query->where('status', 1);
    }

    public static function admin_has_access($admin)
    {
		$accesses =  $admin->admin_access->AccessesArray;
		$url = MIS::current_url();

		$request_key = @self::where('url', $url)->Active()->first()->id;

		if ($request_key ==null) { //access not created  at all
			return true;
		}


		if (in_array($request_key, $accesses)) {
			return true;
		}
			echo "not allowed";
			return false;
    }


	public function getactiveStatusAttribute()
	{

         $status = (($this->is_active()) )
          ? "<span type='span' class='badge badge-xs badge-success'>Active</span>":
           "<span type='span' class='badge badge-xs badge-danger'>Not Active</span>";

           return $status;
	}



	public function is_active()
	{
		return $this->status ==1 ;
	}


	public function getViewUrlAttribute()
	{
			$href =  Config::domain()."/admin/edit_access/".$this->id;
			return $href ;
	
	}


	public function by_admin()
	{
		return $this->belongsTo('Admin', 'updated_by');
	}	

	/**
	 * eloquent mutators for password hashing
	 * hashes user password on insert or update
	 *@return 
	 */
	public function setUrlAttribute($value)
	{
	        $this->attributes['url'] = str_replace("-", '_',  strtolower($value));
	}
	    						
	public function setNameAttribute($value)
	{
	        $this->attributes['name'] = strtolower($value);
	}
	
	public function setCategoryAttribute($value)
	{
	        $this->attributes['category'] = strtolower($value);
	}


}


















?>