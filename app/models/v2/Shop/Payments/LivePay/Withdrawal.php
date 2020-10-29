<?php

namespace v2\Shop\Payments\LivePay;

use v2\Shop\Payments\LivePay\LivePay;
use v2\Shop\Contracts\OrderInterface;
use v2\Shop\Contracts\PaymentMethodInterface;
use Exception, SiteSettings, Config, MIS, Redirect, Session;

require_once('app/models/v2/Shop/Payments/LivePay/api/livepay_gateway.php');

/**
 * 
 */
class Withdrawal extends LivePay
{
	private $withdrawal_request;
	
	function __construct()
	{

		parent::__construct();
	}


	public function setWithdrawalRequest($withdrawal_request)
	{
		$this->withdrawal_request  = $withdrawal_request;
		return $this;
	}


	public function process()
	{

		$withdrawal_request = $this->withdrawal_request;



		/*
		Information required to withdraw money from your LivePay.io account
			  **Important** If you want to use LivePay to pay your members you need to allow API withdrawals on your LivePay Default Merchant account **Important**
		*/

		$public_key	 	= $this->api_keys['public_key']; //This key is your master public key, you can have multiple merchant/store public keys, for withdrawals is required the Default Merchant one **Important**
		$private_key		=  $this->api_keys['secret_key'];; //This key is your master private key, you can have multiple merchant/store private keys, for withdrawals is required the Default Merchant one **Important**
		
		$amount = $withdrawal_request->AmountToPay; //50$ USD will be converted to BTC
		$address = $withdrawal_request->withdrawal_method->DetailsArray['bitcoin_address']; // BTC address
		$system_currency		= 'USD'; // If your site run under fiat, put here the fiat 3 digit code, you can also put here BTC or other alt coin if your system works compleatly on crypto
		$currency			= 'BTC'; // The withdrawal crypto currency (You can send USD and livepay will do the conversion and send the respective BTC or alt coin you specify here to your member)
		
		$note = "$withdrawal_request->id "; //Any note message for future reference


		$result = CreateWithdrawal($amount, $currency, $system_currency, $address, $note, $private_key, $public_key);


		if ($result['error'] == 'ok') {
			$tx_id = $result['result']['id'];
			//Proceed saving on your database.


			$confirmation = ['status'=>true];
			return compact('result','confirmation');	


		} else {	
			$error = $result['error'];

			return  false;
		}	
		


	}

}
