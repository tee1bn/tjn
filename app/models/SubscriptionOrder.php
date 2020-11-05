<?php


include_once 'app/controllers/home.php';

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;
use v2\Shop\Contracts\OrderInterface;
use  v2\Shop\Shop;
use v2\Tax\Tax;



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

	


	public  function getInvoice()
	{
		$controller = new \home;

		$order = $this;
		$remove_mle_detail = false;
		$view  =	$controller->buildView('composed/invoice', compact('order', 'remove_mle_detail'));

		// $view = "I am here"	;

		$mpdf = new \Mpdf\Mpdf([
			'margin_left' => 5,
			'margin_right' => 5,
			'margin_top' => 10,
			'margin_bottom' => 20,
			'margin_header' => 10,
			'margin_footer' => 10
		]);


		$src = Config::logo();
		$company_name = \Config::project_name();
		$mpdf->AddPage('P');
		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("{$company_name}");
		$mpdf->SetAuthor($company_name);
		// $mpdf->SetWatermarkText("{$company_name}");
		$mpdf->watermarkImg($src, 0.1);
		$mpdf->showWatermarkText = true;
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->watermarkTextAlpha = 0.2;
		$mpdf->SetDisplayMode('fullpage');

		$date_now = (date('Y-m-d H:i:s'));

		$mpdf->SetFooter("Date Generated: " . $date_now . " - {PAGENO} of {nbpg}");



		$mpdf->WriteHTML($view);
		$mpdf->Output("invoice#$order->id.pdf", \Mpdf\Output\Destination::INLINE);			


	}



	public function after_payment_url()
	{
		$domain = Config::domain();
		$url = "$domain/user/account_plan";
		return $url;
	}												


	public function getExpiryDateAttribute()
	{
		if ($this->expires_at != null) {

			return $this->expires_at;
		}

		$date_string = $this->paid_at;

		$cycle = SubscriptionPlan::$cycle;
		$date =  date("Y-m-d", strtotime("$date_string + 1 $cycle" )); // 2011-01-03

		return $date;
	}

	public function scopeNotExpired($query)
	{
		return $query->whereDate('expires_at', '>', date("Y-m-d"));
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




	public function tax_breakdown()
	{
		$tax = new Tax;
		$tax_payable  =	$tax->setTaxSystem('general_tax');
		 return $tax->setProduct($this)
		 ->calculateApplicableTax()->amount_taxable
		 ;
	}



	public  function invoice()
	{

		$detail = $this->plandetails;

		$tax = $this->tax_breakdown();


		$rate = $this->payment_plan->price;
		$qty = 1;
		$amount = $qty *  $rate;

		$unit_tax = $tax['breakdown']['tax_payable'];
		$line_tax = $unit_tax * $qty;

		$component_tax = '';
		foreach ( $tax['component'] as $key =>  $component) {
			$component_tax .="<br><small> {$component['percent']}% {$component['name']} </small>";
		}

		$print_tax = "$line_tax 
		<br><small> {$tax['breakdown']['total_percent_tax']}%  {$tax['pricing']} </small>";

		$before_tax = $tax['breakdown']['before_tax'] * $qty;
		$after_tax = $tax['breakdown']['total_payable'] * $qty;




		$summary = [
			[
				'item' => "$this->TransactionID",
				'description' => "{$detail['name']} Package ",
				'rate' => $rate,
				'qty' => $qty,
				'amount' => $amount,
				'print_tax' => $print_tax,
				'line_tax' => $line_tax,
				'before_tax' => $before_tax,
				'after_tax' => $after_tax,
				'tax' => $tax,
			]
		];


		$total_tax = collect($summary)->sum('line_tax');
		$total_before_tax = collect($summary)->sum('before_tax');
		$total_after_tax = collect($summary)->sum('after_tax');

		$lines =  [
				'subtotal' =>[
						'name'=> 'Sub Total Before Tax',
						'value'=> $total_before_tax,
					],
				'tax' =>[
						'name'=> 'Tax',
						'value'=> $total_tax,
					],
				'grand_total' =>[
						'name'=> 'Grand Total',
						'value'=> $total_after_tax,
					],

				'total_payable' =>[
						'name'=> 'Total Payable',
						'value'=> $total_after_tax,
					],
			];

		$extra_lines = [

			'total_before_tax' =>[
					'name'=> 'Sub Total Before Tax',
					'value'=> $total_before_tax,
				],

			'total_after_tax' =>[
					'name'=> 'Sub Total Before Tax',
					'value'=> $total_after_tax,
				],
		];

		$full_lines = array_merge($lines, $extra_lines);


		$subtotal = [
			'subtotal'=> null,
			'lines'=> $lines,
			// 'lines' => $this->PaymentBreakdownArray,
			'total'=> null,
			'full_lines'=> $full_lines,
		];
		


		$invoice = [
			'order_id' => $this->TransactionID,
			'invoice_id' => $this->TransactionID,
			'order_date' => $this->created_at,
			'payment_status' => $this->paymentstatus,
			'summary' => $summary,
			'subtotal' => $subtotal,
		];

		return $invoice;

		
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
			$cycle = SubscriptionPlan::$cycle;

			$this->update([
					'paid_at' => date("Y-m-d H:i:s"), 
					'expires_at' => date("Y-m-d H:i:s" ,strtotime("+1 $cycle"))
				]);
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


	public function getpaymentDetailArrayAttribute()
	{
		return  $this->PaymentDetailsArray;
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



	
	public function getBuyerAttribute()
	{
		if ($this->user_id != null) {

			return $this->user;
		}

		return $this->customer;
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


		// print_r($new_payment_order);
		return $new_payment_order;
	}


	public function setPaymentBreakdown(array $payment_breakdown, $order_id = null)
	{
		$this->update([
			'order_id' => $order_id,
			'payment_breakdown' => json_encode($payment_breakdown),
			'amount_payable' => $payment_breakdown['total_payable']['value'],
		]);

		return $this;
	}

	public function calculate_vat()
	{

	/*	$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;
		$vat_percent =  $setting['vat_percent'];
		
		$subtotal = $this->total_price();		
		$vat = $vat_percent * 0.01 * $subtotal;


		$result =[
			'value' => $vat,
			'percent' => $vat_percent,
		];*/

		$result =[
			'value' => 0,
			'percent' => 0,
		];


		return $result;
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