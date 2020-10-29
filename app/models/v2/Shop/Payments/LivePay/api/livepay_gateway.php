<?php 



function CreateWithdrawal($amount, $currency, $system_currency, $address, $note, $private_key, $public_key) {   
        
        $req = array(
            'amount' => $amount,
            'currency' => $currency,            
            'address' => $address
        );
        if ($system_currency  != $currency) { // fiat converted to crypto
            $req["currency2"] = $system_currency;   
        }
        return livepay_api_caller('create_withdrawal', $req, $note, $private_key, $public_key);
    }

function livepay_api_caller($cmd, $req = array(), $note, $api_secret, $api_key) { 
     
    $req['version'] = 2; 
    $req['cmd'] = $cmd; 
    $req['key'] = $api_key; 
    $req['note'] = $note;
    $req['format'] = 'json';    

    $post_data = http_build_query($req, '', '&'); 
    $hmac = hash_hmac('sha512', $post_data, $api_secret); 
    static $ch = NULL; 
    if ($ch === NULL) { 
        $ch = curl_init('https://apic.livepay.io/api'); 
        curl_setopt($ch, CURLOPT_FAILONERROR, TRUE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,100); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    } 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-livepay-auth-hmac: '.$hmac)); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); 
        
    $data = curl_exec($ch);   
    curl_close($ch);
    return json_decode($data,true);

} 





function livepay_api_call($cmd, $req = array(), $api_key, $api_secret) { 

    // Set the API command and required fields 
    $req['version'] = 1;
    $req['key'] = $api_key;
    $req['format'] = 'json';

    // Generate the query string 
    $post_data = http_build_query($req, '', '&'); 

    // Calculate the HMAC signature on the POST data 
    $hmac = hash_hmac('sha512', $post_data, $api_secret);
 
    // Create cURL handle and initialize (if needed) 
    static $ch = NULL; 
    if ($ch === NULL) { 
        $ch = curl_init('https://gw17.livepay.io/gw/'.$cmd);

        curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
    } 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('x-livepay-auth-hmac:'.$hmac)); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); 

     
    // Execute the call and close cURL handle      
    $data = curl_exec($ch);   
	curl_close($ch);
    // Parse and return data if successful. 
    if ($data !== FALSE) { 
        if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) { 
            // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP 
            $dec = json_decode($data, TRUE, 512, JSON_BIGINT_AS_STRING); 
        } else { 
            $dec = json_decode($data, TRUE); 
        } 
        if ($dec !== NULL && count($dec)) { 
            return $dec; 
        } else { 
            // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message 
            return array('error' => 'Unable to parse JSON result ('.json_last_error().')'); 
        } 

    } else { 
        return array('error' => 'cURL error: '.curl_error($ch)); 
    } 
} 

?>
