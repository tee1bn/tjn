<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

use  Filters\Traits\Filterable;
use v2\Models\Sales;


class Testimonials extends Eloquent 
{
	use Filterable;
	
	protected $fillable = ['attester','attester_pic', 'user_id', 'bio',	'content',	'type',	'video_link', 'approval_status', 'published_status'];
	
	protected $table = 'testimonials';



public function scopeApproved($query)
{
	return $query->where('approval_status', 1);
}


public function is_approved()
{
	return $this->approval_status==1 ;
}


public function user()
{
	return $this->belongsTo('User', 'user_id');
}

public function getprofilepicAttribute()
{
	if ($this->user == null) {
		$pix = Config::default_profile_pix();

	}else{

		$pix = $this->user->profilepic;
	}

	return $pix;
}



public function give_commisssion()
{
	print_r($_POST);
	if ($this->user_id == null) {return;}

	//confirm that you get this only once
	$existing = Sales::where('user_id', $this->user_id)->where('order_id', $this->id)->first();

	if ($existing) {return;}



		$points =	Sales::create([
						'user_id' => $this->user_id,
						'username' => $this->user->username,
						'amount' => 0,
						'type' => 'testimonial',
						'points' => 100,
						'commission_settled' => 1,
						'comment' => "Points Earned for Uploading Video testimonial",
						'is_paid' => 1,
						'order_id' => $this->id
					]);		


		return;
}

public function getDisplayStatusAttribute()
{
	if ($this->approval_status) {
		$status = "<span class='badge badge-success'>Approved</span>";
	}else{

		$status = "<span class='badge badge-danger'>Not Approved</span>";
	}

	return $status;
}


public function getDisplayPublishedStatusAttribute()
{
	if ($this->published_status) {
		$status = "<span class='badge badge-success'>Published</span>";
	}else{

		$status = "<span class='badge badge-danger'>Not Published</span>";
	}

	return $status;
}


public function upload_pic($file)
{

	$directory 	= 'uploads/testimonials';
	$handle  	= new Upload($file);

	if (explode('/', $handle->file_src_mime)[0] == 'image') {

		$handle->Process($directory);
 		$original_file  = $directory.'/'.$handle->file_dst_name;

		(new Upload($this->attester_pic))->clean();
		$this->update(['attester_pic' => $original_file]);
	}

}





}


















?>