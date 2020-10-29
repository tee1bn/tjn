<?php

namespace v2\Tax;
use v2\Tax\TaxSystems\Indian;
use v2\Shop\Contracts\OrderInterface;

use Exception;
/**
 * 
 */
class Tax 
{
		
	private $amount_taxable;

	function __construct($argument = null)
	{
		$this->setup_tax_systems();

	}

	public function __get($property_name)
	{
		return $this->$property_name;
	}


	private function setup_tax_systems()
	{

		$this->available_tax_systems = [

				'indian_tax' => [
								'name' => 'Indian Tax',
								'class' => 'Indian',
								'namespace' => "v2\Tax\TaxSystems",
								'available' => true
							],
				'general_tax' => [
								'name' => 'General Tax',
								'class' => 'General',
								'namespace' => "v2\Tax\TaxSystems",
								'available' => true
							],
				

		];
	}




	public function setProduct($product)
	{
		$this->tax_system->setProduct($product);
		return $this;
	}
	
	public function setBuyer($user)
	{
		$this->tax_system->setBuyer($user);
		return $this;
	}

	public function setAmount($amount)
	{
		$this->tax_system->setAmount($amount);
		return $this;
	}

	public function setTaxStyleOnPrice($style)
	{
		$this->tax_system->setTaxStyleOnPrice($style);
		return $this;
	}



	public function calculateApplicableTax()
	{
		$this->tax_system->calculateApplicableTax();

		$this->amount_taxable = $this->tax_system->amount_taxable;

		return $this;
	}

	public function setTaxSystem($tax_system)
	{
		$system = $this->available_tax_systems[$tax_system];


		if ($system['available'] != true) {
			throw new Exception("{$system['name']} payment is not available s", 1);
		}


		$full_class_name = $system['namespace'].'\\'.$system['class'];

		$this->tax_system = new  $full_class_name;
		// $this->tax_system->setProduct($this->order);


		return $this;
	}

}