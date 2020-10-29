<?php
namespace v2\Models;

use  Filters\Traits\Filterable;

use Illuminate\Database\Capsule\Manager as DB;

use SiteSettings;

use Illuminate\Database\Eloquent\Model as Eloquent;

class WcOrder extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [
							'user_id',
							'username',
							'comment',
							'is_paid',
							'copied',
							'order_id'
						];
								
	protected $table = 'wc_orders';


	public function scopePaid($query)
	{
		return $query->where('is_paid', 1);
	}


	public function scopeUnPaid($query)
	{
		return $query->where('is_paid', 0);
	}

	public function scopeIsCopied($query)
	{
		return $query->where('copied', 1);
	}


	public function scopeNotCopied($query)
	{
		return $query->where('copied', 0);
	}


	public function give_referral_commissions()
	{

	}


	public function getPaymentStatusAttribute()
	{

		switch ($this->is_paid) {
			case 1:
			return "<span class='badge badge-sm badge-success'>Paid</span>";
			break;

			default:
			return "<span class='badge badge-sm badge-warning'>Pending</span>";
			break;            
		}

	}

	public function getCopiedStatusAttribute()
	{

		switch ($this->commission_settled) {
			case 1:
			return "<span class='badge badge-sm badge-success'>Copied</span>";
			break;

			default:
			return "<span class='badge badge-sm badge-warning'>Pending</span>";
			break;            
		}

	}

	public function mark_as_copied()
	{
		return $this->update(['copied' => 1,'is_paid' => 1]);

	}


	public function user()
	{
		return $this->belongsTo('User', 'user_id');

	}
	





}
?>
