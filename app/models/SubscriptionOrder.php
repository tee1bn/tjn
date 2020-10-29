<?php


include_once 'app/controllers/home.php';

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;
use v2\Shop\Contracts\OrderInterface;
use  v2\Shop\Shop;



use  Filters\Traits\Filterable;


class SubscriptionOrder extends Eloquent implements OrderInterface
{
    use Filterable;
	
	protected $fillable = [
							'plan_id',
							'payment_method',
							'payment_details',

							 'subscription_details',
							 'expires_at',
							 'payment_state',
							 
							 'user_id',
							 'user_id',
							 'payment_proof',
							 'price',
							 'sent_email',
							 'paid_at',
							 'details',
							 'created_at'
							];
	
	protected $table = 'subscription_payment_orders';

	public $name_in_shop = 'packages';
	
	public  static $payment_types = [
			 		'paypal'=> 'subscription',
			 		'coinpay'=> 'one_time',
			 	];



	public function getExpiryDateAttribute()
	{
		if ($this->expires_at != null) {

			return $this->expires_at;
		}

		$date_string = $this->paid_at;

		$date =  date("Y-m-d", strtotime("$date_string + 1 month" )); // 2011-01-03

		return $date;
	}

	public function is_expired()
	{
		if (strtotime($this->ExpiryDate) < time()) {
			return true;
		}

		return false;
	}


	public function fetchAgreement()
	{
		$shop = new Shop();
		$agreement = $shop->setOrder($this)->fetchAgreement();
		return $agreement;
	}

	public function getNotificationTextAttribute()
	{

		$date = $this->ExpiryDate;
		$expiry_date = date("M j, Y", strtotime($date));

		$domain = Config::domain();
		$cancel_link = "$domain/shop/cancel_agreement";

		switch ($this->payment_state) {
			case 'manual':
				$note = "Expires: $expiry_date";
				break;
			case 'automatic':

				$agreement_details = $this->fetchAgreement();
				$next_billing_date = date("M j, Y", strtotime($agreement_details['next_billing_date']));

				$today = strtotime(date("Y-m-d"));
				$next_billing = strtotime(date("Y-m-d", strtotime($agreement_details['next_billing_date'])));


				$note="";

				if ($next_billing > $today) {
					$note .= MIS::generate_form([
								'order_unique_id' => $this->id,
								'item_purchased' => 'packages',
								],$cancel_link,'Cancel Subscription','',true);
				}

				$note .= "<br>Next Billing: $next_billing_date <br>";
				break;
			case 'cancelled':
				$note = "Expires: $expiry_date";
				break; 
			
			default:
				$note = "Expires: $expiry_date";
				break;
		}	

		return $note;
	}

	public function scopePaid($query)
	{
		return $query->where('paid_at','!=',null);
	}


	public  function invoice()
	{

		$controller = new home;
		$order = $this;
		$view  =	$controller->buildView('auth/order_detail', compact('order'));
		
		$mpdf = new \Mpdf\Mpdf([
		    'margin_left' => 5,
		    'margin_right' => 5,
		    'margin_top' => 10,
		    'margin_bottom' => 20,
		    'margin_header' => 10,
		    'margin_footer' => 10
		]);

		$company_name = Config::project_name();

		$mpdf->AddPage('P');
		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("{$company_name}");
		$mpdf->SetAuthor($company_name);
		$mpdf->SetWatermarkText("{$company_name}");
		$mpdf->showWatermarkText = true;
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');

		$date_now = (date('Y-m-d H:i:s'));

		$mpdf->SetFooter("Date Generated: " . $date_now . " - {PAGENO} of {nbpg}");


		$mpdf->WriteHTML($view);
		$mpdf->Output("invoice#$order->id.pdf", \Mpdf\Output\Destination::DOWNLOAD);			
	
	}



	public function getTransactionIDAttribute()
	{

		$payment_details = json_decode($this->payment_details,true);
		$method = "{$payment_details['ref']}<br><span class='badge badge-primary'>{$payment_details['gateway']}</span>";
					
		return $method;
	}




	public function mark_paid()
	{	
	
		if ($this->is_paid()) {
			Session::putFlash('info', 'Order Already Marked as completed');
			return false;
		}

		DB::beginTransaction();
		try {

			$this->update(['paid_at' => date("Y-m-d H:i:s")]);
			$this->give_value();


			$url =  "user/scheme";
			$heading = $this->payment_plan->package_type." Upgrade";
			$short_message = "See Details of Current Package.";
			$message="";
/*			Notifications::create_notification(
											$this->user_id,
											$url, 
											$heading, 
											$message, 
											$short_message
											);

*/			
			DB::commit();
			Session::putFlash('success', 'Order marked as completed');
			return true;
		} catch (Exception $e) {
			DB::rollback();
			print_r($e->getMessage());
			Session::putFlash('danger', 'Order could not mark as completed');
		}

		return false;
	}


	private function give_value()
	{
		$user = $this->user;
		$user->update(['account_plan' => $this->plan_id ]);
		$this->give_subscriber_upline_commission();

		// $this->send_subscription_confirmation_mail();
	}



