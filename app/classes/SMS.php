<?php

/**
* 
*/
class SMS 
{
	protected $api_username;
	protected $api_password;
	protected $api_link;
	protected $sender;
	
	public function __construct()
	{
		
			$this->api_link = '';
			$this->api_username = 'nsv9-dmc1';
			$this->api_password = 'dmc1234';
			$this->sender = $this->name;


	}




	public   function send_sms($phone ,$message, $sender= 'Activation')
	{
			
$message = urlencode($message);


        $parse_url = file_get_contents("http://rslr.connectbind.com/bulksms/bulksms?username=nsv9-keeper&password=A12345&type=0&dlr=0&destination=".$phone."&source=".$sender."&message=".$message."");
        
        print_r($parse_url);


	}


	

}