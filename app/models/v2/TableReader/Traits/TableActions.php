<?php

	namespace TableReader\Traits;
	use Illuminate\Database\Capsule\Manager as DB;
	use Session;

	trait TableActions{


		public static function delete_items($row_ids, $primary_key)
		{


			$query = self::whereIn($primary_key , $row_ids);
			$count = $query->count();
			if ($count < 1 ) {
				return ;
			}

			DB::beginTransaction();

			try {
				
				$query->delete();
				DB::commit();
				Session::putFlash("success","{$count} row(s) deleted");

			} catch (Exception $e) {
				DB::rollback();
				Session::putFlash("danger","Failed");
			}

			$status = true;
			return compact('status');
			
		}

	}