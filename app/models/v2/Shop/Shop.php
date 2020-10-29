<?php

namespace v2\Shop;
use Exception, SiteSettings, MIS, Config;
/**
 * 
 */
class Shop 
{
	
	public $available_payment_method;
	public $available_orders;
	private $payment_method;
	private $order;


	function __construct($argument = null)
	{
		$this->setup_available_payment_method();
		$this->setup_available_orders();
	}





	
	public function reVerifyPayment()
	{	

		$this->setPaymentMethod($this->order->payment_method) ;
		$verification =  ($this->payment_method->reVerifyPayment($this->order));

		//payment confirmed
		if ($verification['confirmation']['status'] == 1) {
			$this->order->mark_paid();
			// $this->createQobORDER($this->order);
			self::empty_cart_in_session();
		}

		return $this;
	}




	public function vatBreakdown($amount, $amount_is='before_vat')
	{


		$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;
		$vat_percent = $setting['vat_percent'];

	

		switch ($amount_is) {

			case 'before_vat':

				$vat = $vat_percent * 0.01 * $amount;
				$after_vat = $amount + $vat;

				$breakdown =[
					'value' => $vat,
					'percent' => $vat_percent,
					'before_vat' => $amount,
					'after_vat' => $after_vat,
				];

				break;

			case 'after_vat':

				$before_vat = ($amount * 100) / ($vat_percent+100);
				$vat = $vat_percent * 0.01 * $before_vat;


				$breakdown =[
					'value' => $vat,
					'percent' => $vat_percent,
					'before_vat' => $before_vat,
					'after_vat' => $amount,
				];

				break;
			
			default:
				# code...
				break;
		}


		return $breakdown;

	}



	public function stampDutyBreakdown($amount, $amount_is='before_stampduty')
	{

		$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;

		$charge_stamp_duty_from = $setting['charge_stamp_duty_from'];
		$stamp_duty = $setting['stamp_duty'];

		switch ($amount_is) {
			case 'before_stampduty':

				if ($amount >= $charge_stamp_duty_from) {

					$charge = $stamp_duty;
				}else{

					$charge = 0;
				}

				$after_stamp_duty = $stamp_duty + $amount;

				 $breakdown= [
					'before_stampduty'=> $amount,
					'stamp_duty'=> $charge,
					'after_stamp_duty'=> $after_stamp_duty
				];

				break;

			case 'after_stampduty':

				$before_stampduty = $amount - $stamp_duty;


				if ($before_stampduty >= $charge_stamp_duty_from) {

					$charge = $stamp_duty;

				}else{

					$charge = 0;
				}

				$before_stampduty =  $amount  - $charge ;

				 $breakdown= [
					'before_stampduty'=> $before_stampduty,
					'stamp_duty'=> $charge,
					'after_stamp_duty'=> $amount
				];

				break;
			
			default:
				# code...
				break;
		}


		return $breakdown;
	}




	public function paymentBreakdown()
	{
		//subtotal
		//service_fee
		//stamp_duty
		//vat
		//gateway fee

		$breakdown = $this->order->invoice()['subtotal']['lines'];

		if ($this->order->name_in_shop =='course') {
			return $breakdown;
		}

		$subtotal = $this->order->total_price();

		$stamp_duty = $this->stampDutyBreakdown($subtotal)['stamp_duty'];



		$service_fee = $this->order->service_fee();
		$vat = $this->order->calculate_vat();

		$subtotal_payable = $subtotal + $service_fee['value'] + $stamp_duty + $vat['value'];

		$gateway_fee = $this->payment_method->gatewayChargeOn($subtotal_payable);
		$total_payable = $subtotal_payable + $gateway_fee;
		$gateway_name = $this->payment_method->name;


		$breakdown = [
			/*'actual_order' => [
							'value'=> $this->order->amount,
							'name' => 'Order',
							],*/

			'subtotal' => [
							'value'=> $subtotal,
							'name' => 'Sub Total',
							],


			'service_fee' => [
							'value'=> $service_fee['value'],
							'name' => "Service Charge({$service_fee['percent']}%)",
							],

			'vat' => [
							'value'=> $vat['value'],
							'name' => "VAT({$vat['percent']}%)",
							],

			'stamp_duty' => [
							'value'=> $stamp_duty,
							'name' => 'Stamp Duty',
							],
			'subtotal_payable' => [
							'value'=> $subtotal_payable,
							'name' => 'Grand Total',
							],

			'gateway_fee' => [
							'value'=> $gateway_fee,
							'name' => ucfirst($gateway_name)." Fee",
							],

			'total_payable' => [
							'value'=> $total_payable,
							'name' => 'Total Payable',
							],
							
		];
		return $breakdown;
	}



