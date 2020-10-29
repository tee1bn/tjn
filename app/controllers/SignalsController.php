<?php

use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\Signals;


class SignalsController extends controller
{

	public function __construct(){

	}	





	public function create()
	{
		$signal = Signals::create([
			'admin_id' => $this->admin()->id
		]);

		Redirect::to($signal->editLink);
	}



	public function edit($signal_id)
	{
		$signal = Signals::find($signal_id);

		if ($signal == null) {
			Redirect::back();
		}

		
		$this->view('admin/edit', compact('signal'));
	}
	

	public function update_signal($state=null)
	{

		echo "<pre>";

		$signal = Signals::find($_POST['signal_id']);

		$published_at= null;

		if ($state=='publish') {
			$published_at = date("Y-m-d H:i:s");
		}

		DB::beginTransaction();


		try {
			

			$signal->update([
				'detail' => json_encode($_POST['detail']),
				'published_at' => $published_at,
				'starts_at' => $_POST['starts_at'],
				'closes_at' => $_POST['closes_at']
			]);

			DB::commit();		
			Session::putFlash("success","Signal updated successfully")	;
		} catch (Exception $e) {
			
			DB::rollback();			
			Session::putFlash("danger","Something went wrong")	;
		}


		Redirect::back();

	}

	public function preview($signal_id)
	{

		$signal = Signals::find($signal_id);


		 $form =  $signal->html_form() ;



		if ($signal == null) {
			Redirect::back();
		}

		$this->view('preview', compact('signal'));
	}




	public function delete($signal_id)
	{

		$signal = Signals::find($signal_id);
		if ($signal == null) {
			Redirect::back();
		}

		DB::beginTransaction();

		try {
			
			$signal->delete();
			DB::commit();
			Session::putFlash("primary", "Deleted successfully");
		} catch (Exception $e) {
			DB::rollback();
			Session::putFlash("danger", "Something went wrong");
			
		}

			Redirect::back();
	}
	



	public function index()
	{
		echo "we are in signals";
	}

}























?>