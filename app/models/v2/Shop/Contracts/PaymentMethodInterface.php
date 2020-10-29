<?php

namespace v2\Shop\Contracts;
use v2\Shop\Contracts\OrderInterface;


interface PaymentMethodInterface{

		public function initializePayment();	
		public function attemptPayment();	
		public function verifyPayment();	
		public function setOrder(OrderInterface $order);
		// public function amountPayable(OrderInterface $order);



}