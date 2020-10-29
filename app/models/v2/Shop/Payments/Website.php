<?php

namespace v2\Shop\Payments;
use v2\Shop\Contracts\OrderInterface;
use v2\Shop\Contracts\PaymentMethodInterface;
use Exception, SiteSettings, Config, MIS, Session, LevelIncomeReport, Redirect;
use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\Earning;

/**
 * 
 */
class Website 
{
	private $name = 'website';
	
	function __construct()
	{


	}


	public function goToGateway()
	{
		Redirect::back();
	}



	public function paymentStatus()
	{

		return true;
	}



	public function reVerifyPayment()
	{
		$response = 		$this->paymentStatus();
		if ($response['STATUS'] == "TXN_SUCCESS") {

			if (($this->amountPayable() == $response['TXNAMOUNT'])) {

				if (!$this->order->is_paid()) {
					$this->order->mark_paid();

				}else{

					\Session::putFlash('success', "Payment successful");
				}

				return $response;
			}

		}
		
		\Session::putFlash('danger', "Payment not successful");
	}


	public function verifyPayment()
	{

		$confirmation = ['status'=>true];
		$result = [];
		return compact('result','confirmation');

	}


	public function setOrder(OrderInterface $order)
	{
		$this->order = $order;
		return $this;

	}


	public function amountPayable()
	{
		$amount =  $this->order->total_price();
		return $amount;
	}


	public function initializePayment()
	{

		$payment_method = $this->name;
		$order_ref = $this->order->generateOrderID();
		$amount = $this->amountPayable();



		$user = $this->order->user;
		$domain = Config::domain();

	
		$callback_param = http_build_query([
			'item_purchased'=> $this->order->name_in_shop,
			'order_unique_id'=> $this->order->id,
		]);

		$payment_details = [
						'gateway' => $this->name,
						'ref' => $order_ref,
						'order_unique_id' => $this->order->id,
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
			throw new Exception("This Order is not set to use {$this->name} payment menthod", 1);
		}



						$user  = $this->order->user;

						$cost = $this->amountPayable();
			       		$balance = $user->available_balance();
			       		$currency = Config::currency();
						DB::beginTransaction();

						try {

							if ($cost > $balance) {
								Session::putFlash('danger', "This payment method is used on commission earned by referring people. Right now you have insufficient balance:<b>$currency$balance</b>.<br> Earn more by referring people.");
								return;
							}

							$this->order->mark_paid();
							$ref = json_decode($this->order->payment_details , true)['ref'];


							$debit =Earning::createTransaction(
														'debit',
														$user->id,
														null,
														$cost,
														'completed',
														'bonus',
														$comment,
														null,
														$this->order->id
													);

							if (! $debit) {
								throw new Exception("Error Processing Request", 1);
							}

							DB::commit();
							\v2\Shop\Shop::empty_cart_in_session();
							Session::putFlash('success', "Order completed.");

					} catch (Exception $e) {
						DB::rollback();
						// print_r($e->getMessage());
					}

		$payment_details = json_decode($this->order->payment_details, true);

		return $payment_details;
	}



}
