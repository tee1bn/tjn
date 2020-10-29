<?php


namespace v2\Models;
use  v2\Shop\Shop;
use v2\Shop\Contracts\OrderInterface;
use Illuminate\Database\Capsule\Manager as DB;
use Session, MIS, Config, SiteSettings, Mailer;
use Illuminate\Database\Eloquent\Model as Eloquent;
use  Filters\Traits\Filterable;
use  v2\Models\AdminComment;


require_once "../app/controllers/home.php";

class DepositOrder extends Eloquent implements OrderInterface
{

	use Filterable;

	
	protected $fillable = [
							'account_number',
							'broker_id',
							'category',
							'amount_payable',
							'amount', //amount ordered
							'paid_at',
							'payment_breakdown',
							'payment_method',
							'payment_details',
							'additional_note',
							'amount_to_fund',
							'amount_confirmed',
							'completed_at',
							'completed_by',
							'buyer_order',
							'user_id',
							'status',
							'created_at',
							'updated_at'
						];
	

	protected $table = 'deposit_orders';
	public $name_in_shop = 'deposit';
	public static $statuses = [
								'initialized'=> 'initialized',
								'pending'=> 'pending', //notified
								'confirmed'=> 'confirmed',
								'completed'=> 'completed',
								 'declined'=> 'declined'
								];



	


	public function after_payment_url()
	{
		$domain = Config::domain();
		$url = "$domain/user/deposit-history";
		return $url;
	}				

	public function invoice()
	{

		$detail = $this->ExtraDetailArray;
		$summary = [
			[
				'item' => "$this->TransactionID",
				'description' => "$this->amount$ Deposit Order",
				'rate' => "$this->amount",
				'qty' => 1,
				'amount' => $this->paymentBreakdownArray['subtotal']['value'],
			]
		];

		$subtotal = [
			'subtotal'=> null,
			'lines' => $this->PaymentBreakdownArray,

			'total'=> $detail['capital'],
		];

		$invoice = [
			'order_id' => $this->TransactionID,
			'invoice_id' => $this->TransactionID,
			'order_date' => $this->created_at,
			'payment_status' => $this->PaidStatus,
			'summary' => $summary,
			'subtotal' => $subtotal,
		];

		return $invoice;

	}

	

	public  function getInvoice()
	{

		$controller = new \home;
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

		$src = Config::domain()."/template/default/app-assets/images/logo/9gforex-icon.png";
		$company_name = \Config::project_name();
		$logo = \Config::domain()."/".\Config::logo();
		$mpdf->AddPage('P');
		$mpdf->SetProtection(array('print'));
		$mpdf->SetTitle("{$company_name}");
		$mpdf->SetAuthor($company_name);
		$mpdf->SetWatermarkText("{$company_name}");
		// $mpdf->watermarkImg($src);
		$mpdf->showWatermarkText = true;
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');

		$date_now = (date('Y-m-d H:i:s'));

		$mpdf->SetFooter("Date Generated: " . $date_now . " - {PAGENO} of {nbpg}");



		// return  "$view";
		// return;		
		$mpdf->WriteHTML($view);
		$mpdf->Output("invoice#$order->id.pdf", \Mpdf\Output\Destination::INLINE);			

	}


	




	public function adminComments()
	{       
	     $comments =   AdminComment::where('model_id', $this->id)->where('model', 'deposit')->get();
	     return $comments;
	}


	public static function get_status($status)
	{
		$order = new self();
		$order->status = $status;

		return $order->DisplayStatus;
	}

	public function getDisplayStatusAttribute()
	{

		switch ($this->status) {
			case 'initialized':
				$status = '<span class="badge badge-dark"> initialized</span>';
				break;
			
			case 'declined':
				$status = '<span class="badge badge-danger"> Declined</span>';
				break;
			
			case 'pending':
				$status = '<span class="badge badge-warning"> Pending</span>';
				break;
			
			case 'confirmed':
				$status = '<span class="badge badge-info"> Confirmed</span>';
				break;
			
			case 'completed':
				$status = '<span class="badge badge-success"> Completed</span>';
				break;
			
			default:
				$status = '<span class="badge badge-warning"> Unknown</span>';
				break;
		}

		return $status;
	}



