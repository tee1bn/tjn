<?php


namespace v2\Shop\Payments\Paypal;
use v2\Shop\Payments\Paypal\PayPal as cPaypal; //custom Paypal


use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;



use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;







use v2\Shop\Contracts\OrderInterface;
use Exception, SiteSettings, Config, MIS, Redirect;
/**
 * 
 */
class Subscription  extends cPaypal{

	private $plan ;
	private $paymentDefinition ;
	private $chargeModel ;
	private $merchantPreferences ;
	private $request ;
	private $planList ;
	private $subscriptionPlan ;

	public function __construct()
	{


		parent::__construct();
	}

	public function setOrder($order)
	{
		$this->order = $order;
		return $this;
	}


	public function createSubscriptionPlan($subscriptionPlan=null)
	{

		$this->subscriptionPlan = $subscriptionPlan;

		$this->plan = new Plan();

		$this->plan->setName($subscriptionPlan->package_type)
		    ->setDescription('Package')
		    ->setType('fixed');


		    $this->setPaymentDefinition();
		    $this->setChargeModel();
		    $this->setMerchantPreferences();
		    $subscription =  $this->CreateRequest();
		    $subscription_id = current((array)$subscription)['id'];

		    return $this->activatePlan($subscription_id);

		return;


		// print_r($this);
	}



	public function setPaymentDefinition($definition = null)
	{
		$this->paymentDefinition = new PaymentDefinition();
		$this->paymentDefinition->setName('Regular Payments')
		    ->setType('REGULAR')
		    ->setFrequency('Month')
		    ->setFrequencyInterval("1")
		    ->setCycles("12")
		    ->setAmount(new Currency(array('value' => $this->subscriptionPlan->PriceBreakdown['set_price'],
		    											 'currency' => parent::$currency)));


	}


	public function setChargeModel($charge_model = null)
	{

		$this->chargeModel = new ChargeModel();
		$this->chargeModel->setType('TAX')
		    ->setAmount(new Currency(array('value' => $this->subscriptionPlan->PriceBreakdown['tax'], 'currency' => parent::$currency)));

		$this->paymentDefinition->setChargeModels(array($this->chargeModel));

	}



	public function setMerchantPreferences($perferences=null)
	{

		$this->merchantPreferences = new MerchantPreferences();
		$domain = Config::domain();



		$success = http_build_query([
			'item_purchased'=> $this->order->name_in_shop,
			'order_unique_id'=> $this->order->id,
			'success'=> 'true',
		]);


		$failure = http_build_query([
			'item_purchased'=> $this->order->name_in_shop,
			'order_unique_id'=> $this->order->id,
			'success'=> 'false',
		]);


		$success_url = "{$domain}/shop/execute_agreement?$success";
		$failure_url = "{$domain}/shop/execute_agreement?$failure";





		$this->merchantPreferences->setReturnUrl($success_url)
		    ->setCancelUrl($failure_url)
		    ->setAutoBillAmount("yes")
		    ->setInitialFailAmountAction("CONTINUE")
		    ->setMaxFailAttempts("0")
		    ->setSetupFee(new Currency(array('value' => 0, 'currency' => parent::$currency)));

		    $this->plan->setPaymentDefinitions(array($this->paymentDefinition));
		    $this->plan->setMerchantPreferences($this->merchantPreferences);

		    $this->request = clone $this->plan;
	}



	public function CreateRequest()
	{
		try {

		    $this->output = $this->plan->create($this->apiContext);



		} catch (PayPal\Exception\PayPalConnectionException $ex) {
			// print_r("Created Plan", "Plan", null, $this->request, $ex);
			print_r($this->request);
			print_r($ex->getMessage());
			exit(1);
		}

		return $this->output;
	}


	public function listPlan()
	{

		try {
			
		    $params = array('page_size' => '20');
		    $this->planList = Plan::all($params, $this->apiContext);

		    return $this->planList;
		} catch (Exception $ex) {

		}
	}


	public function getPlan($plan_id)
	{
		
		try {

			$this->plan = Plan::get($plan_id, $this->apiContext);
		    return $this->plan;
		} catch (Exception $ex) {

		}		 
	}


	public function activatePlan($plan_id)
	{

		try {
			 	$this->patch = new Patch();

			    $value = new PayPalModel('{
				       "state":"ACTIVE"
				     }');

			    $this->patch->setOp('replace')
			        ->setPath('/')
			        ->setValue($value);

			    $this->patchRequest = new PatchRequest();
			    $this->patchRequest->addPatch($this->patch);

			    $createdPlan = $this->getPlan($plan_id);

			    $createdPlan->update($this->patchRequest, $this->apiContext);

			    $this->plan  = Plan::get($createdPlan->getId(), $this->apiContext);

			    return $this->plan;
			
		} catch (Exception $e) {
			
		}
	}
}

