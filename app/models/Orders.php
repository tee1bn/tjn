	<?php

use Illuminate\Database\Capsule\Manager as DB;

// use v2\Tax\Tax;
use v2\Shop\Contracts\OrderInterface;
use Illuminate\Database\Eloquent\Model as Eloquent;
use  Filters\Traits\Filterable;
use  v2\Shop\Shop;


use v2\Models\Sales;
use v2\Models\Wallet;






require_once "app/controllers/home.php";




class Orders extends Eloquent  implements OrderInterface

{
	use Filterable;
	
		protected $fillable = [
								'user_id',
								'affiliate_id',
								'customer_id',
								'percent_off',
								'amount_payable',
								'item',
								'payment_breakdown',
								'payment_method',
								'payment_details',
								'additional_note',
								'payment_proof',
								'buyer_order',
								'extra_detail',
								'status',
								'settled_at',
								'paid_at',
							];
	
	protected $table = 'orders';
	public $name_in_shop = 'product';

	//during purchase
	public static $available_payment_methods =  [
													'coinpay'=>[
																'method'=>'CoinPay',
																'word'=>'Pay Now (CoinPay)',
															],
													'paypal'=>[
																'method'=>'PayPal',
																'word'=>'Pay Now (PayPal)',
															]
												];





	public function delivery_heading()
	{
		$heading = "";
		$sellers = $this->sellers();
		if (count($sellers) > 1) {
			$date = date("M j, Y", strtotime($order->paid_at));

			$heading = "Delivery Order#$order->id, $date";

		}else{

			$seller = $sellers->first();	
			$heading = $seller->DisplayTradeName;
		}

		return $heading;
	}												
    
	public function sellers()
	{

		$order_details =  $this->order_detail();
		$sellers = [];
		foreach ($order_details as $order) {
			$sellers[] = $order['market_details']['user_id'];
		}

		$sellers = array_unique($sellers);
		$sellers = User::whereIn('id', $sellers)->get();

		return $sellers;
	}



	public function items_sold_by_editor($editor_id)
	{
		$order_detail = $this->order_detail();


		$order_details = array_filter($order_detail, function($item) use ($editor_id){

			if ($item['market_details']['user_id'] == $editor_id){
				return true;
			}
		});

		$count = count($order_details);

		foreach ($order_details as $order) {
			$total_price[] = $order['market_details']['price'] * $order['qty'];
		}

		$total =  array_sum($total_price) ;


		$response = compact('order_details','count','total');

		return $response;
	}



public function scopeSoldBy($query, $editor_id)
{	

$identifier1 = <<<ELL
"user_id":$editor_id

ELL;

	$identifier1 = trim($identifier1);

$identifier2 = <<<ELL
"user_id":"$editor_id"

ELL;

	$identifier2 = trim($identifier2);


	$query->whereRaw("(buyer_order like ? 
								OR buyer_order like ? )", 

								array("%$identifier1%",
									"%$identifier2%"
							));

