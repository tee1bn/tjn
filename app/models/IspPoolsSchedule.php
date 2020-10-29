<?php

use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;

class IspPoolsSchedule extends Eloquent 
{
	
	protected $fillable = [
							'period',
							'dump',
							'paid_at'
					];
	

	protected $table = 'isp_pools_schedule';






	public function mark_paid()
	{
		$this->update(['paid_at' => date("Y-m-d H:i:s")]);
	}

	public function getPeriodDaterangeAttribute()
	{
		return MIS::date_range($this->period);
	}



	public function getDumpArrayAttribute()
	{
	    if ($this->dump == null) {
	        return [];
	    }

	    return json_decode($this->dump, true);
	}



}


















?>