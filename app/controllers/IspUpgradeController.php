<?php
// error_reporting(E_ERROR | E_PARSE);

use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\Wallet;
use v2\Models\Withdrawal;
use v2\Models\UserDocument;


/**



*/
class IspUpgradeController extends controller
{

	public function test()
	{
		Withdrawal::payoutBalanceFor(43);
		
		
	}


	public function all()
	{
		$this->set_users_positions();
		$this->transfer_wallet();
		$this->update_expires_at();
		$this->update_no_of_month();
	}


	public function update_documents()
	{
		 $companies =  Company::where('documents', '!=', NULL)->get();


		 echo "<pre>";
		 // print_r($companies->toArray());

		 $statuses = ['approved'=> 2, 'verifying'=> 1, 'declined'=>3];

		 foreach ($companies as $key => $company) {

		 	$docs = $company->documents;

		 	foreach ($docs as $key => $doc) {

		 	print_r($doc);
			 	UserDocument::create([
			 	    'user_id' => $company->user_id,
			 	    'path' => $doc['files'],
			 	    'label' => $doc['label'],
			 	    'status' => $statuses[$company->approval_status],
			 	]);
		 	}


		 }

	}


	public function update_no_of_month()
	{
		$subscriptions = SubscriptionOrder::Paid()->get();

		foreach ($subscriptions as $key => $subscription) {
			$expires_at = date("Y-m-d", strtotime($subscription->expires_at));
			$paid_at = date("Y-m-d", strtotime($subscription->paid_at));
			$date1 = new DateTime($expires_at);
			$date2 = new DateTime($paid_at);

			$diff = $date1->diff($date2);
			$no_of_month = (($diff->format('%y') * 12) + $diff->format('%m')) ;

			$subscription->update(['no_of_month' => $no_of_month]);

		}	

	}

	public function update_expires_at()
	{
		$subscriptions = SubscriptionOrder::Paid()->get();
		foreach ($subscriptions as $key => $subscription) {

			$subscription->update(['expires_at' => $subscription->ExpiryDate]);
		}
	}


	public function transfer_wallet()
	{

		$earnings =  LevelIncomeReport::all();	
		echo "<pre>";

		// print_r($earnings->toArray());

		foreach ($earnings as $key => $earning) {

				$type = strtolower($earning->status);
				$user_id = ($earning->owner_user_id);
				$upon_user_id = ($earning->downline_id);
				$amount = ($earning->amount_earned);
				$status = 'completed';


				if (strpos(strtolower($earning->commission_type), 'package') !== false) {
					$earning_category = 'package';

				}elseif (strpos(strtolower($earning->commission_type), 'disagio') !== false) {
					$earning_category = 'disagio';

				}elseif (strpos(strtolower($earning->commission_type), 'license') !== false) {
					$earning_category = 'license';
				}else{
					$earning_category=="bonus";
				}

				$comment = $earning->commission_type;
				$paid_at = $earning->created_at;
				$order_id = $earning->order_id;




			Wallet::createTransaction(	
				$type,
				$user_id,
				$upon_user_id,
				$amount,
				$status,
				$earning_category,
				$comment ,
				 null, 
				$order_id , 
				 null,
				null,
				$paid_at
			);

		}

	}


	public function set_users_positions()
	{

		$users = User::all();

		foreach ($users as $user ) {
			$user->setTreesPosition();
		}
		
	}

}
















?>