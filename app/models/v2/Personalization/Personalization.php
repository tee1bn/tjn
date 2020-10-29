<?php


use Personalization\Traits\Placeholder;

/**
 * 
 */
class Personalization 
{

	use Placeholder;
	
	private $content ;

	private $output ;

	public $context;

	public $user ;


	function __construct()
	{
		# code...
	}


	public function addMap(array $map)
	{
		foreach ($map as $key => $value) {

			$this->register[$key] = [
				'value' => $value
			];

		}

		return $this;
	}

	public function setContent($content)
	{
		$this->content = $content;
		return $this;
	}

	public function setUser($user)
	{
		$this->user = $user;
		return $this;
	}

	public function personalise()
	{

		$content = $this->content;

		foreach ($this->register as $placeholder => $substitution) {
			$function = str_replace('[', '' ,$placeholder );
			$function = str_replace(']', '' ,$function);

			if (isset($substitution['value'])) {
				$content = str_replace($placeholder, $substitution['value'], $content);
				continue;
			}


			if (method_exists($this, $function)) {

				$substitute = $this->$function();

			}else{

				$substitute = isset($substitution['value']) ? $substitution['value']: $placeholder;
			}


			$content = str_replace($placeholder, $substitute, $content);
		}


		$this->output = $content;
		return $this;
	}


	public function getOutput()
	{

		return $this->output;
	}


}











