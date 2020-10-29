<?php

namespace v2\Shop\Payments;
use v2\Shop\Contracts\OrderInterface;
use v2\Shop\Contracts\PaymentMethodInterface;
use Exception, SiteSettings;
/**
 * 
 */
class Paystack  implements PaymentMethodInterface
{
	private $name = 'paystack';
	private $mode;
	private $shop;
	
	function __construct($shop)
	{

		$this->shop = $shop;
		$settings = SiteSettings::find_criteria('paystack_keys')->settingsArray;

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
				
			
	/*		$confirmation = ['status'=>true];
			return compact('result','confirmation');

	*/		
		
					$payment_details = json_decode($this->order->payment_details, true);
					$reference = $payment_details['ref'];

					$result = array();
					//The parameter after verify/ is the transaction reference to be verified
					$url = "https://api.paystack.co/transaction/verify/$reference";

					$secret_key = $this->api_keys['secret_key'];

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt(
					  $ch, CURLOPT_HTTPHEADER, [
					    "Authorization: Bearer $secret_key"]
					);
					$request = curl_exec($ch);
					curl_close($ch);

					if ($request) {
					    $result = json_decode($request, true);
					    // print_r($result);
					    if($result){
					      if($result['data']){
					        //something came in
					        if($result['data']['status'] == 'success'){
					          // the transaction was successful, you can deliver value
					          /* 
					          @ also remember that if this was a card transaction, you can store the 
					          @ card authorization to enable you charge the customer subsequently. 
					          @ The card authorization is in: 
					          @ $result['data']['authorization']['authorization_code'];
					          @ PS: Store the authorization with this email address used for this transaction. 
					          @ The authorization will only work with this particular email.
					          @ If the user changes his email on your system, it will be unusable
					          */

					   
					                     if($this->amountPayable()  == $result['data']['amount']){

					                     		$confirmation = ['status'=>true];
					                     		return compact('result','confirmation');
					                    }




					        }else{
					          // the transaction was not successful, do not deliver value'
					          // print_r($result);  //uncomment this line to inspect the result, to check why it failed.
					          echo "Transaction was not successful: Last gateway response was: ".$result['data']['gateway_response'];


					        }
					      }else{
					        echo $result['message'];
					      }

					    }else{
					      //print_r($result);
					      die("Something went wrong while trying to convert the request variable to json. Uncomment the command to see what is in the result variable.");
					    }
					  }else{
					    var_dump($request);
					    die("Something went wrong while executing curl. Uncomment the var_dump line above this line to see what the issue is. Please check your CURL command to make sure everything is ok");
					  }


					  Session::putFlash("danger", "we could not verify your payment.");

			

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

        $constant = 100;
        $percent = 1.5 * 0.01;
        $cut_off = 2500;
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

		$number = $breakdown['total_payable']['value'];
		$amount = 100  * round((float)$number,2);

		return (int)$amount;
	}


	public function initializePayment()
	{

		$payment_method = $this->name;

		$order_ref = $this->order->generateOrderID();

		$amount = $this->amountPayable();

		$user = $this->order->user;
		$payment_details = [
						'gateway' => $this->name,
						'ref' => $order_ref,
						'order_unique_id' => $this->order->id,
						'name_in_shop' => $this->order->name_in_shop,
						'email' => $user->email,
						'currency' => 'NGN',
						'amount' => $amount,
						'custom_fields'=> [
									[
										'display_name' => "Full Name",
										'variable_name' => 'name',
										'value' => $user->fullname,
									],
									[
										'display_name' => "Phone",
										'variable_name' => 'phone',
										'value' => $user->phonenumber,
									],
								],
						'success_url' => '',
						'failure_url' => '',
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
			throw new Exception("This Order is not set to use paystack payment method", 1);
		}


		$payment_details = json_decode($this->order->payment_details, true);

		$payment_details['api_keys'] = $this->api_keys['public_key'];


		return $payment_details;

	}



}
