<?php

namespace v2\Shop\Payments;
use v2\Shop\Contracts\OrderInterface;
use v2\Shop\Contracts\PaymentMethodInterface;
use Exception, SiteSettings, Session, Config;
/**
 * 
 */
class Rave implements PaymentMethodInterface
{
	private $name = 'rave';
	private $mode;
	private $shop;

	function __construct($shop)
	{

		$this->shop = $shop;
		$settings = SiteSettings::find_criteria('flutter_wave_keys')->settingsArray;

		$this->mode = $settings['mode']['mode'];

		$this->api_keys =  $settings[$this->mode];
		
		//initate my keys and all
	}

	
	public function __get($property_name)
	{
		return $this->$property_name;
	}
	




	public function reVerifyPayment()
	{
		
		return $this->verifyPayment();
	}

	public function verifyPayment()
	{

		
		$payment_details = json_decode($this->order->payment_details, true);
		$reference = $payment_details['ref'];
		$secret_key = $this->api_keys['secret_key'];
		$data = array('txref' => $reference,
		  'SECKEY' => $secret_key //secret key from pay button generated on rave dashboard
		);

	  	$headers = array('Content-Type' => 'application/json');
		$urls = [
					'test' => "https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/verify",
					'live' => "https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify",
				]; //url to staging server. please make sure to change when in production.

	    $url = $urls[$this->mode];




        $data_string = json_encode($data);
                
        $ch = curl_init($url);                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

 
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);



        $resp = json_decode($response, true);
    

      	$paymentStatus = $resp['data']['status'];
        $chargeResponsecode = $resp['data']['chargecode'];
        $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = $resp['data']['currency'];


        if ($chargeResponsecode == "00" || $chargeResponsecode == "0") {}else{
        	Session::putFlash("danger", "we could not complete your payment1.");
        	return false;
        }
        

        if ($chargeAmount != $this->amountPayable()) {
        	Session::putFlash("danger", "we could not complete your payment2.");
        	return false;
        }


        if ($chargeCurrency != $this->order->paymentDetailArray['currency']) {
        	Session::putFlash("danger", "we could not complete your payment3.");
        	return false;
        }


        if ($paymentStatus != 'successful') {
        	Session::putFlash("danger", "we could not complete your payment4.");
        	return false;
        }


        $result  = $resp;
		//give value        
		$confirmation = ['status'=>true];
		return compact('result','confirmation');


	}

	public function setOrder(OrderInterface $order)
	{
		$this->order = $order;
		return $this;

	}



		public function gatewayChargeOn($amount)
		{
			
			$breakdown = $this->breakDownOn($amount);
			return $breakdown['charge'];
		}



			
		public function breakDownOn($amount, $amount_is='set_price' ) { 

	        $constant = 50;
	        $percent = 1.4 * 0.01;
	        $cut_off = 0;
	        switch ($amount_is) {
	            case 'set_price':
	                $set_price = $amount;
	                if ($set_price > $cut_off) {
	                    $amount_paid = ($set_price + $constant)/ (1- $percent);
	                    $charge = ($percent * $amount_paid) + $constant;
	                }else{
	                    $amount_paid = ($set_price)/ (1- $percent);
	                    $charge = ($percent * $amount_paid);
	                }
	                $breakdown =  [
	                    'set_price' => $set_price,
	                    'amount_paid' => $amount_paid,
	                    'charge' => $charge,
	                ];

	                break;
	            case 'amount_paid':
	                $amount_paid = $amount;
	                $set_price1 = (1-$percent) * $amount_paid;

	                $set_price2 = ((1-$percent) * $amount_paid) - $constant;

	                //case 1
	                 $breakdown1 =  ($this->breakDownOn($set_price1));
	                 if ($breakdown1['amount_paid'] == $amount_paid) {
	                        $correct_set_price = $breakdown1['set_price'];
	                        $breakdown = $breakdown1;
	                 }

	                //case 2
	                 $breakdown2 =  ($this->breakDownOn($set_price2));
	                 if ($breakdown2['amount_paid'] == $amount_paid) {
	                        $correct_set_price = $breakdown2['set_price'];
	                        $breakdown = $breakdown2;
	                 }


	                $breakdown =  [
	                    'set_price' => $correct_set_price,
	                    'amount_paid' => $amount_paid,
	                    'charge' => $breakdown['charge'],
	                ];

	                break;

	            default:
	                # code...
	                break;
	        }

	        $breakdown = array_map(function($number){
	            return round($number, 2);
	        }, $breakdown);

	        return $breakdown;
	    }






	public function amountPayable()
	{
		$breakdown = $this->shop->paymentBreakdown();

		$amount = $breakdown['total_payable']['value'];

		return $amount;
	}


	public function initializePayment()
	{

		$payment_method = $this->name;

		$order_ref = $this->order->generateOrderID();

		$amount = $this->amountPayable();


		$user = $this->order->user;
		$success_url = "";
		$failure_url = "";


		$domain = Config::domain();
		$callback_param = http_build_query([
			'item_purchased'=> $this->order->name_in_shop,
			'order_unique_id'=> $this->order->id,
		]);

		$callback_url = "{$domain}/shop/callback?$callback_param";




		$payment_details = [
						'gateway' => $this->name,
						'ref' => $order_ref,
						'order_unique_id' => $this->order->id,
						'name_in_shop' => $this->order->name_in_shop,
						'email' => $user->email,
						'phone' => $user->phonenumber,
						'currency' => 'NGN',
						'amount' => $amount,
						'custom_fields'=> [
									[
										'metaname' => "Full Name",
										'metavalue' => $user->fullname,
									],
									[
										'metaname' => "Phone",
										'metavalue' => $user->phonenumber,
									],
								],
						'success_url' => $success_url,
						'failure_url' => $failure_url,
						'callback_url' => $callback_url,
						];

		$this->order->setPayment($payment_method , $payment_details);
		return $this;

	}

	public function attemptPayment()
	{


		if ($this->order->is_paid()) {
			throw new Exception("This Order has been paid with {$this->order->payment_method}", 1);
		}


		if ($this->order->payment_method != $this->name) {
			throw new Exception("This Order is not set to use {$this->name} payment method", 1);
		}


		$payment_details = json_decode($this->order->payment_details, true);

		$payment_details['api_keys'] = $this->api_keys['public_key'];


		return $payment_details;

	}



}
