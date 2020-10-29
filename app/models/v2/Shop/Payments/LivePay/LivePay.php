<?php

namespace v2\Shop\Payments\LivePay;
use v2\Shop\Payments\LivePay\Withdrawal;
use v2\Shop\Contracts\OrderInterface;
use v2\Shop\Contracts\PaymentMethodInterface;
use Exception, SiteSettings, Config, MIS, Redirect, Session;

require_once('app/models/v2/Shop/Payments/LivePay/api/livepay_gateway.php');

/**
 * 
 */
class LivePay implements PaymentMethodInterface
{
	private $name = 'livepay';
	private $payment_type;
	private $mode;
	
	function __construct()
	{

		$settings = SiteSettings::find_criteria('livepay_keys')->settingsArray;

		$this->mode = $settings['mode']['mode'];

		$this->api_keys =  $settings[$this->mode];

		if ($this->mode == 'live') {

			$this->coin_symbol = 'BTC';
		}else{

			$this->coin_symbol = 'TBTC';
		}

	
	}



	public function initializeWithdrawal($withdrawal_request)
	{
		$withdrawal = new Withdrawal;
		$response =	$withdrawal->setWithdrawalRequest($withdrawal_request)
					->process();

		return $response;
	
	}


	public function setPaymentType($payment_type)
	{
		$this->payment_type = $payment_type;
		return $this;
	}





	public function goToGateway()
	{

		$payment_details = json_decode($this->order->payment_details , true);


		$callback_param = http_build_query([
			'item_purchased'=> $this->order->name_in_shop,
			'order_unique_id'=> $this->order->id,
			'payment_method'=> $this->order->payment_method,
		]);


		Redirect::to("shop/make_livepay_payment/?$callback_param");	
	}


	public function paymentStatus()
	{


		$callback_param = http_build_query([
			'apikey'=> $this->api_keys['public_key'],
		]);

	echo	$url = "https://gw17.livepay.io/gw/merchantpartials/?$callback_param";

		$response = MIS::make_post($url, [], []);

		echo "<pre>";
		print_r($response);

	}	


	public function reVerifyPayment()
	{
		$response = 		$this->paymentStatus();
		if ($response['STATUS'] == "TXN_SUCCESS") {

			if (($this->amountPayable() == $response['TXNAMOUNT'])) {

				$confirmation = ['status'=>true];
				$result = $_POST;

				return compact('result','confirmation');
			}

		}
		
		\Session::putFlash('danger', "Payment not seen");
	}





	public function verifyPayment()
	{
	
        echo "<pre>";
        print_r($_REQUEST);
/*        
        $myfile = fopen("livepay.txt", "w") or die("Unable to open file!");        
        $decoded = json_decode(base64_decode($_REQUEST['dataB64']), true);
        print_r($decoded);        
         foreach($_REQUEST as $key => $data){
                fwrite($myfile, "$key => $data \n");
        }
         foreach($_SERVER as $key => $data){            
                fwrite($myfile, "$key => $data \n");
        }
*/


		$api_secret = 'tauruscapital1234@@@'; //Your Merchant API Secret
		$api_secret = $this->api_keys['secret_key']; //Your Merchant API Secret

		if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
		                fwrite($myfile, 'IPN Mode is not HMAC');

					die('IPN Mode is not HMAC'); 
				} 
		     
				if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
					fwrite($myfile, 'No HMAC signature sent.');
		        	die('No HMAC signature sent.'); 
				} 
		     
				$request = file_get_contents('php://input'); 
				if ($request === FALSE || empty($request)) { 
					fwrite($myfile, 'Error reading POST data');
		        	die('Error reading POST data'); 
				} 
		         
				$hmac = hash_hmac("sha512", $request, trim($api_secret)); 
				if ($hmac != $_SERVER['HTTP_HMAC']) { 
					fwrite($myfile,'HMAC signature does not match' );
		        	die('HMAC signature does not match'); 
				} 

				// HMAC Signature verified at this point, load some variables. 
				$txn_id = $_POST['tx_id']; // Tx Id from Bitcoin Network
				$amount_f = floatval($_POST['amount_f']);  //Fiat Amount
				$amount_c = floatval($_POST['amount_c']);  //Crypto Amount
				$currency_symbol = $_POST['currency_symbol']; //Fiat Symbol
				$coin_symbol = $_POST['coin_symbol']; //Crypto Symbol
				$status = intval($_POST['status']); 
				$status_text = $_POST['status_text']; 
				$order_id = $_POST['order_id'];  
				$invoice = $_POST['invoice']; 
			
			//Compare the Ipn Values with the ones you saved on Database when generated the order_id if all is ok proceed


				$payment_details =$this->order->PaymentDetailsArray;

				if ($this->order->is_paid()) {
					die('IPN OK'); // With the message LivePay knows all is ok and will not send more callbacks with this order_id		
				}

				$livepay_order = $payment_details['approval'];

				if ($livepay_order['order_id'] != $order_id){
					fwrite($myfile, 'order_id fault');
					return false; 
				}

				if ($amount_c < $payment_details['amount_c'])
				 {
					fwrite($myfile, 'order_id amount_c');
					return false; 

				 }
				

				if ($payment_details['coin_symbol'] != $coin_symbol)
				 {
					fwrite($myfile, 'order_id amount_c');
					return false; 

				 }
				

			if ($status == 2) { 
				if($_POST['received_confirms'] >= 2) {
					//Save data/status on your Database


						$result = $_REQUEST;
						$confirmation = ['status'=>true];
						return compact('result','confirmation');	

						die('IPN OK'); // With the message LivePay knows all is ok and will not send more callbacks with this order_id		
					}
			}

			//Else

			die('IPN ERROR: Custom Message'); //A check got wrong.

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
				$callback_url = "https://tauruscapital.biz/shop/callback?$callback_param";


			

				$payment_details = [
								'gateway' => $this->name,
								'ref' => $order_ref,
								'order_unique_id' => $this->order->id,

								"coin_symbol" 	 => $this->coin_symbol,
								"currency_symbol"=> 'USD',
								"amount_f"=> number_format($this->amountPayable(), 2, '.', ''),
								"invoice_id"=> $this->order->InvoiceID,
								"fee_pay_by"=> 1,
								// "amount_c"=> 1.30,
								"ipn_url"=> $callback_url,
								];


				$response = livepay_api_call('genorderid',$payment_details,$this->api_keys['public_key'], $this->api_keys['secret_key']);  
				

				$payment_details['approval'] = json_encode($response['response']);

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
