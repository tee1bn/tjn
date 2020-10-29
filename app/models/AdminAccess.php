<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class AdminAccess extends Eloquent 
{
    
            protected $fillable = [
									'admin_id',
									'accesses',
									'created_at',
									'updated_at',
									'updated_by'
								];
    
    protected $table = 'admin_accesses';



    public function getAccessesArrayAttribute()
    {	
    	if ($this->accesses == null) {
    		return [];
    	}
    	return json_decode($this->accesses, true);
    }


	public function for_admin()
	{
		return $this->belongsTo('Admin', 'admin_id');
	}	


	public function by_admin()
	{
		return $this->belongsTo('Admin', 'updated_by');
	}	

}


















?>