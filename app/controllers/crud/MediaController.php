<?php
use Illuminate\Database\Capsule\Manager as DB;


/**
 * 
*/
class MediaController extends controller
{


	public function __construct(){


		if (! $this->admin()) {

			$this->middleware('current_user')
				->mustbe_loggedin()
				->must_have_verified_email();
		}		
	}

	public function upload($type=null)
	{


		try {

					$directory = "uploads/media/$type";
					$file = $_FILES['upload'];
					$handle = new \Upload ($file);

						 echo $file_type = explode('/', $handle->file_src_mime)[0];

			                if (($handle->file_src_mime == 'application/pdf' ) ||($file_type == 'image' ) ) {

			                	$handle->Process($directory);
			                	$file_path = $directory.'/'.$handle->file_dst_name;

			                }else{
								Session::putFlash("danger","only .pdf and image format  is  allowed");
			                	throw new Exception("Only Pdf is allowed ", 1);
			                	
			                }

		}catch(Exception $e){

			print_r($e->getMessage());

		}


	}




}























?>