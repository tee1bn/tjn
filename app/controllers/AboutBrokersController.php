<?php
use v2\Models\Broker;


class AboutBrokersController extends controller
{


	public function broker($broker_id='')
	{


		$broker_id = MIS::dec_enc('decrypt', $broker_id);
		$broker = Broker::where('id', $broker_id)->first();
		if ($broker == null) {
			// Session::putFlash('danger',"Invalid Request");
			Redirect::back();
		}

		$this->view('guest/about-broker', compact('broker'));
	}

	public function index($value='')
	{
		# code...
	}

}





















?>