	public function send_subscription_confirmation_mail()
	{


		ob_start();

	 $user =  $this->user;
	 $name =  $user->firstname;
	 $email = $user->email;

	  require 'app/controllers/home.php';

	  $controller = new home();

	 $subject 	= 'SCHEME CONFIRMATION ';
	 $body 		= $controller->buildView('emails/subscription_confirmation', [
																'name' => $name,
																'email' => $email,
																'subscription' => $this->payment_plan,
																]);


		$to 		= $email;

	
		$mailer = new Mailer;
		$status = $mailer->sendMail($to, $subject, $body, $reply='', $recipient_name='');

	

		ob_end_clean();

		if ($status) {

			Session::putFlash('success', "Confirmation Mail Sent!");

			$this->update(['sent_email', 1]);
		}else{
			Session::putFlash('danger', "Confirmation Mail Could not Send.");
		}	
		
	}


	


	private function give_subscriber_upline_commission()
	{
		return;
		$settings= SiteSettings::commission_settings();
		$month 	 = date("F");
		$user 	 = $this->user;

		$month_index = date('m');


		$tree = $user->referred_members_uplines(3);
		$detail = $this->plandetails;



		 echo "<pre>";
		 // print_r($detail);
		 // print_r($settings);
		 // print_r($tree);

		foreach ($tree as $level => $upline) {
		 		    $amount_earned = $settings[$level]['packages'] * 0.01 * $detail['commission_price'];
					$comment = $detail['package_type']." Package Level {$level} Bonus";

					if ($level == 0) {
						 $comment = $detail['package_type']." Package self Bonus";
					}

					// ensure  upliner is qualified for commission
					if (! $upline->is_qualified_for_commission($level)) {
							continue;
					}
					
			$credit[]  = LevelIncomeReport::credit_user($upline['id'], $amount_earned, $comment , $upline->id, $this->id);
		}

		return $credit;
	}

	public function is_paid()
	{

		return (bool) ($this->paid_at != null);
	}


	public function upload_payment_proof($file)
	{

		$directory 	= 'uploads/images/payment_proof';
		$handle  	= new Upload($file);

		if (explode('/', $handle->file_src_mime)[0] == 'image') {

			$handle->Process($directory);
	 		$original_file  = $directory.'/'.$handle->file_dst_name;

			(new Upload($this->payment_proof))->clean();
			$this->update(['payment_proof' => $original_file]);
		}

	}



	public function getplandetailsAttribute()
	{
		return json_decode($this->details, true);
	}


	public function payment_plan()
	{
		return $this->belongsTo('SubscriptionPlan', 'plan_id');

	}


	public static function user_has_pending_order($user_id, $plan_id)
	{
		return (bool) self::where('user_id', $user_id)
					->where('plan_id', $plan_id)
					->where('paid_at', '=' ,null)->count();
	}



	public function total_qty()
	{
		return 1;
	}

	public function total_tax_inclusive()
	{

		$breakdown = $this->payment_plan->PriceBreakdown;

		$tax = [
					'price_inclusive_of_tax' => $breakdown['total_payable'],
					'price_exclusive_of_tax' => $breakdown['set_price'],
					'total_sum_tax' => $breakdown['tax'],
				];

		return $tax;
	}
	public function total_price()
	{
		return $this->price;
	}


	public function generateOrderID()
	{

		$substr = substr(strval(time()), 7 );
		$order_id = "NSW{$this->id}P{$substr}";

		return $order_id;
	}

	public function cancelAgreement()
	{
		$order = self::where('id' ,$this->id)->Paid()->where('payment_state', 'automatic')->first();

		if ($order == null) {
			return ;
		}

		$shop = new Shop();
		$agreement_details = $this->fetchAgreement();
		$expires_at = date("Y-m-d", strtotime($agreement_details['next_billing_date']));

		DB::beginTransaction();
		try {
			
			$shop->setOrder($this)->cancelAgreement();

			$this->update([
							'payment_state' => 'cancelled',
							'expires_at' => $expires_at,
						]);

			DB::commit();
			Session::putFlash("success","{$this->package_type} Billing cancelled successfully");
		} catch (Exception $e) {
			DB::rollback();
			
		}
	}

	public function getPaymentDetailsArrayAttribute()
	{
		if ($this->payment_details == null) {
			return [];
		}

		$payment_details = json_decode($this->payment_details,true);

		return $payment_details;
	}

	public function update_agreement_id($agreement_id)
	{
		$array = $this->PaymentDetailsArray;
		$array['agreement_id'] = $agreement_id;

		$this->update([	
							'payment_details' => json_encode($array)
					]);
		
	}

	public function setPayment($payment_method,array $payment_details)
	{
		
		$this->update([
			'payment_method' => $payment_method,
			'payment_state' => @$payment_details['payment_state'],
			'payment_details' => json_encode($payment_details),
		]);

		return $this;
	}




	public  function create_order($cart)
	{
		extract($cart);

		$payment_plan = SubscriptionPlan::find($plan_id);
		$new_payment_order = self::create([
								 'plan_id'  	=> $plan_id,
								 'user_id' 		=> $user_id,
								 'price'   		=> $price,
								 'details'		=> json_encode($payment_plan),
							]);

		return $new_payment_order;
	}


	public function getpaymentstatusAttribute()
	{
		if ($this->paid_at != null) {

			$label = '<span class="badge badge-success">Paid</span>';
		}else{
			$label = '<span class="badge badge-danger">Unpaid</span>';
		}

		return $label;
	}

	public function user()
	{
		return $this->belongsTo('User', 'user_id');

	}




}


















?>