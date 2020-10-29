<?php
require_once "app/controllers/home.php";


/**
 *
 */
class TicketCrudController extends controller
{

    public function __construct()
    {

    }

    public function admin_response()
    {

        $project_name = Config::project_name();
        $domain = Config::domain();

        $settings = SiteSettings::site_settings();
        $noreply_email = $settings['noreply_email'];
        $support_email = $settings['support_email'];


        $refined_file = MIS::refine_multiple_files($_FILES['documents']);

        $admin = $this->admin();

        $ticket = SupportTicket::where('code', $_POST['ticket_code'])->first();
        $ticket->update(['status' => '0']);

        $message = SupportMessage::create([
            'ticket_id' => $ticket->id,
            'message' => $_POST['message'],
            'admin_id' => $admin->id,
        ]);

        $message->upload_documents($refined_file);

        $support_email_address = "$support_email";
        $_headers = "From: {$support_email_address}";

        $client_email_message = "<p>Hello $ticket->customer_name,</p>
		                             <p>$message->message </p>
		                         <p>You can respond by clicking this button <a href='{$ticket->link}'><button> Respond</button></a></p>
		                         <br><br>
		                         <p>Please note that to update this support request, you need to click the link above. Please do not click your email reply button as you would be replying to an unattended email. </p>

                                 <p></p>
                                 <p></p>
                                 <p>
                                    <a href='$domain'>$project_name</a>
                                 </p>
		                         ";

        $client_email_message = MIS::compile_email($client_email_message);
        $mailer = new Mailer();

        $mailer->sendMail(
            $ticket->customer_email,
            "Support - Ticket ID: $ticket->code",
            $client_email_message,
            $ticket->customer_name
        );

        Redirect::back();
    }


    public function index()
    {
        //$this->view('guest/support-messages');

    }

    public function create_ticket()
    {
        $controller = new home;
        $controller->contact_us();
    }


}


?>