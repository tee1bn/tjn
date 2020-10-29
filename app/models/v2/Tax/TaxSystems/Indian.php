<?php

namespace v2\Tax\TaxSystems;

use v2\Tax\Contracts\TaxSystemInterface;
use v2\Shop\Contracts\OrderInterface;
use Exception, SiteSettings;
/**
 * 
 */
class Indian 
{	

	private $product;
	private $buyer;
	private $amount_taxable;
	private $amount;
	private $settings;
	private $tax_style = 'tax_inclusive';


	public function __construct(){

		$this->settings = SiteSettings::find_criteria('indian_tax');

	}


	public function __get($property_name)
	{
		return $this->$property_name;
	}


	public function setLocation(array $location)
	{
		$compulsory_keys = ['city', 'country'];

		$conforms =  array_intersect($compulsory_keys, $location) == $compulsory_keys;

		if (! $conforms) {
			throw new Exception("Location must have keys". print_r($compulsory_keys), 1);
		}

		$this->location = $location;

	}


	public function setProduct($product)
	{
		$this->product = $product;
		return $this;
	}

	public function setBuyer($user)
	{
		$this->buyer = $user;
		return $this;
	}

	public function setTaxStyleOnPrice($style)
	{	
		$styles = ['tax_inclusive', 'tax_exclusive'];

		if (! in_array($style, $styles)) {
			throw new Exception("Style not allowed", 1);
			return;
		}

		$this->tax_style = $style;
		return $this;
	}


	public function setAmount($amount)
	{
		$this->amount = $amount;
		return $this;
	}

	private function getAmount()
	{
		if (isset($this->product)) {

			return $this->product->market_details()['price'];
		}
	

		return $this->amount;
	}


	public function calculateApplicableTax()
	{

		$supplier = $this->settings->settingsArray['supplier'];
		$set_price = $this->getAmount();

			die();

		if (($supplier['country'] == $this->buyer->country) &&  ($supplier['state'] == $this->buyer->state) ) {

			$applicable_tax  = $this->settings->settingsArray['in_supplier_location'];

		}else{

			$applicable_tax  = $this->settings->settingsArray['not_in_supplier_location'];

		}

		foreach ($applicable_tax as $key => $percent) {

				$tax = $percent * 0.01 * $set_price;
				$tax_array['component'][$key] = [	
									'percent' => $percent,
									'tax' => $tax,
									'name' => strtoupper($key),
							];
		}

		$total_percent_tax = array_sum(array_column($tax_array['component'], 'percent'));
		$tax_payable =  array_sum(array_column($tax_array['component'], 'tax'));


		switch ($this->tax_style) {
			case 'tax_exclusive':
				$tax_array['pricing'] = $this->tax_style;

				$tax_array['breakdown'] =  [
					'total_percent_tax' => $total_percent_tax,
					'set_price' => $set_price,
					'tax_payable' => $tax_payable,
					'total_payable' => $tax_payable + $set_price,
					'before_tax' => $set_price,

				];



				break;
			
			case 'tax_inclusive':

				$tax_array['pricing'] = $this->tax_style;

				$after_tax  = ($set_price * 100) / ($total_percent_tax + 100);
				$tax_payable = $total_percent_tax * 0.01 * $after_tax ;

				$tax_array['breakdown'] =  [
					'total_percent_tax' => $total_percent_tax,
					'set_price' => $set_price,
					'tax_payable' => $tax_payable,
					'total_payable' => $set_price,
					'before_tax' => $after_tax ,
				];

				break;
			
			default:
				# code...
				break;
		}


		foreach ($tax_array['breakdown'] as $key => $breakdown) {
			$tax_array['breakdown'][$key] = round($breakdown, 2);
		}
		
		$this->amount_taxable = $tax_array;


		return $this;
	}


}
