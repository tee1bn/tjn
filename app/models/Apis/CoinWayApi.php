<?php

namespace Apis;

use Illuminate\Database\Capsule\Manager as DB;
use MIS , SiteSettings;
/**



*/
class CoinWayApi 
{

	private $per_page = 100;
	public $response = [];
	public $total_no ;


	public function __construct()
	{

		$this->settings = SiteSettings::site_settings();


		$this->url = "https://api.coinwaypay.com/api/supervisor/turnover";
		$this->api_key = $this->settings['coinway_sales_api_key'];

		$this->header = [
			$this->api_key
		];

	}



	public function setPeriod($start_date , $end_date)
	{
		$this->period =  [
			'start_date' => $start_date,
			'end_date' => $end_date,
		];

		return $this;

	}

	public function connect()
	{

		// connect with API
		$query_string = http_build_query([
			'from' 	=> $this->period['start_date'],
			'to' 	=> $this->period['end_date'],
		]);

		$url = "{$this->url}?$query_string";

		$response = json_decode( MIS::make_get($url, $this->header) , true);

		$this->total_no  = $response['totalCount'];


		$pages = ceil($this->total_no  /$this->per_page);

		for ($i=1; $i <= $pages ; $i++) { 
			$skip = ($this->per_page * ($i-1));


			$query_string = http_build_query([
				'from' 	=> $this->period['start_date'],
				'to' 	=> $this->period['end_date'],
				'top' 	=> $this->per_page,
				'skip' => $skip
			]);


		$response = json_decode( MIS::make_get($url, $this->header) , true);

		$this->response = array_merge($this->response, $response['value']);

		}


		return $this;

	}


	public function get_response()
	{
		return collect($this->response);
	}
	

	public function index()
	{
		# code...
	}
}
















?>