	public function getPaidStatusAttribute()
	{
		if ($this->paid_at) {

			return '<span class="badge badge-sm badge-success">Paid</span>';
		}

			return '<span class="badge badge-sm badge-danger">Unpaid</span>';

	}




	public function user()
	{

		return $this->belongsTo('User', 'user_id');
	}

	public function admin()
	{
		return $this->belongsTo('Admin', 'completed_by');

	}

	public function calculate_vat()
	{
		$subtotal = $this->service_fee()['value'];		
		$result = MIS::calculate_vat($subtotal);
		return $result;
	}

	

	public function service_fee()
	{
		$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;

		$service_fee_percent =  $setting['deposit_service_charge_percent'];


		$subtotal = $this->total_price();
		$service_fee = $service_fee_percent * 0.01 * $subtotal;

		$result =[
			'value' => $service_fee,
			'percent' => $service_fee_percent,
		];

		return $result;
	}


	public function setPaymentBreakdown(array $payment_breakdown, $order_id = null)
	{
		$this->update([
			'payment_breakdown' => json_encode($payment_breakdown),
			'amount_payable' => $payment_breakdown['total_payable']['value'],
		]);

		return $this;
	}


	public function setPayment($payment_method,array $payment_details, $order_id = null){

		$this->update([
			'order_id' => $order_id,
			'payment_method' => $payment_method,
			'payment_details' => json_encode($payment_details),
		]);

		return $this;
	}


	public function broker()
	{
		return $this->belongsTo('v2\Models\Broker','broker_id');
	}


