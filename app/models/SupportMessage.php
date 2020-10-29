<?php


use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;

class SupportMessage extends Eloquent 
{
	
	protected $fillable = [
							'ticket_id',
							'message',
							'admin_id',
							'user_id',
							'documents',
							'status'
						];
	
	protected $table = 'cs_support_messages';
	protected $connection = 'default';





	public function getattachmentsAttribute()
	{

		$dropdown = "";

		 if (count($this->documents) > 0) {

			$list ="";
			foreach ($this->documents as $file) {
				$host = \Config::domain()."/{$file['files']}";
				$host = str_replace('public_html/', '', $host);

				$list .="<a class='dropdown-item' target='_blank' href='$host'>{$file['label']}</a>";
			}
		
			$dropdown =     '
							<div class="dropdown" style="margin-left: 10px;">
                                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                  <span class="fa fa-clipboard"></span></button>
                                  <ul class="dropdown-menu">
                                  	'.$list.'
                                  </ul>
                                </div>';
		}

		
          return $dropdown;
	}



	public function supportTicket()
	{
			return $this->belongsTo('supportTicket', 'ticket_id');
	}


	public function admin()
	{
			return $this->belongsTo('Admin', 'admin_id');
	}
	
	public function client()
	{
			return $this->belongsTo('Clientele', 'user_id');
	}
	



	public function getdocumentsAttribute($value)
	{	
		if ($value == null) {
			
			return [];			
		}
		return json_decode($value , true);
	}


	public  function upload_documents($files = null)
	{
		$directory = 'uploads/support/documents';

		if ($files == null) {
			return;
		}


		$documents = $this->documents;
		$i = 0;

		DB::beginTransaction();

		try {

			foreach ($files as $label => $file) {

				$handle = new Upload ($file);

					$file_type = explode('/', $handle->file_src_mime)[0];

		                if (($handle->file_src_mime == 'application/pdf' ) ||($file_type == 'image' ) ) {


							// $handle->file_new_name_body = "{$this->name} $label";

		                	$label = $handle->file_src_name_body;

		                	$handle->Process($directory);
		                	$file_path = $directory.'/'.$handle->file_dst_name;

								$new_file[$i]['files'] = $file_path;
								$new_file[$i]['label'] = $label;

								array_unshift($documents, $new_file[$i]);

		                }else{

							// Session::putFlash("danger","only .pdf format allowed");
		                	throw new Exception("Only Pdf is allowed ", 1);
		                }

		                $i++;
			}

				$this->update([
						'documents'=> json_encode($documents)
					]);

			DB::commit();
			Session::putFlash("success","Documents Uploaded Successfully");
		} catch (Exception $e) {
			DB::rollback();
			Session::putFlash("danger","Documents Uploaded Failed.");
			
		}

		return ($documents);


	}





}


















?>