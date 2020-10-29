<?php

require_once "../app/controllers/home.php";


/**
* This is where all miscellaneous operational functions is done
*/
class MIS 
{	

	public static function filter_note($showing, $of, $total_set, $sieve, $pass_mark=1)
	{
	    $note = "showing $showing of $of ";
	    if (self::is_sieve($sieve, $pass_mark)){
	        $note .="filtered from $total_set";
	    }
	    return $note;
	}

	public static  function is_sieve($sieve, $pass_mark = 1)
	{
	    if (isset($sieve['page'])) {
	        unset($sieve['page']);
	    }
	    unset($sieve['url']);
	    $count = count($sieve);

	    if ($count >= $pass_mark) {
	        return true;
	    }
	    return false;
	}



	public static function compile_email($core_msg) {
			$controller = new home;
			$message = $core_msg;
	        $my_message_template = $controller->buildView('emails/contact-message', compact('message'), true);
	    return $my_message_template;
	}



	/**
	 * Encrypt and Decrypt String
	 * @param $action
	 * @param $string
	 * @return bool|string
	 */
	public static function dec_enc($action, $string)
	{
	    $output = false;

	    $encrypt_method = "AES-256-CBC";
	    $secret_key = '35hdyetsga3b225c6c7ff136cd13b0ff';
	    $secret_iv = '1234567890123456';

	    // hash
	    $key = hash('sha256', $secret_key);

	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);

	    if ($action == 'encrypt') {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    } else if ($action == 'decrypt') {
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }

	    return $output;
	}



	public static function calculate_vat($amount)
	{

		$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;
		$vat_percent = $setting['vat_percent'];
		$vat = $vat_percent * 0.01 * $amount;

		

		$result =[
			'value' => $vat,
			'percent' => $vat_percent,
		];

		return $result;
	}


		
	public static function encode_for_url($string){
			return str_replace(' ', '-', $string);
	}
	
	public static function money_format($string)
	{
		return number_format("$string",2);		
	}

	public static function current_url($type='short')
	{
		$full_url =  @$_GET['url'];
		$main_url = explode("/", $full_url);
		array_splice($main_url, 2);

		$short_url =  implode($main_url, "/");

		$short_url = str_replace('-', '_', $short_url);

		$urls = [
			'full' =>  $full_url,
			'short' =>  $short_url
		];

		return $urls[$type];
	}


	public static function generate_form($data, $action, $button, $function='')
	{
	    $inputs = '';
	    foreach ($data as $key => $value) {
	        $inputs.= "<input type='hidden' name='$key' 
	        value='$value'> ";
	    }

	    if ($function == '' ) {
	        $function_attribute = '';
	    }else{

	        $function_attribute = "data-function='$function'";
	    }

	    $form = '';

	    $form = <<<EOL

	    <form style="display: inline;" id="q_form" $function_attribute class="ajax_form" method="post" action="$action">
	    $inputs  
	    <button type="submit" class="btn btn-outline-primary">$button </button>
	    </form>
EOL;
	                              
	    return $form;
	}


    public static function custom_mime_content_type($filename)
    {

    	if(function_exists('mime_content_type')&&$mode==0){ 
        $mimetype = mime_content_type($filename); 
        return $mimetype; 

		}elseif(function_exists('finfo_open')&&$mode==0){ 
		        $finfo = finfo_open(FILEINFO_MIME); 
		        $mimetype = finfo_file($finfo, $filename); 
		        finfo_close($finfo); 
		        return $mimetype; 
		}elseif(array_key_exists($ext, $mime_types)){ 
		        return $mime_types[$ext]; 
		}else { 
		        return 'application/octet-stream'; 
		} 


    }





	public static function date_range($date, $duration="month" , $strict=false)
	{
		$explode = explode("-", $date);
		$year = @$explode[0];
		$month = @$explode[1];
		$day =  @$explode[2];


		switch ($duration) {
			case 'month':
				$today = date("Y-m");
				$year_month = "$year-$month";
				if (($today == $year_month) && ($strict==false)) {
					$end_date = date("Y-m-d");
				}else{
					$end_date = date("$year-$month-t");
				}

				$range =  [
					'start_date' => date("$year-$month-01"),
					'end_date' => $end_date
				];

				break;

			case 'year':
				$today = date("Y");
				if (($today == $year) && ($strict==false)) {
					$end_date = date("Y-m-d");
				}else{
					$end_date = date("$year-12-t");
				}

				$range =  [
					'start_date' => date("$year-01-01"),
					'end_date' => $end_date
				];

				break;
			

			case 'week':
				 $today = date("l");
             

				 $weekday = date("l", strtotime($date));

				if (($today == $weekday) && ($strict==false)) {
					$end_date = date("Y-m-d",strtotime("$today this week"));
				}else{
					$end_date = date("Y-m-d",strtotime("$date sunday this week"));
				}

				$range =  [
					'start_date' => date("Y-m-d",strtotime("$date monday this week")),
					'end_date' => $end_date
				];

				break;
			
				


			default:
				# code...
				break;
		}

		return $range;
	}





    public static function use_google_recaptcha()
    {

    	    $settings = SiteSettings::site_settings();
    	    $key = $settings['google_re_captcha_site_key'];
    	    
    	    $recaptcha = <<<EOL
    	    <div class="g-recaptcha form-group" data-sitekey="$key">
    	    </div>
EOL;

    	    return $recaptcha;
    }

	
	public static function verify_google_captcha()
	{
			$domain =Config::domain();
			if (strpos($domain, '.') == false) {
			    return true;
			}


		 	$settings = SiteSettings::site_settings();		 	
			$post_data =  [
							'secret'=> $settings['google_re_captcha_secret_key'],
							'response'=> $_POST['g-recaptcha-response'],
						];
    			$response = self::make_post("https://www.google.com/recaptcha/api/siteverify", $post_data);


			$csrf =  (json_decode($response, true));
					
			if(($csrf['success'] != 1) || ($csrf['hostname'] != $_SERVER['HTTP_HOST'])){
			    Session::putFlash('warning', "Please solve the captcha");
			    Redirect::back();
			}

	}



    public static 	function random_string( $length = 6 ) {
		    $chars = "abcdefghijkmnpqrtwyz123456789";
		    $password = substr( str_shuffle( $chars ), 0, $length );
		    return $password;
	}


	public static function refine_multiple_files($files)
	{


		foreach ($files as $attribute => $attributes) {
			foreach ($attributes as $key => $value) {
				$refined_file[$key][$attribute] = $value;
			}

		}

		return $refined_file;

	}



	public static function make_post($url, $post_data=[], $header=[])
	{
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, "$url");
	    curl_setopt($ch, CURLOPT_POST, 1);


	    // In real life you should use something like:
	    curl_setopt($ch, CURLOPT_POSTFIELDS, ($post_data));

	    if (count($header) > 0) {
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	    }

	    // Receive server response ...
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $server_output = curl_exec($ch);


	    curl_close($ch);

	    return $server_output;
	}

	public static function make_get($url, $header = [])
	{
	    $ch = curl_init($url);

	    if (count($header) > 0) {
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	    }

	    // Receive server response ...
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $result = curl_exec($ch);



	    curl_close($ch);
	    return $result;
	}



}