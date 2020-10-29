<?php


/**
 * this class is the default controller of our application,
 * 
*/
class GenealogyController extends controller
{


	public function __construct(){
		
/*
		if (! $this->admin()) {

			$this->middleware('current_user')
				->mustbe_loggedin();
				// ->mustbe_pay_registration_fee();
		}*/



		$this->settings = SiteSettings::site_settings();

		

	}




/**
 * [showThisDownine handles the display of generations]
 * @param  [type] $user_id [user to display]
 * @param  [type] $type    [whether referred_by(placement structure)
 *  or introduced_by (enrolment strcuture)]
 * @return [type]          [description]
 */
 public  function showThisDownine($user_id, $type)
          {
          	$type_detail =  [
          				'introduced_by' => 'enrolment',
          				'referred_by' => 'placement',
          					];
          	$route = $type_detail[$type];


                $user_    =  User::find($user_id); 
                $recruiter = User::where('mlm_id', $user_->$type)->first()->username ;    
               $output ='';
            $output .= '<div  class="col-sm-1 col-xs-1   refer-people" align="center">
                          <a href="'.Config::domain().'/genealogy/'.$route.'/'.$user_->username.'" data-toggle="tooltip" title="Upline:  '.ucfirst($recruiter).'">
                          ';

                $output .= ' <img class="img-responsive tree-img" src="'.Config::domain().'/'.$user_->profilepic.'">';

            $output .= ' <p>'.ucfirst($user_->username)."</p>       
                            </a>
                          </div>";

                          return $output;
          }




     public function place_user($new_member=null, $placement_sponsor_id=null, $username = null)
     {
		echo "<pre>";
		
		$enrolee =  User::find($new_member);
		$placement_sponsor = User::where('username' , $username)->first();


		if (($new_member==null ) ||($placement_sponsor_id==null )) {
     			Session::putFlash('', 'Invalid Placement. Please check and try again.');
     			// Redirect::to('genealogy/placement');
     			Redirect::to("admin/placement/$username");
     			// return;     		    

		}

		if ($enrolee->placed) {
		     			Session::putFlash('', 'Enrolee already placed.');
		     			// Redirect::to('genealogy/placement');
		     			Redirect::to("admin/placement/$username");
		     			// return;     		    

				}





     	$new_member_level 		 = 	$placement_sponsor->enroler_downline_level_of($new_member);
     	$placement_sponsor_level = 	$placement_sponsor->enroler_downline_level_of($placement_sponsor_id);



     	if (($new_member_level['present'] != 1) || 
     		($placement_sponsor_level['present'] != 1) ||
     		($new_member == $placement_sponsor_id)
     		 ) {

     			Session::putFlash('', 'Invalid Placement. Please check and try again.');
     		    // Redirect::to('genealogy/placement');
     		    Redirect::to("admin/placement/$username");

     			return;
     		}


     	$placement 	=		$enrolee->update([
     									'referred_by' => $placement_sponsor_id,
     									'placed' => 1,
     										]);

     	if ($placement) {
     			Session::putFlash('', 'Placed successfully.');
     	}


     	// Redirect::to('genealogy/placement');
     		    Redirect::to("admin/placement/$username");

     }





	public function enrolment($user_id='')
	{	
		$use = 'username';

		if ($use=='id') {
			if ($user_id == '') {
				$user_id = $this->auth()->id;
			}
		}else{
			$requested_user 	= User::where('username' ,$user_id)->first();
			$user_id 	= $requested_user->id;

			if ($requested_user == null) {
				if ($this->auth()) {
					$user_id = User::where('username' ,$this->auth()->username)->first()->id;
				}
			}
			
		}



		$this->view('auth/enrolment-structure', ['user_id'=>$user_id]);

	}







	public function placement($user_id='')
	{	
		$use = 'username';

		if ($use=='id') {
			if ($user_id == '') {
				$user_id = $this->auth()->id;
			}
		}else{
			$requested_user 	= User::where('username' ,$user_id)->first();
			@$user_id 	= $requested_user->id;

			if ($requested_user == null) {
				if ($this->auth()) {
					$user_id = User::where('username' ,$this->auth()->username)->first()->id;
				}
			}
			
		}




		$this->view('auth/placement-structure', ['user_id'=>$user_id]);

	}



	public function placement_list($username=null, $level_of_referral=1)
	{
		$user 	= User::where('username' ,$username)->first();
		
		if ($user == null) {
			if ($this->auth()) {
				$user = User::where('username' ,$this->auth()->username)->first();
			}
		}
			

		$page = (isset($_GET['page']))? $_GET['page'] : 1  ; 
		$per_page = 500;

		$list =	User::referred_members_downlines_paginated($user->id, $level_of_referral, $per_page , $page );




		$this->view('auth/placement-structure-list', compact('list', 'user','per_page', 'level_of_referral'));

	}






}























?>