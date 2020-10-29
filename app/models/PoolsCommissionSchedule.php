<?php

use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;

class PoolsCommissionSchedule extends Eloquent 
{
	
	protected $fillable = [
							'period',
							'disagio_dump',
							'paid_at'
					];
	

	protected $table = 'pool_commission_schedule';




	public function give_commission($disagio=null, $license_fee =null)
	{
		$settings= SiteSettings::commission_settings();

		$month_index = date('m', strtotime($this->period));
		$month 	 = date('F Y', strtotime($this->period));


	}




	public function mark_paid()
	{
		$this->update(['paid_at' => date("Y-m-d H:i:s")]);
	}

	public function getPeriodDaterangeAttribute()
	{
		return MIS::date_range($this->period);
	}


}


















?>