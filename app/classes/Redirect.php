<?php



/**
* 
*/
class Redirect
{

	public static function to($location = null)
	{


		if(substr($location, 0 , 7) == "http://"){

			 $location = "$location";

		}elseif(substr($location, 0 , 8) == "https://"){

			 $location = "$location";
		}else{

			 $location = Config::domain()."/$location";
		}




		if ($location) {
				if (is_numeric($location)) {
					
					switch ($location) {
						case '404':
							header('HTTP/1.0 404 page not found');
							break;
						
						default:
				
						break;
					}
				}



				



		ob_end_clean();
				header('Location:'. $location);
				exit();
		}


	}


	
	public static function back()
	{

		 $location = $_SERVER['HTTP_REFERER'];
			ob_end_clean();
				header('Location:'. $location);
				exit();

	}

	

}













