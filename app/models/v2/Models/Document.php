<?php

namespace v2\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use  v2\Traits\Wallet;
use  Filters\Traits\Filterable;
use Illuminate\Database\Capsule\Manager as DB;
use Upload, Session;

class Document extends Eloquent 
{
	
	use Filterable;	

		protected $fillable = [
					'filename',	'category',	'description',	'path',	'size'
				];


	protected $table = 'documents';

	
	public static $categories = [
		'business-presentations'=>'Business Presentations',
		'tutorials'=>'Tutorials',
		'promotional-items'=>'Promotional Items',
		'digital-marketing'=>'Digital Marketing',
	];


	




	public static function upload_documents($files)
	{
		$directory = 'uploads/admin/documents';


	/*	 $documents = json_decode($this->settings, true);

		 if ($documents == "") {
		 	$documents = [];
		 }*/


		$i = 0;


		
		DB::beginTransaction();

		try {

			foreach ($files as $label => $file) {

				$handle = new Upload ($file);



					$file_type = explode('/', $handle->file_src_mime)[0];

		                if (($handle->file_src_mime == 'application/pdf' ) ||($file_type == 'image' ) ) {

							$handle->file_new_name_body = "$label";

		                	$handle->Process($directory);
		                	$file_path = $directory.'/'.$handle->file_dst_name;

								$new_file[$i]['files'] = $file_path;
								$new_file[$i]['label'] = $label;
								$new_file[$i]['category'] = $file['category'];

								
		                }else{

							Session::putFlash("danger","only .pdf format allowed");
		                	throw new \Exception("Only Pdf is allowed ", 1);
		                	
		                }
		                $i++;


				$document =	self::create([
						'filename'	=> $label,	
						'category'	=> $file['category'],	
						'description' => null,	
						'path'	=> $file_path,	
						'size' => null

					]);


			}



			DB::commit();
			Session::putFlash("success","Documents Uploaded Successfully");
		} catch (Exception $e) {
			DB::rollback();
			Session::putFlash("danger","Documents Uploaded Failed.");
			
		}

		return ($document);


	}




}


















?>