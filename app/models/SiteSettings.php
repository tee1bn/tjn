<?php


use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;

class SiteSettings extends Eloquent 
{
	
	protected $fillable = ['criteria',	'settings' , 'description', 'name'];
	
	protected $table = 'site_settings';



	public static function binary_daterange()
	{



		$settings = SiteSettings::all()->keyBy('criteria');
		$binary_bonus_settings = $settings['binary_bonus']->settingsArray;
		$cuts_on = $binary_bonus_settings['cuts_on'];
		$last_monday = date("Y-m-d", strtotime("last $cuts_on"));
		$daterange = MIS::date_range($last_monday, 'weekly', true);
		$daterange['start_date'] = "2020-01-01";

		return $daterange;
	}



	public function getsettingsArrayAttribute()
    {

		if ($this->settings == null) {
			
			return [];
		}
			
        return  json_decode($this->settings ,true);
    }



	public static function find_criteria($criteria)
	{

		if (is_array($criteria)) {

			return self::whereIn('criteria', $criteria)->get();
		}
		return self::where('criteria', $criteria)->first();
	}


	public static function payment_gateway_settings()
	{
		$payments_settings_keys = [/*'coinpay_keys', 'paypal_keys', 'livepay_keys'*/ 'website_bonus_keys'];

		return self::whereIn('criteria', $payments_settings_keys)->get();

	}



	public function delete_document($key)
	{
		$doc = json_decode($this->settings, true);
		$tobe_deleted = ($doc[$key]);
		unset($doc[$key]);

		DB::beginTransaction();

		try {
			

			$this->update(['settings' => json_encode($doc)]);

			DB::commit();
			Session::putFlash("success","{$tobe_deleted['label']} Deleted Successfully");
			return true;
		} catch (Exception $e) {
			DB::rollback();
			Session::putFlash("danger","Could not delete ");
			return false;
		}

		



		header("content-type:application/json");

		echo json_encode(compact('response'));


	}



	public  function upload_documents($files)
	{
		$directory = 'uploads/admin/documents';


		 $documents = json_decode($this->settings, true);

		 if ($documents == "") {
		 	$documents = [];
		 }


		$i = 0;


		
		DB::beginTransaction();

		try {

			foreach ($files as $label => $file) {

				$handle = new Upload ($file);



					$file_type = explode('/', $handle->file_src_mime)[0];

		                if (($handle->file_src_mime == 'application/pdf' ) ||($file_type == 'image' ) ) {

							$handle->file_new_name_body = "{$this->name} $label";

		                	$handle->Process($directory);
		                	$file_path = $directory.'/'.$handle->file_dst_name;

								$new_file[$i]['files'] = $file_path;
								$new_file[$i]['label'] = $label;
								$new_file[$i]['category'] = $file['category'];

								

								array_unshift($documents, $new_file[$i]);
		                }else{

							Session::putFlash("danger","only .pdf format allowed");
		                	throw new Exception("Only Pdf is allowed ", 1);
		                	
		                }
		                $i++;
			}



				$this->update([
						'settings'=> json_encode($documents)
					]);

			DB::commit();
			Session::putFlash("success","Documents Uploaded Successfully");
		} catch (Exception $e) {
			DB::rollback();
			Session::putFlash("danger","Documents Uploaded Failed.");
			
		}

		return ($documents);


	}




	public static function documents_settings()
	{
		$settings = json_decode(self::where('criteria', 'documents_settings')->first()->settings, true);
		return $settings;

	}

	public static function site_settings()
	{
		$settings = json_decode(self::where('criteria', 'site_settings')->first()->settings, true);
		return $settings;

	}





	public static function commission_settings()
	{
		$settings = json_decode(self::where('criteria', 'commission_settings')->first()->settings, true);
		return $settings;

	}


	
	
	public static function pools_settings()
	{
		$settings = json_decode(self::where('criteria', 'pools_settings')->first()->settings, true);
		return $settings;

	}


	
	






	public static function company_account_details()
	{
		$settings = json_decode(self::where('criteria', 'admin_bank_details')->first()->settings, true);
		return $settings;

	}



	public static function coinpay_keys()
	{
		$settings = json_decode(self::where('criteria', 'coinpay_keys')->first()->settings, true);
		return $settings;

	}




	public static function paystack_keys()
	{
		$settings = json_decode(self::where('criteria', 'paystack_keys')->first()->settings, true);
		return $settings;

	}



	public static function sms_api_keys()
	{
		$settings = json_decode(self::where('criteria', 'sms_api_keys')->first()->settings, true);
		return $settings;

	}






	public function getsettingsAttribute($value)
    {

		if ($value == null) {
			
			return json_encode([]);			
		}
		// return json_decode($value , true);
	
        return json_encode( json_decode($value ,true));
    }








}
?>
