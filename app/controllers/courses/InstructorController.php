<?php


/**
 * this class is the controller hat conatins all routes to e.g terms of use, privac and other ststaic pages
	asides those from main menu
 * 
*/
class InstructorController extends controller
{


	public function __construct(){
		$this->middleware('current_user')->mustbe_loggedin()->mustbe_instructor();

	}




	/**
	 * this is the default landing point for all request to our application base domain
	 * @return a view from the current active template use: Config::views_template()
	 * to find out current template
	 */


	public function index()
	{
		
		$this->view('auth/instructor-dashboard');
	}


}























?>