	public function create_order(array $cart){
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



	public function getTransactionIDAttribute()
	{
		$payment_details = json_decode($this->payment_details,true);
		$method = "{$payment_details['ref']}<br><span class='badge badge-info'>{$payment_details['gateway']}</span>";
					
		return $method;
	}



	public function getpaymentDetailArrayAttribute()
	{
		return  json_decode($this->payment_details, true);
	}

	public function generateOrderID(){

		$substr = substr(strval(time()), 7 );
		$order_id = "9G{$this->id}D{$substr}";

		return $order_id;
	}

	public function encrypt_id()
	{
		return \MIS::dec_enc('encrypt', $this->id);
	}

	public function is_paid(){

		return (bool) ($this->paid_at != null);
	}

	public function is_completed(){

		return (bool) ($this->status == 'completed');
	}
	public function is_confirmed(){

		return (bool) ($this->status == 'confirmed');
	}



	public function doReverseCalculation($amount_confirmed)
	{

		$shop = new shop();

		$shop->setOrder($this)->setPaymentMethod($this->payment_method);

		$deposit_breakdown = $this->PaymentBreakdownArray;

		$c =  $shop->payment_method->breakDownOn($amount_confirmed,'amount_paid');


		$grand_total = $c['set_price'];
		$stamp_duty = $shop->stampDutyBreakdown($grand_total,'after_stampduty');

		$before_stampduty = ($grand_total - $stamp_duty['stamp_duty']);


		$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;

		$service_fee_percent =  $setting['deposit_service_charge_percent'];
		$vat_percent =  $setting['vat_percent'];


		$before_service_fee = ($before_stampduty * 10000) /(10000+ (100*$service_fee_percent) + $vat_percent);



		$service_charge = $service_fee_percent * 0.01 * $before_service_fee;


		$vat = $shop->vatBreakdown($service_charge, 'before_vat');



		$exchange = $this->trading_account->getExchangeRate();
		$dollar_value = $before_service_fee / $exchange;
		$gateway = $this->payment_method;

		$gateway_fee = $c['charge'];
		$expecting = $deposit_breakdown['total_payable']['value'];
			


		$breakdown = compact(
							'amount_confirmed',
							'dollar_value',
							'exchange',
							'before_service_fee',
							'service_fee_percent',
							'service_charge',
							'vat',
							'stamp_duty',
							'gateway_fee',
							'gateway',
							'expecting'
							);

		return $breakdown;


	}


	public function trading_account()
	{
		return $this->belongsTo('v2\Models\TradingAccount', 'account_number', 'account_number');
	}

	public function total_price(){

		$exchange = $this->trading_account->getExchangeRate();

		$price = $exchange * $this->amount;
		return $price;
	}


	public function total_qty(){

		return 1;
	}

	public function fetchPaymentBreakdown()
	{



		$breakdown = $this->PaymentBreakdownArray;
		$currency = \Config::currency();
		$line= '';
		foreach ($breakdown as $key => $value) {
			if ($value['value'] == 0) {
				continue;
			}
			$amt =  \MIS::money_format($value['value']);
			$size='';
			if ($value == end($breakdown)) {
				$size= 'font-size:20px;font-weight:700;';
			}

			$line .= "                                   
	                                <tr>
	                                    <th style='padding: 5px;'>{$value['name']}</th>
	                                    <td class='text-right' style='padding: 5px;$size'>$currency$amt
	                                     
	                                    </td>  
	                                </tr>
					";

		}


		$breakdown['line'] =$line;

		return $breakdown;
			

	}


	public function getPaymentBreakdownArrayAttribute()
	{
		return json_decode($this->payment_breakdown, true);
	}

	public function mark_paid(){

		DB::beginTransaction();

		try {
			

			$this->update([
							'paid_at'=> date("Y-m-d H:i:s"),
							'status'=> "pending",
							]);
			// $this->give_upline_sale_commission();

			DB::commit();
			Session::putFlash("success","Payments Recieved Successfully");


			$domain = Config::domain();
			$project_name = Config::project_name();

			$admin_name = $this->admin->fullname ?? '';
			//notify admin
			$admin_content = "
						<p><strong>NOTICE</strong></p>

						<p>A Deposit of $this->amount$ for {$this->user->fullname} as been paid by {$admin_name}</p>

					<p>Please <a href='$domain/login/admin_login'>login </a>to confirm.</p>
			";


			$settings = SiteSettings::site_settings();
			$noreply_email = $settings['noreply_email'];
			$support_email = $settings['support_email'];
			$notification_email = $settings['notification_email'];



			$subject = "Notification Deposit - $project_name";
			$mailer = new Mailer;
			
			$admin_content = MIS::compile_email($admin_content);

			//ADMIN
		/*	$mailer->sendMail(
			    $notification_email,
				"$subject",
			    $admin_content,
			    "$project_name",
			    "$support_email",
			    "$project_name"
			);

*/

			return true;
		} catch (Exception $e) {
			DB::rollback();
			return false;
		}
	}


	public function market_details()
	{

	    $domain = Config::domain();
	    $url_friendly = MIS::encode_for_url($this->title);
	    $singlelink = "$domain/shop/full-view/$this->id/course/$url_friendly";
	    $thumbnail = "$domain/$this->image";

	    $market_details = [
	        'id' => $this->id,
	        'model' => self::class,
	        'name' => $this->title,
	        'short_name' => substr($this->title, 0, 34),
	        'description' => $this->description,
	        'short_description' => substr($this->description, 0, 50).'...',
	        'quick_description' => substr($this->description, 0, 250).'...',
	        'price' => $this->price,
	        'old_price' => 33,
	        'by' => ($this->instructor == null)? '' : "By {$this->instructor->fullname}",
	        'star_rating' => self::star_rating(3, 5),
	        'quickview' =>  $this->quickview(),
	        'single_link' =>  $singlelink,
	        'thumbnail' =>  $thumbnail,
	        'unique_name' =>  'course',  // this name is used to identify this item in cart and at delivery
	    ];

	    return $market_details;
	}   


}


















?>