<?php

use v2\Models\Broker;
/**
 * 
*/
class AccountController extends controller
{


	public function __construct(){

	}




	public function open_live_account($broker_id)
	{
		$broker_id = MIS::dec_enc('decrypt', $broker_id);
		$broker = Broker::where('id', $broker_id)->first();
		if ($broker == null) {
			//Session::putFlash('danger',"Invalid Request");
			Redirect::back();
		}

		Redirect::to($broker->DetailsArray['open_account']);

		// $this->view('guest/open-live-account', compact('broker'));
	}



	public function open_demo_account($broker_id)
	{

		$broker_id = MIS::dec_enc('decrypt', $broker_id);
		$broker = Broker::where('id', $broker_id)->first();
		if ($broker == null) {
			//Session::putFlash('danger',"Invalid Request");
			Redirect::back();
		}

		Redirect::to($broker->DetailsArray['open_demo_account']);

	}



	public function index()
	{

		$this->view('auth/error');

	}




}























?>