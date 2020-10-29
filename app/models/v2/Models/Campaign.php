<?php


namespace v2\Models;

use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Session, Mailer,  MIS, SiteSettings, Config, SMS, User, Personalization;


use  Filters\Traits\Filterable;


class Campaign extends Eloquent 
{
	use Filterable;
	protected $fillable = [

		'admin_id',	
		'subject',	
		'sender',	
		'message',	
		'category_id',	
		'sql_query',	
		'recipients',	
		'test_recipients',	
		'published_at',	
		'progress_status',	//completed means completed
		'type',	
		'no_of_recipient',	
		'current_offset'

	];
	
	protected $table = 'campaign';

	public static $types = ['email','sms'];
	public static $published_statuses = ['publish', 'draft'];


	public function content()
	{
		$content = MIS::compile_email($this->message);
		return $content;
	}

	public function send_test()
	{


		$settings = SiteSettings::site_settings();
		$noreply_email = $settings['noreply_email'];
		$support_email = $settings['support_email'];
		$notification_email = $settings['notification_email'];


		switch ($this->type) {
			case 'email':

			$mailer = new Mailer;

			$content = $this->content();
			$subject = $this->subject;


			$domain = Config::domain();
			$project_name = Config::project_name();

			$emails = explode(",", $this->test_recipients);
    		$users = User::whereIn('email', $emails)->get()->keyBy('email');

			foreach ($emails as $key => $test_email) {
    					$auth = $users[$test_email];
    				 $personalization = new Personalization;
					 $content = $personalization->setUser($auth)
					                     ->setContent($content)
					                     ->personalise()
					                     ->getOutput();

					 $subject = $personalization->setUser($auth)
					                     ->setContent($subject)
					                     ->personalise()
					                     ->getOutput();



					//client
					$mailer->sendMail(
					    "{$test_email}",
						"$subject",
					    $content,
					    $auth->firstname,
					    "{$support_email}",
					    "$project_name"
					);
			}



				break;
			
			case 'sms':
				$phones = explode(",", $this->test_recipients);

				foreach ($phones as $key => $phone) {
						$sms = new SMS;
	    				// $sms->addAddress($phone);
				}



				break;
			
			default:
				# code...
				break;
		}

	}
	

	public function scopePublished($query)
	{
		return $query->where('published_at', '!=',null);
	}

	public function scopeOnGoing($query)
	{
		return $query->where('progress_status', '=', 'ongoing');
	}


	public function publish()
	{	
		if ($this->is_published()) {
			Session::putFlash("info", "Campaign already publised");
			return;
		}
		$now =date("Y-m-d H:i:s");
		$this->update(['published_at' => $now]);
		Session::putFlash('success',"Campaign published successfully.");
		return $this;
	}
	
	public function is_published()
	{
		return $this->published_at != null;
	}


	public function getDisplayStatusAttribute()
	{		

		if ($this->is_published()) {
				$status = '<span class="badge badge-sm badge-success"> published</span>';

			}else{

				$status = '<span class="badge badge-sm badge-dark"> Draft</span>';

			}			

		return $status;
	}

	public function getDisplayProgressStatusAttribute()
	{		
		switch ($this->progress_status) {
			case 'ongoing':

				$status = '<span class="badge badge-sm badge-info"> Ongoing</span>';
				break;
			
			case 'completed':

				$status = '<span class="badge badge-sm badge-success"> Completed</span>';
				break;
			
			default:
				$status = '<span class="badge badge-sm badge-dark"> Unknown</span>';
				break;
		}

	
		return $status;

	}


	public function getAdminViewUrlAttribute()
	{	
		$href =  \Config::domain()."/admin/view_category/".$this->id;
		return $href ;
	}

	public function geteditLinkAttribute()
	{	
		$href =  \Config::domain()."/admin/edit_campaign/".$this->id;
		return $href ;
	}




	public function rows()
	{
		if ($this->sql_query=='') {
			$emails = explode(",", $this->test_recipients);
			$count =  count($emails);
			return $count;
		}
		return count( DB::select($this->sql_query));
	}



	public function category()
	{
		return $this->belongsTo('CampaignCategory', 'category_id');
	}


	public function admin()
	{
		return $this->belongsTo('Admin', 'admin_id');
	}





}


















?>