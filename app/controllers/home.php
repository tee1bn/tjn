<?php


use classes\Auth\Auth as Auth;
use World\Country;
use v2\Models\FinancialBank;
use v2\Models\UserDocument;
use Illuminate\Database\Capsule\Manager as DB;


/**
 * this class is the default controller of our application,
 * 
*/
class home extends controller
{


	public function __construct(){

	}

	public function test2()
	{

		echo "<pre>";

		$response = QuestionaireResponse::latest()->first();

		print_r($response->performance());
		print_r($response->Corrections);


		return;

/*			$message = "Ilove";
		    echo  $client_email_message = $this->buildView('emails/compile', compact('message'));
*/

		    echo MIS::compile_email("ok");

		    return;

	echo "<pre>";
		    $users = User::find(1);
		    // $documents = UserDocument::where


		$users->has_verified_profile();

	$response =  DB::select("SELECT m1.user_id, COUNT(*) as approved_docs
            FROM users_documents m1 LEFT JOIN users_documents m2
             ON (m1.document_type = m2.document_type AND m1.id < m2.id)
            WHERE m2.id IS NULL 
            AND m1.status = '2'
            GROUP BY m1.user_id
            Having  approved_docs = 2
            ;

            ")
	;
	// ->pluck('id')->toArray();
/*
select `m1`.`user_id`, COUNT(*) as approved_docs
 from `users_documents` as `m1` left join `users_documents` 
on `m1`.`document_type` = `m2`.`document_type` and `m1`.`id` < `m2`.`id` 
where `m1`.`status` = 2 
group by `m1`.`user_id` 
having `approved_docs` > 1
*/


		print_r($response);

		$users = User::query();

		$eloquent = UserDocument::from("users_documents as user_doc")->select('user_doc.user_id', DB::raw("COUNT(*) as approved_docs"))
		->where('user_doc.status', 2)
		->groupBy('user_doc.user_id')
		->having('approved_docs', '>',1)
		  ->leftJoin('users_documents', function ($join) {
            $join
            ->on('user_doc.document_type', '=', 'users_documents.document_type')
            ->on('user_doc.id', '<', 'users_documents.id')
            ;
        })
		  ->where('users_documents.id', null)
		;



		$userss = User::query()
		        ->joinSub($eloquent, 'approved_documents', function ($join) {
		            $join->on('users.id', '=', 'approved_documents.user_id');
		        })->get();


		 print_r($userss->toArray());


		// print_r($eloquent->toSql());
		print_r($eloquent->get()->toArray());

		// print_r($response->get()->toArray());

	}

	public function survey()
	{
		$questionaire = Questionaire::Published()->where('code', $_GET['survey_id'])->first();

		if ($questionaire == null ) {
		    die();
		}

		$this->view('guest/survey', compact('questionaire'));
	}

	public function survey_for_course($quiz_id)
	{
		$questionaire = Questionaire::Published()->where('id', $quiz_id)->first();

		if ($questionaire == null ) {
		    die();
		}
		
		$this->view('guest/survey_for_course', compact('questionaire'));
	}

	public function close_ticket()
	{
	    $ticket	 = SupportTicket::where('code', $_REQUEST['ticket_code'])->first();
	    $ticket->mark_as_closed();
	    Redirect::back();
	}


	public function support_message()
	{

	    $files = MIS::refine_multiple_files($_FILES['documents']);

	    $ticket = SupportTicket::where('code', $_POST['ticket_code'])->first();
	    $ticket->update(['status' => '0']);

	    $message = SupportMessage::create([
	        'ticket_id' => $ticket->id,
	        'message' => $_POST['message'],
	    ]);



        $project_name = Config::project_name();
        $domain = Config::domain();

		$settings = SiteSettings::site_settings();
		$noreply_email = $settings['noreply_email'];
		$support_email = $settings['support_email'];



	    $message->upload_documents($files);

	    $_headers = "From: {$ticket->customer_email}";

	    $client_email_message = "Dear Admin, Please respond to this support ticket on the forexfxprofit admin <br>
	                            From:<br>
	                            $ticket->customer_name,<br>
	                            $ticket->customer_email,<br>
	                            $ticket->customer_phone,<br>
	                            Ticket ID: $ticket->code<br>
	                            <br>
	                             ";
	    $client_email_message .= $message->message;

	    $client_email_message = MIS::compile_email($client_email_message);


	    $mailer = new Mailer();

	    
	    //for admin
	    $mailer->sendMail(
	        $support_email,
	    	"$project_name Support - Ticket ID: $ticket->code",
	        $client_email_message,
	        "9gForex Support",
	        "$ticket->customer_email",
	        "9gForex.com"
	    );





	    Redirect::back();
	}



	    public function contact_us()
	    {


	        MIS::verify_google_captcha();

		echo "<pre>";

		print_r($_REQUEST);
	        extract($_REQUEST);	

	        $project_name = Config::project_name();
	        $domain = Config::domain();

			$settings = SiteSettings::site_settings();
			$noreply_email = $settings['noreply_email'];
			$support_email = $settings['support_email'];

	        $admin_email_message = "
			       <p>Dear Admin, Please respond to this support ticket on the $project_name admin </p>


			       <p>Details:</p>
			       <p>
			       Name: " . $full_name . "<br>
			       Phone Number: " . $phone . "<br>
			       Email: " . $email . "<br>
			       Comment: " . $comment . "<br>
			       </p>

			       ";


	        $client = User::where('email', $_POST['email'])->first();
	        $support_ticket = SupportTicket::create([
	            'subject_of_ticket' => $_POST['comment'],
	            'user_id' => $client->id,
	            'customer_name' => $_POST['full_name'],
	            'customer_phone' => $_POST['phone'],
	            'customer_email' => $_POST['email'],
	        ]);

	        $code = $support_ticket->id . MIS::random_string(7);
	        $support_ticket->update(['code' => $code]);
	        //log in the DB

	        $client_email_message = "
			       Hello {$support_ticket->customer_name},

			       <p>We have received your enquiry and a support ticket with Ticket ID: <b>{$support_ticket->code}</b>
			        has been created for you. We will respond shortly.</p>

			      <p>You can click the link below to update your enquiry.</p>

			       <p><a href='{$support_ticket->link}'>{$support_ticket->link}</a></p>

	               <br />
	               <br />
	               <br />
	               <a href='$domain'> $project_name </a>


	               ";


	        $support_email_address = $noreply_email;

	        $message = $admin_email_message;
	        $admin_email_message = $this->buildView('emails/contact-message', compact('message'), true);

	        $message = $client_email_message;
	        $client_email_message = $this->buildView('emails/contact-message', compact('message'), true);


	        $mailer = new Mailer();

	        //for admin
	        $mailer->sendMail(
	            $support_email,
	        	"$project_name Support - Ticket ID: $support_ticket->code",
	            $admin_email_message,
	            "9gForex Support",
	            "$support_ticket->customer_email",
	            "9gForex.com"
	        );




	        //for client
	        $response = $mailer->sendMail(
	        	  "$support_ticket->customer_email",
	        	"$project_name Support - Ticket ID: $support_ticket->code", 
	        	$client_email_message, 
	        	 $support_ticket->customer_name,
	        	 $support_email,
	        	 "9gForex Support"
	        	);


	        print_r($response);

	        Session::putFlash('primary', "Message sent successfully.");

	        Redirect::back();

	    

	}




	/**
	 * [flash_notification for application notifications]
	 * @return [type] [description]
	 */
	public function flash_notification()
	{
		header("Content-type: application/json");

		if (isset($_SESSION['flash'])) {
		echo json_encode($_SESSION['flash']);
		}else{
			echo "[]";
		}


		unset($_SESSION['flash']);

	}



	public function index($page=null)
	{			
		switch ($page) {
			case 'supportmessages':

				$this->view('guest/support-messages');
				break;

			case 'about-us':
				$this->view('guest/about-us');
				break;

			case 'fx-academy':
				$this->view('guest/fx-academy');
				break;
			
			case 'faqs':
				$this->view('guest/faqs');
				break;
			
			case 'event-calendar':
				$this->view('guest/event-calendar');
				break;
			
			case 'contact-us':
				$this->view('guest/contact-us');
				break;

			case 'fx-signals':
				$this->view('guest/signals');
				break;

			case 'fx-signals-terms':
				$this->view('guest/fx-signals-terms');
				break;
			
			case null:
				$this->view('guest/index');
				break;
			
			default:
				$this->view('guest/error-404');
				break;
		}



	}



}























?>