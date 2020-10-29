<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Notifications extends Eloquent 
{
	
	protected $fillable = [

				'user_id',
				'url',
				'heading',
				'message',
				'short_message',
				'admin_id',
				'type',
				'seen_at'	
			];
	
	protected $table = 'notifications';




	public static function create_notification($user_id, $url, $heading, $message, $short_message,$admin_id=null )
	{

			self::create([
						'user_id'	=> $user_id,
						'url'		=> $url,
						'heading'	=> $heading,
						'message'	=> $message,
						'short_message'	=> $short_message,
						'admin_id'	=> $admin_id,
					]);


	}



	public static function mark_as_seen($ids)
	{
		self::whereIn('id', $ids)->update(['seen_at'=> date("Y-m-d H:i:s")]);
	}
	

	public function getUsefulUrlAttribute()
	{	
		$domain = Config::domain();
		return "$domain/{$this->url}/{$this->id}";
	}

	

	public function getDefaultUrlAttribute()
	{	
		$domain = Config::domain();
		return "$domain/user/notifications/{$this->id}";
	}


	public function seen_status()
	{
		if ($this->is_seen()) {

			return "<span class='label  label-success'>Read</span>";
		}


			return "<span class='label  label-danger'>Unread</span>";
	}

	public function is_seen()
	{
		return (bool) ($this->seen_at != null);
	}


	public static function all_notifications($user_id, $per_page=null, $page=1)
	{

			$query = self::where('user_id', $user_id)->orderBy('created_at', 'DESC');;

				if ($per_page!= null) {
				 	$skip = ($page - 1)* $per_page;

							$query->take($per_page)
							->offset($skip);
				}

		return $query->get();

	}


	public static function unseen_notifications($user_id, $take=null)
	{
		$query = self::where('user_id', $user_id)->where('seen_at', null)->orderBy('created_at', 'DESC');

			if ($take != null) {
				$query->take($take);
			}


		return $query->get();
	}



	public function admin()
	{
		return $this->belongsTo('Admin', 'admin_id');
	}



	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}




}


















?>