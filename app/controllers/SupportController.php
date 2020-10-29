<?php


/**



*/
class SupportController extends controller
{



	public function __construct(){
		// $this->middleware('current_user')->mustbe_loggedin();

	}



	public function closeTicket($ticket_id){

		SupportTicket::find($ticket_id)->update(['status' => 1]);


		Session::putFlash("Info", "Ticket marked closed successfully!");

	Redirect::to('support/viewTicket/'.$ticket_id);



	}

	///
	///
	public function admin_close_ticket($ticket_id){

	echo 	SupportTicket::find($ticket_id)->update(['status'=> 1,'closed_by'=> $this->admin()->id]);
 	Session::putFlash('Info', "Closed succesfully.");

 		Redirect::to('admin/viewSupportTicket/'.$ticket_id);



	}


	public function admin_create_ticket_message($ticket_id){

		if (/*Input::exists()*/ true) {
			


	$this->validator()->check(Input::all() , array(

	'message' =>[

								'required'=> true,
								'max'=> 2000,
								'unique'=> 'TicketMessage',
						],
		));

 if($this->validator->passed()){

 echo	$message  =  SupportTicket::find($ticket_id)->messages()->create([
 				'message' => trim(Input::get('message')) , 				
 				'admin_id' => $this->admin()->id, 				
 				]);

 		Redirect::to('admin/viewSupportTicket/'.$ticket_id);
 	Session::putFlash('Info', " Message Sent.");

 }else{

 	Session::putFlash('Info', "Please try again, Message not sent ");

 }

		
		


	
		}



 		Redirect::to('admin/viewSupportTicket/'.$ticket_id);



	}
	
	///




















	public function createTicketMessage($ticket_id){

print_r(Input::all());

		if (/*Input::exists('create_ticket_message')*/ true) {
echo "$ticket_id";
			


	$this->validator()->check(Input::all() , array(

	'message' =>		[

								'required'=> true,
								'max'=> 2000,
								'unique'=> 'TicketMessage',
						],
		));

 if($this->validator->passed()){

 echo	$message  =  SupportTicket::find($ticket_id)->messages()->create([
 				'message' => trim(Input::get('message')) , 				
 				'user_id' => $this->auth()->id, 				
 				]);

 	Session::putFlash('Info', "Message sent ");

 }else{

 	Session::putFlash('Info', "Please try again, Message not sent ");

 	// print_r($this->validator->errors());
 }

		
		


	
		}



		Redirect::to('support/viewTicket/'.$ticket_id);


	}



	public function viewTicket($ticket_id){

	 	$support_ticket 		 = SupportTicket::find($ticket_id); 

		$this->view('auth/support-messages', [
					'support_ticket'			=> $support_ticket 
									]);  


	}




	
	public function createTicket()
	{

		if(/*Input::exists('create_ticket')*/ true){

			print_r(Input::all());


	$this->validator()->check(Input::all() , array(

	
	'subject_of_ticket' =>[

								'required'=> true,
								'unique'=> 'SupportTicket',
						],




		));

 if($this->validator->passed()){

 	$subject_of_ticket = trim(Input::get('subject_of_ticket'));

	$support_ticket =	$this->auth()->supportTickets()->create(['subject_of_ticket'=> $subject_of_ticket]);
 	Session::putFlash('Info', "Complain Logded successfully");
 	unset($_SESSION['inputs']);

 	

 }else{

 	Session::putFlash('Info', "Failed, Please try again ");
print_r($this->validator->errors());

 }

		

}

	Redirect::to('user/support');



	}








public function index()
	{
		
		$this->view('auth/support');  
	}







}























?>