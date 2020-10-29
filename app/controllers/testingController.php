<?php


/**
 * this class is the default controller of our application,
 * 
*/
class testingController extends controller
{


	public function __construct(){

	}


	public function index()
	{
		$this->view('admin/sales');
	}	


	public function distribute_base_commission($sale_id)
	{
		MlmSales::find($sale_id)->distribute_base_commission();

		Session::putFlash('','Base Commission Credited Successfully.');
		Redirect::to('admin/testing');
	}




	public function distribute_bonus_commission($sale_id)
	{
		MlmSales::find($sale_id)->distribute_bonus_commission();

		Session::putFlash('','Bonus Commission Credited Successfully.');
		Redirect::to('admin/testing');
	}


	public function distribute_team_override_commission($sale_id)
	{	
		$from = date("Y-m-d");
		$to   =  date("Y-m-d");

		MlmSales::find($sale_id)->distribute_team_override_commission($from , $to);

		Session::putFlash('','Team Override Commission Credited Successfully<br>
								<small>For Dynamic Compression, Only PSVs today is used to evaluate.(for testing purpose. it should be monthly PSV of uplines. You can create more sales for a upline- (placement structure) to test)  </small>.');
		Redirect::to('admin/testing');
	}








	public function create_sale()
	{

		 $base_commission =  (MlmSetting::where('rank_criteria', 'base_commission')->first()->settings) ;
		 $bonus_commission =  (MlmSetting::where('rank_criteria', 'bonus_commission')->first()->settings) ;
		 $team_override_commission =  (MlmSetting::where('rank_criteria', 'team_override_commission')->first()->settings) ;

		 echo "<pre>";


		print_r(Input::all());
		// print_r($base_commission);
		// print_r($bonus_commission);
		print_r($team_override_commission);

		MlmSales::create([
						'downline_user_id'			=>  Input::get('user_id'),
						'transaction_amount'		=> Input::get('price'),
						'base_commissions'			=> $base_commission,
						'bonus_commissions'			=> $bonus_commission,
						'team_override_commission'	=> $team_override_commission,
						]);

		Session::putFlash('','Sale created successfully.');
		Redirect::to('admin/testing');
	}	


	public function test_generational_bonus_distribution()
	{
		echo "<pre>";
		print_r(Input::all());

		$user_id = Input::get('user_id');
		$from 	 = Input::get('from');
		$to 	 = Input::get('to');


		require 'app/controllers/RoutineController.php';
		$ROUTINE = new RoutineController();



	($ROUTINE->give_generational_bonuses_to_this_user($user_id, $from, $to));

		Session::putFlash('','Generational Bonus Distributed successfully.');
		Redirect::to('admin/testing');


	}




}





















?>