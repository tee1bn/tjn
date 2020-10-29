<?php

/**
* 
*/
class Validator
{	
	private $_errors,
	$_passed = false;



	
	public function check($data, $items)
	{
// echo "<pre>";

		foreach ($items as $item => $rules) {

			foreach ($rules as $rule => $rule_value) {

					// echo "$item must be $rule $rule_value<br>";
					//rule definitions of

				$value = trim($data["$item"]);

				if ($rule === 'required' && empty($value)) {
					
					$this->addError($item, "$item is required");
				}else if(! empty($value)){

					switch ($rule) {
						case 'min':

						(strlen($value) < $rule_value)? $this->addError($item, "$item cannot be less than $rule_value characters."):'' ;


						break;
						case 'max':

						(strlen($value) > $rule_value)? $this->addError($item, "$item cannot be more than $rule_value characters."):'' ;
						break;

						case 'min_age':
						$birth_year = date("Y", strtotime($value));
						$diff = date("Y") - $birth_year;
						(($diff) < $rule_value)? $this->addError($item, "You must be at least $rule_value years."):'' ;




						break;

						case 'min_value':

						(($value) < $rule_value)? $this->addError($item, "$item cannot be less than $rule_value."):'' ;


						break;

						case 'max_value':

						(($value) > $rule_value)? $this->addError($item, "$item cannot be more than $rule_value."):'' ;


						break;

						case 'equals':

						(($value) != $rule_value)? $this->addError($item, "$item does not match records."):'' ;


						break;

						case 'step':

						(($value % $rule_value) !== 0 )? $this->addError($item, "$item should be in steps of $rule_value."):'' ;


						break;


						case 'no_special_character':

						if (preg_match('/[\'^£$%&*()}{@#~?><>,|\.=_+¬-]/', $value))
						{
							    // one or more of the 'special characters' found in $string
							$this->addError($item, "$item cannot contain special characters.");
						}

						break;

						case 'one_word':
						str_word_count($value, $number_of_word);
						$number_of_word = substr_count(trim($value), ' ');
						if ($number_of_word > 0)
						{
							$this->addError($item, "$item must be one word.");
						}

						break;



						case 'email':

						if ( !filter_var($value, FILTER_VALIDATE_EMAIL) === true) {

							$this->addError($item, "$item is not valid.");
						}

						break;



						case 'date':
						$d = DateTime::createFromFormat($rule_value, $value);
						    // The Y ( 4 digits year ) returns TRUE for any integer with any number 
						    // of digits so changing the comparison from == to === fixes the issue.

						if($d && ($d->format($rule_value) === $value)) {
						}else{
							$this->addError($item, "$item is not valid.");
						}


						break;
						
						case 'url':

						if ( !filter_var($value, FILTER_VALIDATE_URL) === true) {

							$this->addError($item, "$item is not valid.");
						}

						break;
						case 'numeric':

						if ( ! ctype_digit($value)) {

							$this->addError($item, "$item must be numeric.");
						}

						break;

						case 'positive':

						if ($value < 0) {

							$this->addError($item, "$item must be greater than 0.");
						}

						break;

						

						case 'unique':
						if( $rule_value::where($item ,$value)->first()){
							$this->addError($item, "$item already exist.");
						}
						break;


						case 'exist':

						$model  = explode('|' ,$rule_value)[0];
						$column  = explode('|' ,$rule_value)[1];

						if( $model::where($column ,$value)->first() == null){
							$this->addError($item, "$item does not exist.");
						}
						break;




						case 'replaceable':

						$model  = explode('|' ,$rule_value)[0];
						$id  = explode('|' ,$rule_value)[1];

						$id_column =  explode('|' ,$rule_value)[2] ?? 'id';


						if( $model::where($item ,$value)->where($id_column, '!=', $id)->first()){
							$this->addError($item, "$item is already taken.");
						}
						

						break;
						case 'matches':

						if ($value != $data["$rule_value"]) {

							$this->addError("$rule_value", "{$rule_value}s do not match.");
						}

						break;

						case 'not match':

						if ($value === $data["$rule_value"]) {

							$this->addError("$item", "{$item} cannot match {$rule_value}.");
						}

						break;
						
						default:
							# code...
						break;
					}


				}



			}




		}

		if ($this->_errors =='') {
			
			$this->_passed = true;
		}

		return false;
	}




	public function addError($field, $error)
	{
		$this->_errors["$field"][] = $error;
		Session::put('inputs-errors', $this->_errors);

	}	


	public function passed()
	{

		if ($this->_errors =='') {
			
			return  true;
		}

		return false;
	}


	public function errors()
	{
		return $this->_errors;
	}



}






