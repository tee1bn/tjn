<?php

namespace v2\Shop\Contracts;
/**
 * Class for order interface.
 * This represent anything collection of thing/things buyable
 * 
 */

interface OrderInterface{

	public function setPayment($payment_method,array $payment_details);
	public function create_order(array $cart);
	public function generateOrderID();
	public function is_paid();
	public function total_price();
	public function total_qty();
	public function mark_paid();
}