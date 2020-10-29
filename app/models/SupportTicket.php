<?php


use Illuminate\Database\Eloquent\Model as Eloquent;
use  Filters\Traits\Filterable;

class SupportTicket extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [ 
							'subject_of_ticket',
							'code',
							'user_id',
							'customer_name',
							'customer_phone',
							'customer_email',
							'admin_id',
							'status',
							'closed_at',
							'closed_by'];
	
	protected $table = 'cs_support_tickets';
	public static $statuses = [
								0=> 'open',
								1=> 'closed',
							];




	

	public function getUserLinkAttribute()
	{
		$link= Config::domain()."/user/supportmessages?ticket_id={$this->code}";

		return $link;
	}
	
	public function getlinkAttribute()
	{
		if ($this->user != null) {
			$link = $this->UserLink;
		}else{

			$link= Config::domain()."/supportmessages?ticket_id={$this->code}";
		}


		return $link;
	}


	public function getcloseLinkAttribute()
	{
		$link= Config::domain()."/home/close_ticket?ticket_code={$this->code}";
		return $link;
	}


	public function getadminLinkAttribute()
	{

		$link= Config::domain()."/admin/support_messages?ticket_id={$this->code}";
		return $link;
	}


	public function getdisplayClientAttribute()
	{

       $client = "{$this->customer_name}<br>
	        <small class= ' '>Email: <a href= 'mailto://{$this->customer_email}'>{$this->customer_email}</a></small><br>
	        <small class= ' '>Phone: <a href= 'tel://$this->customer_phone;'>{$this->customer_phone}</a></small><br>
	       ";

	       // $this->closeButton
	    return $client;
	}

	public function getdisplayStatusAttribute()
	{
		switch ($this->status) {
			case 0:
			$status= "<span class='badge badge-warning'>Open</span>";
				break;
			
			case 1:
			$status= "<span class='badge badge-primary'>Closed</span>";
				break;
			
			default:
				# code...
				break;
		}

		return $status;

	}


	public function getcloseButtonAttribute()
	{
		$host = Config::domain();
		$confirm_dialog = '$confirm_dialog';
		$button = "<a  onclick='$confirm_dialog = new ConfirmationDialog(\"$this->closeLink\")'  
		href='javascript:void(0);' class='dropdown-item'>Close ticket</a>";


		if (!$this->is_closed()) {
			return $button;
		}

			return "";
	}

	public function is_closed()
	{
		return $this->status == 1;
	}

	public function mark_as_closed()
	{
		$this->update(['status'=> 1,'closed_at'=> date("Y-m-d H:i:s")]);
	}

	public function messages()
	{
			return $this->hasMany('SupportMessage', 'ticket_id')	;
	}

	public function user()
	{
			return $this->belongsTo('User', 'user_id')	;
	}


	public function closed_by()
	{
			return $this->belongsTo('Admin', 'closed_by')	;
	}



}


















?>