		return $query;
	}
												


	public function getExtraDetailArrayAttribute()
	{
		if ($this->extra_detail == null) {
			return [];
		}


		return json_decode($this->extra_detail, true);
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
												

	public function after_payment_url()
	{
		$domain = Config::domain();
		$id = MIS::dec_enc('encrypt', $this->id);
		$url = "$domain/shop/delivery/$id";
		return $url;
	}												
	
	public function invoice()
	{

		$summary = [];

		foreach ($this->order_detail() as $key => $line) {

			$amount = $line['qty'] *  $line['market_details']['price'];
			$summary[] = [

				'item' => $line['market_details']['name'],
				'description' => "",
				'rate' => $line['market_details']['price'],
				'qty' => $line['qty'],
				'amount' => $amount,


				'print_tax' => '0%',
				'line_tax' => $amount,
				'before_tax' => $amount,
				'after_tax' => $amount,
				'tax' => [],

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
		$view  =	$controller->buildView('composed/invoice', compact('order'));
		

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



	public function getpaymentstatusAttribute(){

		return $this->PaidStatus;
	}



	public function payment_links()
	{

		$domain = Config::domain();
		$link = '';
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
		$vat_percent =  $setting['vat_percent'] ??0;
		
		$subtotal = $this->total_price();		
		$vat = $vat_percent * 0.01 * $subtotal;


		$result =[
			'value' => $vat,
			'percent' => $vat_percent,
		];

		$result =[
			'value' => 0,
			'percent' => 0,
		];


		return $result;
	}

	


	public function getTransactionIDAttribute()
	{
		$payment_details = json_decode($this->payment_details,true);
		$gateway = str_replace("coinpay", "coinwaypay", $payment_details['gateway']);
		$method = "{$payment_details['ref']} <span class='badge badge-sm badge-primary'>{$gateway}</span>";
					
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


	public function customer()
	{
		return $this->belongsTo('Customer', 'customer_id');
	}


	public function mark_paid()
	{
		DB::beginTransaction();

		try {
			

			$this->update(['paid_at'=> date("Y-m-d H:i:s")]);
			// $this->give_upline_sale_commission();
			$this->settle();
			DB::commit();
			Shop::empty_cart_in_session();
			Session::putFlash("success","Order completed successfully");
			return true;
		} catch (Exception $e) {
			DB::rollback();
			return false;
		}
	}


	public function is_free()
	{
		return $this->total_price() == 0;
	}


	public function settle()
	{

		if ($this->is_free()) {
			return;
		}

		$settings= SiteSettings::find_criteria('rules_settings')->settingsArray;
		$settlement_structure = $settings['settlement'];
		$order_detail = $this->order_detail();

		// print_r($order_detail);


		DB::beginTransaction();

		try {
				
			foreach ($order_detail as $key => $item) {
				$price =  $item['market_details']['price'];

				$vendor_id = $item['market_details']['user_id'];

				$company_share = $settlement_structure['company_percent'] * 0.01 * $price;

				$affiliate_share = $settlement_structure['affiliate_percent'] * 0.01 * $price;
				$vendor_share = $settlement_structure['vendor_percent'] * 0.01 * $price;

				if ($this->affiliate_id == null) {
					$vendor_share += $affiliate_share;
				}





				$extra_detail = [];

				$comment ="settlement on #order_id:$this->id#item:{$item['market_details']['id']}";


				$paid_at = date("Y-m-d", strtotime("+0 days"));

				$identifier = "tv#u{$vendor_id}#item{$item['market_details']['id']}#o$this->id";
				$vendor_credit = Wallet::createTransaction(
				    'credit',
				    $vendor_id,
				    null,
				    $vendor_share,
				    'completed',
				    'sale',
				    $comment,
				    $identifier,
				    $this->id,
				    null,
				    json_encode($extra_detail),
				    $paid_at
				);

				$identifier = "ta#u{$this->affiliate_id}#item{$item['market_details']['id']}#o$this->id";
				if ($this->affiliate_id != null) {
					$affiliate_credit = Wallet::createTransaction(
					    'credit',
					    $vendor_id,
					    null,
					    $affiliate_share,
					    'completed',
					    'affiliate',
					    $comment,
					    $identifier,
					    $this->id,
					    null,
					    json_encode($extra_detail),
					    $paid_at
					);
				}


				$identifier = "tc#u1#item{$item['market_details']['id']}#o$this->id";
				$affiliate_credit = Wallet::createTransaction(
				    'credit',
				    1,
				    null,
				    $affiliate_share,
				    'completed',
				    'adjustment',
				    $comment,
				    $identifier,
				    $this->id,
				    null,
				    json_encode($extra_detail),
				    $paid_at
				);
			
			}


			$this->mark_as_settled();
			DB::commit();	
		} catch (Exception $e) {
			DB::rollback();	

			print_r($e->getMessage());
		}



		return;
	}



	public function mark_as_settled()
	{
		$now = date("Y-m-d H:i:s");
		$this->update(['settled_at' => $now]);

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

			return '<span class="badge badge-success">Paid</span>';
		}

			return '<span class="badge badge-danger">Unpaid</span>';

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


	public function getBuyerAttribute()
	{
		if ($this->user_id != null) {

			return $this->user;
		}

		return $this->customer;
	}

	public function generateOrderID()
	{

		$substr = substr(strval(time()), 7 );
		$order_id = "SRA{$this->id}P{$this->Buyer->id}";

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

			$total_price[] = $order['market_details']['price'] *$order['qty'];

		}

		$total =  array_sum($total_price);
		return $total;
	}

public function scopePaid($query)
{
	return $query->where('paid_at', '!=', null);
}

	public function total_tax_inclusive($style = 'tax_exclusive')
	{

		$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;
		$vat_percent = $setting['vat_percent'];

		$vat_percent = 0;
		
		$total_sum_tax = $vat_percent * 0.01 * $this->total_price();
		$total_tax_inclusive = $total_sum_tax + $this->total_price();

		switch ($style) {
			case 'tax_exclusive':




				$tax = [

							'price_inclusive_of_tax' => $total_tax_inclusive,
							'price_exclusive_of_tax' => $this->total_price(),
							'total_sum_tax' => $total_sum_tax,
						];

				break;

			case 'tax_inclusive':


				$before_tax = $this->total_price() * (100/$vat_percent);

				$total_sum_tax = $vat_percent * $before_tax * 0.01;

				$tax = [

							'price_inclusive_of_tax' => $this->total_price(),
							'price_exclusive_of_tax' => $before_tax,
							'total_sum_tax' => $total_sum_tax,
						];

				break;
			
			default:
				# code...
				break;
		}





		return $tax;

		/*$tax = new Tax;
		$tax_payable  =	$tax->setTaxSystem('indian_tax');
		return $tax->setOrder($this)->calculateApplicableTax()->amount_taxable;*/
	}





	public function tax_breakdown()
	{
		$tax = new Tax;
		$tax_payable  =	$tax->setTaxSystem('general_tax');
		 return $tax->setProduct($this)
		 ->calculateApplicableTax()->amount_taxable
		 ;
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