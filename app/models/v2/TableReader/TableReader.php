<?php

namespace TableReader;
use  Filters\QueryFilter;

/**
 * 
 */
class TableReader 
{
	
	function __construct()
	{
		# code...
	}

	public static function get_key($data, $string)
	{
		$keys = explode('.', $string);

		$item = $data;
		foreach ($keys as  $key) {

			if (strpos($key, '()') !== false) {

				$key = str_replace('()', '', $key);
				if (method_exists($item, $key)) {
					$item = $item->$key();
				}
				$item = $item;
			}else{

				$item = $item[$key];
			}
		}

		return $item;
	}


	public function perform()
	{
		$row_ids =  $_REQUEST['ids'];
		$action =  $_REQUEST['action'];
		$row_ids = collect($_REQUEST['rows'])->pluck($_REQUEST['primary_key'])->toArray();
		$model = $_REQUEST['model']['model'];
		$primary_key = isset($_REQUEST['model']['primary_key']) ? $_REQUEST['model']['primary_key'] : 'id';

		$items = $model::$action($row_ids, $primary_key);

		return $items;
	}



	public function initialize(QueryFilter $filter)
	{	

		$setup  = $_REQUEST['setup'];
		$model = $setup['model'];

		$per_page = $setup['per_page'];
		$page = $setup['page'];
		$skip = (($page -1 ) * $per_page) ;


		$query = $model;
		
		
		$query_data =	$query::take($per_page)->skip($skip);

		$data =  $query_data->Filter($filter)->get();  //filtered


		$table_data = $_REQUEST['table']['data'];

		foreach ($table_data as $table_datum) {
			$key = $table_datum['key'];
			$dig = $table_datum['dig'];

			foreach ($data as  $datum) {
				$datum->$key = self::get_key($datum , $dig);
			}
		}


		$total = $query_data->count();
		$showing = "Page $page showing {$data->count()} of $total";

		$response = compact('data', 'total', 'showing');

		return $response;

	}



}