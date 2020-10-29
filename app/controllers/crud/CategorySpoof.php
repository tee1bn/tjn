<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Support\Str;



/**
 * 
 */
class CategorySpoof extends controller
{
	
	function __construct()
	{

		$this->middleware('administrator')->mustbe_loggedin();

	}

	public function delete_category($category_id)
	{

		$category = CampaignCategory::find($category_id);
		if ($category==null) {
			Session::putFlash("danger","Category not found");
			Redirect::back();
		}


		$category->delete();
		Session::putFlash("success","Category deleted successfully.");

			Redirect::back();
		

	}



	public function new_category_app()
	{
		$host = Config::domain();
		$count = $_SESSION['recipient_spoof']['query'];
		$inputs = "";
		foreach ($_POST as $key => $value) {
		    $inputs.= "<input type='hidden' name='$key' 
		    value='$value'> ";
		}

		$app = <<<EOL

                        <!-- Modal -->
                        <div id="add_to_campaign_category" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">New Category</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                                  
                              <div class="modal-body">

                                <form class="ajax_form" action="$host/category_crud/save_new_category" method="post">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="" class="form-control" name="title" required="">
                                        $inputs
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" required=""></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label> Select capture</label>
                                        <select name="capture" class="form-control">
                                        	<option value="in">Users in this query</option>
                                        	<option value="notin">Users NOT in this query</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-dark" type="submit">Add</button>
                                    </div>
                                </form>
                              </div>
                            </div>

                          </div>
                        </div>
EOL;
	

		$response = compact('app');

		header("content-type:application/json");

		echo  json_encode($response);

	}

	public static function dump($builder)
	{
	    $sql = $builder->toSql();
	 
	    foreach ($builder->getBindings() as $binding) {
	        $sql = Str::replaceFirst('?', (is_numeric($binding) ? $binding : sprintf('"%s"', $binding)), $sql);
	    }
	 
	    return $sql;
	}



	public static function register_query($query, $binds=[])
	{


		$_SESSION['recipient_spoof']['query'] = CategorySpoof::dump($query);
		// $_SESSION['recipient_spoof']['binds'] = $query->getBindings();
	}


	public static function save_new_category()
	{
		echo "<pre>";
		$query = $_SESSION['recipient_spoof']['query'];
		$binds = $_SESSION['recipient_spoof']['binds'];

		print_r($_POST);
		print_r($_SESSION['recipient_spoof']);

		//perform test for firstname, phone and email 
		$compulsory_fields = ['firstname', 'lastname', 'username', 'email', 'phone'];
		$response =	DB::select("$query LIMIT 1")[0];
		$intersection = array_intersect($compulsory_fields, array_keys((array)$response));


		$user_foreign_key = $_POST['user_foreign_key'];
		$capture = $_POST['capture'];
		//ensure query has 'firstname', 'lastname', 'username', 'email', 'phone'
		if ($intersection == $compulsory_fields) {

			$sql = $query;

		}else{ //join to user table

			switch ($capture) {
				case 'in':


					$sql = "
					SELECT jj.*,users.id as uid, users.firstname, users.lastname, users.username, users.email, users.phone FROM 

					($query) 	AS jj 

					JOIN (select * from users where email_verification=1) as users ON jj.$user_foreign_key = users.id

					";


					break;
				case 'notin':


				$sql ="
				SELECT jj.*,users.id as uid, users.firstname, users.lastname, users.username, users.email, users.phone FROM 

				($query)	AS jj 

				RIGHT JOIN (select * from users where email_verification=1) as users ON jj.$user_foreign_key = users.id and jj.$user_foreign_key = NULL
				";


					break;
				
				default:
					# code...
					break;
			}
		}
		

		//test query
		try {
			
			$recipients =	DB::select("$sql");
			$count = count($recipients) ;
			if ($count > 0 ) {
				Session::putFlash("success", "Found $count rows");

			}else{

			}

		} catch (Exception $e) {

				Session::putFlash("danger", 'Could not  create category');
				return;
		}
		

			

			$category =	CampaignCategory::where('title', $_POST['title'])->first();

			if ($category != null) {

				Session::putFlash('danger', "Category Title already exist");
				return;
			}
			

			//ensure no duplicate category
			$categories =	CampaignCategory::all();
			foreach ($categories as $key => $category) {
					$db_sql = $category->sql_query;

					if ($sql == $db_sql) {	
						$return = true;
						Session::putFlash('danger', "This group already exist as <br><code>{$category->title}</code>");
						return;
					}
			}

			
		try {

			$new_category	=	CampaignCategory::updateOrCreate(
													[
														'title' 		=> $_POST['title'],
													],
													[
														'sql_query' 	=> $sql,
														'description' 	=> $_POST['description'],
														'binds' 	=> $_POST['binds'],
														'status'		=> 1,
														'admin_id'		=> $this->admin()->id,
													]);

			Session::putFlash('success', "Category saved successfully");
		} catch (Exception $e) {
			
			print_r($e->getMessage());
		}





	}






}