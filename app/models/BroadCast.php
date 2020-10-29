<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class BroadCast extends Eloquent 
{
	
	protected $fillable = ['broadcast_message', 'admin_id','status'];
	
	protected $table = 'broadcast';


public function admin()
{
		return $this->belongsTo('Admin', 'admin_id')	;
}

public function scopePublished($query)
{
	return $query->where('status', 1);
}

public static function live()
{
	return BroadCast::where('status', 1)->latest()->get();
}


public  static function latest_broadcast()
{
	return BroadCast::live()->first();
}



public function status()
{
	if ($this->status == 1) {
		return '<a class="btn btn-sm btn-success">Live</a>';
	}else{
		return '<a class="btn btn-sm btn-danger">Not Live</a>';

	}
}


}


















?>