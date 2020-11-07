<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

use Filters\Filters\UserFilter;
use Illuminate\Database\Capsule\Manager as DB;

use  Filters\Traits\Filterable;


class Customer extends Eloquent 
{
    use Filterable;
    
    protected $fillable = [ 
        'firstname',
        'lastname',
        'email',
        'phone'
    ];
    
    protected $table = 'customers';



	/**
	 * [getFirstNameAttribute eloquent accessor for firstname column]
	 * @param  [type] $value [description]
	 * @return [string]        [description]
	 */
	public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    /**
    	 * [getFirstNameAttribute eloquent accessor for firstname column]
    	 * @param  [type] $value [description]
    	 * @return [string]        [description]
    	 */
    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }

    
    public function getDropSelfLinkAttribute()
    {

        return  "<a target='_blank'>{$this->full_name} <br>{$this->phone} <br>{$this->email} </a>";
    }



    public function getfullnameAttribute()
    {
        return "{$this->lastname} {$this->firstname}";
    }


}

















?>