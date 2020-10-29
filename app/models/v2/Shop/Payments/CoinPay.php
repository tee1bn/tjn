<?php

namespace v2\Shop\Payments;
use v2\Shop\Contracts\OrderInterface;
use v2\Shop\Contracts\PaymentMethodInterface;
use Exception, SiteSettings, Config, MIS, Redirect, Session;
/**
 * 
 */
class CoinPay implements PaymentMethodInterface
{
	private $name = 'coinpay';
	private $payment_type;
	private $mode;
	
	function __construct()
	{

		$settings = SiteSettings::coinpay_keys();

		$this->mode = $settings['mode']['mode'];

		$this->api_keys =  $settings[$this->mode];

		$urls =  [
			'test' => [],
			'live' => [
				'create_payment_page'=> "https://p.coinwaypay.com/w/register",
			],
		];

		$this->urls = $urls[$this->mode];
	}




	public function setPaymentType($payment_type)
	{
		$this->payment_type = $payment_type;
		return $this;
	}





	public function goToGateway()
	{
		$payment_details = json_decode($this->order->payment_details , true);
		Redirect::to($payment_details['approval_url']);	
	}



	public function verifyPayment()
	{
		                
		$dataBase64 = $_REQUEST['dataB64'];
		$transmittedSignature = $_REQUEST['signature'];
		$signatureKey = $this->api_keys['signature'];
		$calculatedSignature = base64_encode(hash_hmac('sha256', base64_decode($dataBase64), base64_decode($signatureKey), true));

        echo "<pre>";
        print_r($_REQUEST);
        
        $myfile = fopen("coinpay.txt", "w") or die("Unable to open file!");
       
        
        $decoded = json_decode(base64_decode($_REQUEST['dataB64']), true);
        
        print_r($decoded);
        
         foreach($decoded as $key => $data){
            
                fwrite($myfile, "$key => $data \n");

        }

            echo "here";

fclose($myfile);

		if(($transmittedSignature != $calculatedSignature) || ($decoded['successful'] != true)) {
			\Session::putFlash("danger", "we could not verify your payment.");
			    echo "not success";
			return false;
		}  
		
		  	if ($this->amountPayable() < $decoded['amount']) {
			\Session::putFlash("danger", "Invalid amount.");
			return false; // 
		}


		
	    if ($decoded['isTestnet'] == true ) {
			\Session::putFlash("danger", "Testnet not allowed.");
			return false; // 
		}


		
		//beyond this line is success give value

        			    echo "successfull";
        
        

		$result = $_REQUEST;
		$confirmation = ['status'=>true];
		return compact('result','confirmation');	
	}


	public function setOrder( $order)
	{
		$this->order = $order;
		return $this;

	}


	public function amountPayable()
	{
		$amount =  $this->order->total_tax_inclusive()['price_inclusive_of_tax'];

		return $amount;
	}

	private function makeOneTimePayment(){



				$payment_method = $this->name;

				$order_ref = $this->order->generateOrderID();

				$amount = $this->amountPayable();

				$user = $this->order->user;
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

								"walletId" 	 =>  $this->api_keys['wallet_id'],
								"referenceId"=>  $order_ref,
								"amount" 	 =>  $amount,
								"currency" 	 =>  "EUR",
								"successRedirectUrl" =>  $callback_url."&t=success",
								"failRedirectUrl" =>  $callback_url."&t=fail",
								"cancelRedirectUrl" =>  $callback_url."&t=cancel",
								];



				$formatted_authorization = ("{$this->api_keys['username']}:{$this->api_keys['password']}");
				$formatted_authorization = base64_encode($formatted_authorization);

				$headers = [

							"Content-Type"=>" application/json",
							"Authorization"=>" Basic $formatted_authorization",
							"Accept"=>" application/json",
					];

					$client = new \GuzzleHttp\Client();
					$options = [
					    'json' => $payment_details,
					    'headers' => $headers,
					   ]; 
					   
		    		$url =  $this->urls['create_payment_page'];
					$response = $client->post("$url", $options);
			

				$payment_details['approval_url'] = json_decode($response->getBody()->getContents(), true)['redirectUrl'];

				$this->order->setPayment($payment_method , $payment_details);

				return $this;

			
	}

	public function makeSubscriptionPayment()
	{
		Session::putFlash("danger", "$this->name is unable to process subscription(Automatic) based payment.");
		$this->order->setPayment($payment_method , $payment_details);

		return $this;
	}

	public function initializePayment()
	{	
		$actions = [
			'one_time' => 'makeOneTimePayment',
			'subscription' => 'makeSubscriptionPayment',
		];

		$method = $actions[$this->payment_type];

		return $this->$method();
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
	
		return $this;

	}

}
