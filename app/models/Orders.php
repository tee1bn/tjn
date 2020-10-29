	<?php

use Illuminate\Database\Capsule\Manager as DB;

use v2\Tax\Tax;
use v2\Models\Offer;
use v2\Shop\Contracts\OrderInterface;
use Illuminate\Database\Eloquent\Model as Eloquent;
use  Filters\Traits\Filterable;
use v2\Shop\Shop;

require_once "../app/controllers/home.php";


class Orders extends Eloquent  implements OrderInterface

{
	use Filterable;
	
		protected $fillable = [
								'user_id',
								'percent_off',
								'amount_payable',
								'item',
								'payment_breakdown',
								'payment_method',
								'payment_details',
								'additional_note',
								'buyer_order',
								'status',
								'paid_at',
							];
	
	protected $table = 'orders';
	public $name_in_shop = 'courses';

	//during purchase
	public static $available_payment_methods =  [
													'paytm'=>[
																'method'=>'PayTm',
																'word'=>'Pay Now (Paytm)',
															],
													'paypal'=>[
																'method'=>'PayPal',
																'word'=>'Pay Now (PayPal)',
															],

													'website'=>[
																'method'=>'Website',
																'word'=>'Pay Now (Website)',
															],
												];




	public function after_payment_url()
	{
		$domain = Config::domain();
		$url = "$domain/user/courses";
		return $url;
	}												


