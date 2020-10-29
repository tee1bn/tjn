<?php
// error_reporting(E_ERROR | E_PARSE);

use Illuminate\Database\Capsule\Manager as DB;

/**



*/
class SubscriptionReminder extends controller
{



	public function send_reminder_on_manual_subcription()
	{

		$total = SubscriptionOrder::Paid()->where('payment_state', '!=', 'automatic')->count();

        $skip_model = SiteSettings::find_criteria('reminder_tracker_skip');


		$page = (isset($skip_model->settings) && is_numeric($skip_model->settings)) ? $skip_model->settings : 1;
		$per_page = 1;
		$skip = (($page - 1) * $per_page);
		$total_pages = ceil($total / $per_page);

		if ($page >= $total_pages) {
		    $skip_model->update(['settings' => 0]);
		}	

		$days_to_expire = 5;

		$notify_date = date("Y-m-d", strtotime("+$days_to_expire days "));

		$subscriptions = SubscriptionOrder::Paid()->where('payment_state', '!=', 'automatic')
							->whereDate('expires_at' , '<=' , $notify_date)
							->take($per_page)
							->skip($skip)
							->get();

		foreach ($subscriptions as $key => $subscription) {

			$subscription->send_expiry_reminder_email();
		}

		
		$skip_model->increment('settings');


	}

}
















?>