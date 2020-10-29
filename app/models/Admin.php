<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Admin extends Eloquent 
{
	
	protected $fillable = [ 'username','firstname','lastname', 'phone','email', 'password', 'super_admin'];
	
	protected $table = 'administrators';

    protected $hidden = ['password'];




    public function getAdminViewUrlAttribute()
    {

    	return  Config::domain()."/admin/profile/".$this->id;
    }




	public function is_owner()
	{

		return ($this->id == 1);
	}

	public function administrators()
	{
		return Admin::where('id','!=',1)->get();
	}


	
	public function getprofilepicAttribute()
    {
    	$value = $this->profile_pix;
	if (! file_exists($value) &&  (!is_dir($value))) {
	        return (Config::default_profile_pix());
    	}

	   	return $value;

    }




	public function getfullnameAttribute()
	{

		return "{$this->lastname} {$this->firstname}";
	}



/**
	 * eloquent mutators for password hashing
	 * hashes user password on insert or update
	 *@return 
	 */
	 public function setPasswordAttribute($value)
	    {
	        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
	    }




}


















?>