	public function tax_breakdown()
	{
	    $tax = new Tax;
	    $tax_payable  = $tax->setTaxSystem('general_tax');
	     return $tax->setProduct($this)->setTaxStyleOnPrice('tax_exclusive')
	     ->calculateApplicableTax()->amount_taxable
	     ;

	}


	
	public function invoice()
	{

		$summary = [];

		foreach ($this->order_detail() as $key => $line) {


			$tax = new Tax;
			$tax_payable  = $tax->setTaxSystem('general_tax');
			 $tax_breakdown = $tax->setAmount($line['deal_price'])->setTaxStyleOnPrice('tax_exclusive')
							 ->calculateApplicableTax()->amount_taxable
							 ;

			
			$rate = $tax_breakdown['breakdown']['set_price'];
			$amount = $line['qty'] *  $rate;

			$tax = $tax_breakdown;

			$unit_tax = $tax['breakdown']['tax_payable'];
			$line_tax = $unit_tax * $line['qty'];
			$print_tax = "$line_tax 
			<br><small> {$tax['breakdown']['total_percent_tax']}% {$tax['pricing']} </small>";

			$before_tax = $tax['breakdown']['before_tax'] * $line['qty'];

			
			if (isset($line['offer_id'] )) {
				$offer_data = $line['market_details']['offers_available'][$line['offer_id']];
				$offer = new Offer;

				foreach ($offer_data as $key => $value) {
					$offer[$key] = $value;
				}
			}

		

			$summary[] = [

				'item' => $line['market_details']['name'],
				'description' => $offer->name ?? '',
				'rate' => $rate,
				'print_tax' => $print_tax,
				'line_tax' => $line_tax,
				'before_tax' => $before_tax,
				'tax' => $tax,
				'qty' => $line['qty'],
				'amount' => $amount,
			];
		}



		$subtotal = collect($summary)->sum('amount');
		$total_tax = collect($summary)->sum('line_tax');

		$total_before_tax = collect($summary)->sum('before_tax');
		$total_after_tax = $subtotal;


		$stamp_duty_consideration = $total_before_tax ;
		$payment_method = $_POST['payment_method'] ?? $this->payment_method;

		$shop = new Shop;
		$shop->setOrder($this)
		->setPaymentMethod($payment_method);

		$stamp_duty = $shop->stampDutyBreakdown($stamp_duty_consideration);


		$subtotal_payable = $total_before_tax + $total_tax + $stamp_duty['stamp_duty'];

		$gateway_fee = $shop->payment_method->gatewayChargeOn($subtotal_payable);
		$total_payable = $subtotal_payable + $gateway_fee;
		$gateway_name = $shop->payment_method->name;


// die();


		$grand_total = $total_before_tax + $total_tax + $stamp_duty['stamp_duty'];

		$total_payable = $grand_total + $gateway_fee;


		$lines =  [
				'subtotal' =>[
						'name'=> 'Sub Total ',
						'value'=> $total_before_tax,
					],
				'tax' =>[
						'name'=> 'VAT',
						'value'=> $total_tax,
					],

				'stamp_duty' => [
								'value'=> $stamp_duty['stamp_duty'],
								'name' => 'Stamp Duty',
								],

				'grand_total' =>[
						'name'=> 'Grand Total',
						'value'=> $grand_total,
					],


				'gateway_fee' => [
								'value'=> $gateway_fee,
								'name' => ucfirst($gateway_name)." gateway fee",
								],

				'total_payable' =>[
						'name'=> 'Total Payable',
						'value'=> $total_payable,
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
			'payment_status' => $this->PaidStatus,
			'summary' => $summary,
			'subtotal' => $subtotal,
		];

		return $invoice;

		
	}



	public function invoice_()
	{

		$summary = [];

		foreach ($this->order_detail() as $key => $line) {


			$summary[] = [

				'item' => $line['market_details']['name'],
				'description' => "Course Order",
				'rate' => $line['deal_price'],
				'qty' => 1,
				'amount' => $line['deal_price'],
			];
		}



		$subtotal = [
			'subtotal'=> null,
			'lines' => $this->PaymentBreakdownArray,

			'total'=> null,
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
		// echo $view  =	$controller->buildView('auth/order_detail', compact('order'));

		 $view  =	$controller->buildView('composed/invoice', compact('order'));
		
		$mpdf = new \Mpdf\Mpdf([
			'margin_left' => 5,
			'margin_right' => 5,
			'margin_top' => 10,
			'margin_bottom' => 20,
			'margin_header' => 10,
			'margin_footer' => 10
		]);

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


		$mpdf->WriteHTML($view);
		$mpdf->Output("invoice#$order->id.pdf", \Mpdf\Output\Destination::INLINE);			

	}


	public function getPaidStatusAttribute()
	{
		if ($this->paid_at) {

			return '<span class="badge badge-sm badge-success">Paid</span>';
		}

			return '<span class="badge badge-sm badge-danger">Unpaid</span>';

	}




	public function payment_links()
	{

		$domain = Config::domain();

		foreach (self::$available_payment_methods as $key => $method) {

			$checkout_param = http_build_query([
				'item_purchased'=> $this->name_in_shop,
				'order_unique_id'=> $this->id,
				'payment_method'=>  $key,
			]);

			$link .= "<a href='$domain/shop/checkout?$checkout_param' class='dropdown-item'> $method[word] </a>";
		}

		return $link;
	}

	public function service_fee()
	{
		$service_fee_percent = 1;
		$subtotal = $this->total_price();
		$service_fee = $service_fee_percent * .01 * $subtotal;

		$result =[
			'value' => 0,
			'percent' => 0,
		];

		return $result;
	}


	public function calculate_vat()
	{

		$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;
		$vat_percent =  $setting['vat_percent'];
		
		$subtotal = $this->total_price();		
		$vat = $vat_percent * 0.01 * $subtotal;


		$result =[
			'value' => $vat,
			'percent' => $vat_percent,
		];


		return $result;
	}

	


	public function getTransactionIDAttribute()
	{
		$payment_details = json_decode($this->payment_details,true);
		$method = "{$payment_details['ref']}<br><span class='badge badge-sm badge-primary'>{$payment_details['gateway']}</span>";
					
		return $method;
	}


	
	public function getreverifyLinkAttribute()
	{
		$domain = Config::domain();
		$param = http_build_query([
			'item_purchased'=> $this->name_in_shop,
			'order_unique_id'=> $this->id,
			'payment_method'=>  $this->payment_method,
		]);



		return "$domain/shop/re_confirm_order/?$param";
	}

	

	public function download()
	{
		$detail = $this->order_detail();

		$detail_obj = collect($detail)->groupBy('scheme');


		$files = [];

		foreach ($detail as $key => $item) {

			$license_keys = LicenseKey::where('order_id', $this->id)
									  ->where('purchased_product_id' , $item['id'])
									  ->get()->pluck('license_key');

			$detail[$key]['license'] = $license_keys->toArray();
		}

				$mpdf = new \Mpdf\Mpdf([
			        'margin_left' => 15,
			        'margin_right' => 15,
			        'margin_top' => 10,
			        'margin_bottom' => 20,
			        'margin_header' => 10,
			        'margin_footer' => 10
			    ]);


				$company_name = Config::project_name();

			    $mpdf->SetProtection(array('print'));
			    $mpdf->SetTitle("{$company_name}");
			    $mpdf->SetAuthor($company_name);
			    $mpdf->SetWatermarkText("{$company_name}");
			    $mpdf->showWatermarkText = true;
			    $mpdf->watermark_font = 'DejaVuSansCondensed';
			    $mpdf->watermarkTextAlpha = 0.1;
			    $mpdf->SetDisplayMode('fullpage');

			    $date_now = date('Y-m-d H:i:s');

			    $mpdf->SetFooter("Date Generated: " . $date_now . " - {PAGENO} of {nbpg}");


					$user = $this->user;

			    foreach ($detail as $key => $item) {

						$text= "<p style='font-size:20px; text-decoration:underline;'>{$item['name']} License Key(s)</p>";
						foreach ($item['license'] as $i => $license_key ) {
								$i++;
								$text .= "$i) $license_key <br>";
						}

						$instruction = Products::find($item['id'])->instruction;

					$instruction = str_replace("[FIRSTNAME]", "<b>$user->firstname</b>", $instruction);
					$instruction = str_replace("[LASTNAME]", "<b>$user->lastname</b>", $instruction);
					$instruction = str_replace("[FULLNAME]", "<b>$user->fullname</b>", $instruction);
					$instruction = str_replace("[USERNAME]", "<b>$user->username</b>", $instruction);


					$mpdf->AddPage();
					$mpdf->WriteFixedPosHTML($instruction, 30, 30, 150, 250, 'auto');
					$mpdf->AddPage();
					$mpdf->WriteFixedPosHTML($text, 30, 30, 150, 250, 'auto');

			    }

			    $file_name = "{$this->user->firstname}-order{$this->id}.pdf";
			$mpdf->Output("$file_name", \Mpdf\Output\Destination::DOWNLOAD);			

	}

	public  function scheme_html($item_id)
	{
		$product = Products::find($item_id);
		$subscription = $product->scheme_attached;
		$controller = new home();
		$name = $this->user->fullname;
		$html = $controller->buildView("emails/subscription_confirmation", compact('subscription','name'));	



				    $mpdf = new \Mpdf\Mpdf([
			        'margin_left' => 15,
			        'margin_right' => 15,
			        'margin_top' => 10,
			        'margin_bottom' => 20,
			        'margin_header' => 10,
			        'margin_footer' => 10
			    ]);

				  $project_name = Config::project_name();
				  $domain = Config::domain();

			    $mpdf->SetProtection(array('print'));
			    $mpdf->SetTitle("$project_name");
			    $mpdf->SetAuthor("$project_name");
			    $mpdf->SetWatermarkText("$project_name");
			    $mpdf->showWatermarkText = true;
			    $mpdf->watermark_font = 'DejaVuSansCondensed';
			    $mpdf->watermarkTextAlpha = 0.1;
			    $mpdf->SetDisplayMode('fullpage');

			    $date_now = (date('Y-m-d H:i:s'));

			    $mpdf->SetFooter("Date Generated: " . $date_now . " - {PAGENO} of {nbpg}");



			    $mpdf->WriteHTML($html);
			    try {
			    	
					    $mpdf->Output("../uploads/runtime/$subscription->id-instruction.pdf", \Mpdf\Output\Destination::FILE);

			    } catch (Exception $e) {
			    	
			    }
	

		return $html;
	}



	public function readyForPayment()
	{	
		$cart = [];
		$cart['$items'] = $this->order_detail();
		return self::confirm_order_is_safe_for_processing($cart);
	}


	public static function confirm_order_is_safe_for_processing($cart)
	{

		foreach ($cart['$items'] as $key => $item) {
			$available_keys = 	LicenseKey::available_keys($item['id'])->count();


			switch ($available_keys) {
				case 0:

					$note = "$item[name] is <code>Out of Stock</code>";

					break;
				
				default:
					$note = "$available_keys qty of $item[name] can be ordered now.";
					break;
			}


			if ($available_keys < $item['qty']) {
				Session::putFlash("danger","$note");
				$errors[] = 1;
			}else{


			}

		}

		if (count($errors) > 0) {

			return false;
		}

		return true;
	}



	public function user()
	{

		return $this->belongsTo('User', 'user_id');
	}

	public function mark_paid()
	{
		DB::beginTransaction();

		try {
			

			$this->update(['paid_at'=> date("Y-m-d H:i:s")]);
			// $this->give_upline_sale_commission();

			DB::commit();
			Session::putFlash("success","Payments Recieved Successfully");
			return true;
		} catch (Exception $e) {
			DB::rollback();
			return false;
		}
	}



	private function give_upline_sale_commission()
	{

		$settings= SiteSettings::site_settings();

		$user 	 = $this->user;
		$upline  = User::where('mlm_id' , $user->referred_by)->first();
		$amount  = $settings['product_sales_commission'] * 0.01 * $this->amount_payable;
		$comment = "#{$this->id} Product Commission";

		$month_index = date('m');


		$credit  = Earning::credit_user($upline['id'], $amount, $comment , $user->id, $this->id);
		return $credit;
	}





	public function getpaymentAttribute()
	{
		if ($this->paid_at) {

			return '<span class="label label-success">Paid</span>';
		}

			return '<span class="label label-danger">Unpaid</span>';

	}


	public function getdateAttribute()
	{
		return date("M d, Y", strtotime($this->created_at)) ;
	}
	


	public function has_item($item_id)
	{

		foreach ($this->order_detail() as $key => $item) {
			if ($item['id'] ==  $item_id) {
				return true;
			}
		}


		return false;
	}

	public function order_detail()
	{
		return (json_decode($this->buyer_order,true));
	}

	public function total_item()
	{

		$orders =  $this->order_detail();
		
		return count($orders);
	}


	public function generateOrderID()
	{

		$substr = substr(strval(time()), 7 );
		$order_id = "9G{$this->id}FA{$substr}";

		return $order_id;
	}

	public function setPayment($payment_method,array $payment_details, $order_id = null)
	{
		$this->update([
			'order_id' => $order_id,
			'payment_method' => $payment_method,
			'payment_details' => json_encode($payment_details),
		]);

		return $this;
	}


	

	public function getpaymentDetailArrayAttribute()
	{
		return  json_decode($this->payment_details, true);
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

	public function getPaymentBreakdownArrayAttribute()
	{
		return json_decode($this->payment_breakdown, true);
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

	public function total_qty()
	{

		$orders =  $this->order_detail();
		foreach ($orders as $order) {

			$total_qty[] = $order['qty'];

		}

		return array_sum($total_qty);
	}



	public function total_price()
	{

		$orders =  $this->order_detail();
		foreach ($orders as $order) {

			$total_price[] = $order['deal_price'] *$order['qty'];

		}

		$total =  array_sum($total_price);
		return $total;
	}


	public function total_tax_inclusive()
	{
		$tax = new Tax;
		$tax_payable  =	$tax->setTaxSystem('indian_tax');
		return $tax->setOrder($this)->calculateApplicableTax()->amount_taxable;
	}



	public function is_paid()
	{

		return (bool) ($this->paid_at != null);
	}


	public function delete_order(array $ids)
	{
		foreach ($ids as $key => $id) {
			$order = self::find($id);
				if ($order != null) {

					try{
					 $order->delete();
					}catch(Exeception $e){

					}
				}
			}
			return true;
	}



}


















?>