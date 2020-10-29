<?php
use v2\Models\UserBank;
use Illuminate\Database\Capsule\Manager as DB;

require_once "../app/controllers/home.php";


/**
 * 
*/


class AccessCrud extends controller
{

	public function __construct(){

	}


	public function update_admin_access()
	{
	
		$granted_access = array_keys($_POST['access']);
		DB::beginTransaction();

		try {
			

			AdminAccess::updateOrCreate([
											'admin_id' => $_POST['admin_id']
										],
										[

											'accesses'   => json_encode($granted_access),
											'updated_by' => $this->admin()->id
											
										]);

			Session::putFlash('success','Changes updated successfully');
			DB::commit();
		} catch (Exception $e) {
			Session::putFlash('danger','Somthing went wrong');
			DB::rollback();
		}

		Redirect::back();
	}

	public function delete_access($access_id)
	{


		$access = Access::find($access_id);
		if ($access != null) {

		 $access->delete();
			Session::putFlash('success', 'deleted succesfully');


		}


		Redirect::back();
	}


	public function create_access()
	{
		$access = Access::create([]);
		Redirect::to("admin/edit_access/{$access->id}");
	}

	public function update_access()
	{
		echo "<pre>";
		print_r($_POST);
		$access = Access::find($_POST['access_id']);
		if ($access == null) {

			Session::putFlash("danger","Invalid request");
			Redirect::back();
		}

		try {
			
			$access->update([
				'name'	=> $_POST['name'],	
				'category'	=> $_POST['category'],	
				'url'	=> $_POST['url'],	
				'status'	=> $_POST['status'],	
				'sidenav'	=> $_POST['sidenav'],	
			]);

			Session::putFlash("success","Changes saved successfully");
		} catch (Exception $e) {
			Session::putFlash("danger", "Somthing went wrong");
			
		}
		Redirect::back();
	}


}























?>