<?php

	ob_start();
	class app
	{

		protected $controller = 'home';
		protected $method = 'index';
		protected $params = [] ;
		protected $user  ;
		
		public function __construct()
		{



		 	$url =  ($this->parse_url());
		 
			require_once 'router.php';



			if (! array_key_exists($url[0], $router)) {

				// echo "This url is not routed";
				// return;
			}



			 $controller_filename = $router["$url[0]"] ?? '';
			if(! file_exists('../app/controllers/'. $controller_filename .'.php')){

				// echo "This controller does not exist: $controller_filename";
				$controller_filename = 'home';

			}else{

			    $controller_class_name = @end(explode('/', $router["$url[0]"]));
			 	$this->controller = $controller_class_name;
			 	unset($url[0]);

			}

		 	require_once '../app/controllers/'.$controller_filename.'.php';



		 	$this->controller = new $this->controller($this->user);
			

			//check the controller method and call it
		 	if(isset($url[1])){

		 	 $url[1] = str_replace("-", "_", $url[1]);
		 		if(method_exists($this->controller, $url[1]))
		 		{

		 			$this->method =$url[1];
		 			unset($url[1]);
		 		}
		 	}


		 	



				//perform access control here		
			 	if ($this->controller->admin()) {

			 		$administrator = $this->controller->admin();
					Access::access_check_on($administrator);

			 	}

		 	$this->params = $url ? array_values($url): [];
		 	call_user_func_array([$this->controller , $this->method] , $this->params);
		}



		public function parse_url()
		{

			if(isset($_GET['url'])){
				
			 	$url=explode( '/' , filter_var( rtrim($_GET['url'] , '/') , FILTER_SANITIZE_URL) );
			 	return $url;
			}
		}
	}









	?>