	public function fetchPaymentBreakdown()
	{
		$breakdown = $this->paymentBreakdown();
		$currency = Config::currency();
		$line= '';
		foreach ($breakdown as $key => $value) {
			if ($value['value'] == 0) {
				continue;
			}
			$amt =  MIS::money_format($value['value']);
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






	public function __get($property_name)
	{
		return $this->$property_name;
	}
	
	public function get_available_payment_methods()
	{

		$available = array_filter($this->available_payment_method,  function($gateway){
			return $gateway['available'] == true;
		});

		return $available;
	}




	private function setup_available_payment_method()
	{

		$payments_settings = SiteSettings::payment_gateway_settings()->keyBy('criteria');
		

		$this->available_payment_method = [

				'paystack' => [
								'name' => 'Paystack',
								'class' => 'Paystack',
								'namespace' => "v2\Shop\Payments",
								'available' => $payments_settings['paystack_keys']->settingsArray['mode']['available']
							],

				'rave' => [
								'name' => 'Flutter Wave (Rave)',
								'class' => 'Rave',
								'namespace' => "v2\Shop\Payments",
								'available' => $payments_settings['flutter_wave_keys']->settingsArray['mode']['available']
							],

				'bank_transfer' => [
								'name' => 'Bank Transfer',
								'class' => 'BankTransfer',
								'namespace' => "v2\Shop\Payments",
								'available' => $payments_settings['bank_transfer']->settingsArray['mode']['available']
							],

				/*'website' => [
								'name' => 'Website',
								'class' => 'Website',
								'namespace' => "v2\Shop\Payments",
								'available' => $payments_settings['website_bonus_keys']->settingsArray['mode']['available']
							],
*/
		];

	}

	private function setup_available_orders()
	{	
		//the keys must correspond to public name_in_shop of this $order
		$this->available_type_of_orders = [

				'courses' => [
								'name' => 'Order', //because all
								'class' => 'Orders',
								'namespace' => "",
								'available' => true
							],

				'deposit' => [
								'name' => 'Deposit', 
								'class' => 'DepositOrder',
								'namespace' => "v2\Models",
								'available' => true
							],
		];

	}



	public static function empty_cart_in_session()
	{
		unset($_SESSION['cart']);
		unset($_SESSION['shop_checkout_id'] );
	}




	public function verifyPayment()
	{	

		$verification =  ($this->payment_method->verifyPayment($this->order));


		//payment confirmed
		if ($verification['confirmation']['status'] == 1) {
			$this->order->mark_paid();
			self::empty_cart_in_session();
			//clear session 
		}
		
		return $this;
	}


	public function setOrder($order)
	{
		$this->order = $order;
		if ($this->order->payment_method != null) {
			$this->setPaymentMethod($this->order->payment_method) ;
		}
		return $this;
	}



	public function initializePayment()
	{

		$this->payment_method->initializePayment($this->order);

		return $this;
	}

	public function setPaymentMethod($payment_method)
	{
		$payment_method;
		$method = $this->available_payment_method[$payment_method];

		if ($method['available'] != true) {
			throw new Exception("{$method['name']} payment method is not available", 1);
		}


		$full_class_name = $method['namespace'].'\\'.$method['class'];

		$this->payment_method = new  $full_class_name($this);
		$this->payment_method->setOrder($this->order);


		return $this;
	}

	public function setOrderType($order_type)
	{	

		$method = $this->available_type_of_orders[$order_type];

		 $full_class_name = $method['namespace'].'\\'.$method['class'];

		if ($method['available'] != true) {
			throw new Exception("{$method['name']} is not available", 1);
		}


		$this->order = new  $full_class_name;
		return $this;
	}


	public function receiveOrder(array $cart)
	{

		$this->order = 	$this->order->create_order($cart);

		return $this;
	}


	public function attemptPayment()
	{

		$payment_breakdown =  $this->paymentBreakdown();
		$this->order->setPaymentBreakdown($payment_breakdown); // important

		$this->payment_attempt_details = $this->payment_method->attemptPayment($this->order);
		$payment_attempt_details = $this->payment_attempt_details;

		// $payment_attempt_details['amount'] = $this->payment_method->amountPayable();
		return $payment_attempt_details;
	}

}