<?php

namespace Filters\Traits;



use League\Csv\Writer;
use League\Csv\Reader;
use League\Csv\Statement;




trait CSVExportable
{





	public static function export_to_csv(array $ids)
	{

		$records =	self::csv_structure($ids);

		$csv = Writer::createFromFileObject(new \SplTempFileObject());

		//we insert the CSV header
		$csv->insertOne($records['header']);

		// The PDOStatement Object implements the Traversable Interface
		// that's why Writer::insertAll can directly insert
		// the data into the CSV
		$csv->insertAll($records['csv_records']);

		// Because you are providing the filename you don't have to
		// set the HTTP headers Writer::output can
		// directly set them for you
		// The file is downloadable

		$csv->output("{$records['filename']}.csv");
	}							






}
