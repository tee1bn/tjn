<?php
require_once "app/controllers/home.php";

/**
* This is where all miscellaneous operational functions is done
*/
class MIS 
{
	




	public static function zipFiles($file_names,$archive_file_name,$file_path='')
	{
	    
	    //echo $file_path;die;
	    $zip = new ZipArchive();
	    //create the file and throw the error if unsuccessful
	    if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
	        exit("cannot open <$archive_file_name>\n");
	    }


	    //add each files of $file_name array to archive
	    $domain = Config::domain()."/";
	    foreach($file_names as $file)
	    {	
	    	$file_path = str_replace("$domain", "", $file);
	    	$handle = new Upload ($file_path);
	        $zip->addFile($file_path,  $handle->file_src_name);
	        //echo $file_path.$files,$files."
	    }

	    $zip->close();

	    // return;
	    //then send the headers to force download the zip file
	    header("Content-type: application/zip"); 
	    header("Content-Disposition: attachment; filename=$archive_file_name"); 
	    header("Pragma: no-cache"); 
	    header("Expires: 0"); 
	    readfile("$archive_file_name");
	    $zipped = new Upload($archive_file_name);
	    $zipped->clean();
	    exit;
	}
		
	public static function encode_for_url($string){
			return str_replace(' ', '-', $string);
	}

	
	public static function filter_note($showing, $of, $total_set, $sieve, $pass_mark=1)
	{
	    $note = "Showing $showing of $of ";
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

	public static  function formatSizeUnits($bytes)
	{

	    if ($bytes >= 1073741824) {
	        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
	    } elseif ($bytes >= 1048576) {
	        $bytes = number_format($bytes / 1048576, 2) . ' MB';
	    } elseif ($bytes >= 1024) {
	        $bytes = number_format($bytes / 1024, 2) . ' KB';
	    } elseif ($bytes > 1) {
	        $bytes = $bytes . ' bytes';
	    } elseif ($bytes == 1) {
	        $bytes = $bytes . ' byte';
	    } else {
	        $bytes = '0 bytes';
	    }

	    return $bytes;
	}



	public static function compile_email($core_msg) {
			$controller = new home;
			$message = $core_msg;
	        $my_message_template = $controller->buildView('emails/contact-message', compact('message'), true);
	    return $my_message_template;
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
	    $secret_key = '35hweefw434grsrgsre3';
	    $secret_iv = '1234567890123323';

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

	
	public static function money_format($string)
	{
		return number_format("$string",2);		
	}

public static function generate_form($data, $action, $button, $function='', $require_confirmation=false)
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

    if ($require_confirmation==true) {
    	$btn=  '<button type="button" onclick="$confirm_dialog = new DialogJS(submit_form, [this])"  class="btn btn-sm btn-secondary">'.$button.'</button>';

    }else{

    	$btn=  '<button type="submit"   class="btn btn-secondary">'.$button.'</button>';
    }

    $form = '';

    $form = <<<EOL

    <form style="display: inline;" id="q_form" $function_attribute class="ajax_form" method="post" action="$action">
    $inputs  
    $btn
    </form>

    <script>
      submit_form = function(btn){
        btn.parentNode.submit();
      }
      
    </script>

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



    public static 	function random_string( $length = 6 , $character_set = "alpha_numeric") {

    	switch ($character_set) {
    		case 'alpha_numeric':
			    $chars = "abcdefghijkmnpqrtwyz0123456789";
    			break;

    		case 'numeric':
			    $chars = "0123456789";
    			break;
    		
    		case 'alphabet':
			    $chars = "abcdefghijkmnpqrtwyz";
    			break;
    		
    		default:
    			# code...
    			break;
    	}
		    $password = substr(str_shuffle( $chars ), 0, $length);
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
			
				
			case 'weekly':
				$today = date("l");
				$weekday = date("l", strtotime($date));
				
				$l_weekday = strtolower($weekday);
             
				if ($today == $weekday) {


					$start_date = date("Y-m-d",strtotime("$date  $l_weekday"));

					$end_date = date("Y-m-d",strtotime("-1 day"));
				}else{
					$start_date = date("Y-m-d",strtotime("$date last $l_weekday"));

					$end_date = date("Y-m-d",strtotime("$date $l_weekday this week"));
					$end_date = date("Y-m-d",strtotime("$end_date -1 day"));
				}


				$range =  [
					'start_date' => $start_date,
					'end_date' => $end_date
				];

				break;
			
				


			default:
				# code...
				break;
		}

		return $range;
	}




	function ends_with($haystack, $needle) {
	    // search forward starting from end minus needle length characters
	    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}

	function starts_with($haystack, $needle){
	    $length = strlen($needle);
	    return (substr($haystack, 0, $length) === $needle);
	}




	public static function make_post($url, $post_data,  $header=[])
	{

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "$url");
		curl_setopt($ch, CURLOPT_POST, 1);
	


		if (count($header)>0) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}


		// In real life you should use something like:
		curl_setopt($ch, CURLOPT_POSTFIELDS, 
		         http_build_query($post_data));

		// Receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close ($ch);

		return $server_output;


 
	}


	public static function make_get($url,  $header=[])
	{

		$ch = curl_init($url);

		if (count($header)>0) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}

		// Receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


		 $result = curl_exec($ch);
		// $response = curl_getinfo($ch);

		curl_close ($ch);

		return $result;
	}





}