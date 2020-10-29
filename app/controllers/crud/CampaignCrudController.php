<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Str;
use  v2\Models\Campaign;



/**
 * 
 */
class CampaignCrudController extends controller
{
	
	function __construct()
	{
		$this->middleware('administrator')->mustbe_loggedin();

	}



	public function update_campaign($action=null)
	{

		echo "<Pre>";

		print_r($_POST);

		$campaign = Campaign::find($_POST['id']);
		if ($campaign==null) {
			Session::putFlash('danger',"Invalid Request");
			Redirect::back();
		}

		$campaign_category = CampaignCategory::find($_POST['category_id']);

		// echo $campaign;

		if ($campaign->is_published()) {
			Session::putFlash('danger',"This campaign as been published");
			// Redirect::back();
		}

			$campaign->update([
				'subject'	=> $_POST['subject'],	
				'message'	=> $_POST['message'],	
				'category_id'	=> $_POST['category_id'],	
				'sql_query'	=> $campaign_category->sql_query,	
				'type'	=> $_POST['type'],	
				'recipients'	=> $_POST['recipients'],	
				'test_recipients'	=> $_POST['test_recipients'],	
			]);

		switch ($action) {
			case 'publish':
				$campaign->publish();

				break;
			case 'send_test':
				$campaign->send_test();
				break;
			
			default:

			Session::putFlash('success',"Campaign saved as draft");

			break;
		}


	}	




	public function send_email_campaign()
	{

		
		

	}


}