<?php

namespace v2\Shop\Payments;
use v2\Shop\Contracts\OrderInterface;
use Exception, SiteSettings, Session;
/**
 * 
 */
class Rave 
{
	public $name = 'rave';
	private $mode;
	
	function __construct()
	{

		$settings = SiteSettings::find_criteria('flutter_wave_keys')->settingsArray;

		$this->mode = $settings['mode']['mode'];

		$this->api_keys =  $settings[$this->mode];
		
		//initate my keys and all
	}


	

	public function setShop($shop)
	{
		$this->shop = $shop;
		return $this;

	}



	public function setPaymentType($payment_type)
	{
		$this->payment_type = $payment_type;
		return $this;
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
        	Session::putFlash("danger", "we could not complete your payment.");
        	return false;
        }
        


        if ($chargeAmount != $this->amountPayable()) {
        	Session::putFlash("danger", "we could not complete your payment.");
        	return false;
        }
        

        if ($chargeCurrency != $this->order->paymentDetailArray['currency']) {
        	Session::putFlash("danger", "we could not complete your payment.");
        	return false;
        }



        if ($paymentStatus != 'successful') {
        	Session::putFlash("danger", "we could not complete your payment.");
        	return false;
        }




		//give value        
		$confirmation = ['status'=>true];
		return compact('result','confirmation');


	}

	public function setOrder(OrderInterface $order)
	{
		$this->order = $order;
		return $this;

	}


	public function amountPayable()
	{
		$amount = $this->order->total_price();

		return $amount;
	}


	public function initializePayment()
	{

		$payment_method = $this->name;

		$order_ref = $this->order->generateOrderID();

		$amount = $this->amountPayable();


		$user = $this->order->Buyer;

		$payment_details = [
						'gateway' => $this->name,
						'ref' => $order_ref,
						'order_unique_id' => $this->order->id,
						'name_in_shop' => $this->order->name_in_shop,
						'email' => $user->email,
						'phone' => $user->phone,
						'currency' => 'NGN',
						'amount' => $amount,
						'custom_fields'=> [
									[
										'metaname' => "Full Name",
										'metavalue' => $user->fullname,
									],
									[
										'metaname' => "Phone",
										'metavalue' => $user->phone,
									],
								],
						'success_url' => "",
						'failure_url' => "",
						];


		$this->order->setPayment($payment_method , $payment_details);

		return $this;

	}

	public function attemptPayment()
	{


		if ($this->order->is_paid()) {

			\Session::putFlash("info","This Order has been paid with");
			throw new Exception("This Order has been paid with {$this->order->payment_details}", 1);
		}


		if ($this->order->payment_method != $this->name) {
			throw new Exception("This Order is not set to use {$this->name} payment method", 1);
		}


		$payment_details = json_decode($this->order->payment_details, true);

		$payment_details['api_keys'] = $this->api_keys['public_key'];


		return $payment_details;

	}



}
