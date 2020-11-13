<?php


use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\Commission;
use v2\Models\HotWallet;
use v2\Models\InvestmentPackage;
use v2\Models\Wallet;
use v2\Models\Withdrawal;
use v2\Models\Sales;


// use v2\Shop\Payments\Paypal\Paypal as cPaypal;
// use v2\Shop\Payments\Paypal\Subscription;


/**
 * this class is the default controller of our application,
 *
 */
class home extends controller
{


    public function __construct()
    {

    }

    public function test2()
    {

        echo "<pre>";




        echo ProductsCategory::all();


        print_r($this->auth()->Subscriptions);
        // echo MIS::custom_mime_content_type("uploads/images/products/self-made-millionaire_14.jpg");
        return;
        $setting = SiteSettings::all()->keyBy('criteria');




        $ranks_and_gen = collect($setting['rank_and_generation']->settingsArray['ranks'])->toArray();
        print_r($ranks_and_gen);

        return;

        $order = Orders::find(27);

        $order->give_value_on_wordpress();


        return;
/*
        $withdrawals = Withdrawal::select(DB::raw("COUNT(*) as count"), 
                                            DB::raw("sum(amount) as amount"), 
                                            DB::raw("sum(fee) as fee"), 
                                            DB::raw("sum(amount) - sum(fee) as payable"), 
                                            'status' )->groupBy('status')->get()->keyBy('status');




        $commissions = Commission::select(DB::raw("COUNT(*) as count"), 
                                            DB::raw("sum(amount) as amount"), 
                                            'type' )->groupBy('type')->get()->keyBy('type');




        $generated_commissions = ($commissions['credit']['amount'] ?? 0) 
                    - ($commissions['debit']['amount'] ?? 0);



        $payout = $generated_commissions
                    - ($withdrawals['completed']['payable'] ?? 0);*/

        

/*
        $commissions = Commission::select(DB::raw("COUNT(*) as count"), 
                                            DB::raw("sum(amount) as amount"), 
                                            'type' )->groupBy('type')->get()*/;




            print_r($withdrawals->toArray());
            print_r($commissions->toArray());



        return;

        $method = v2\Models\UserWithdrawalMethod::first();

        $r = $method->MethodDetails;

        print_r($r);

        return;
        $sale = Sales::first();

        $sale->update_amount_with_conversion();

        // $sale->give_referral_commissions();



        return;
        $user = User::find(1);

        $life_group_volume =  ($user->total_volumes('all', 'enrolment', [], 'volume', 'personal'));

        echo $life_group_volume;

    
    }



    public function contact_us()
    {


        // verify_google_captcha();

        echo "<pre>";

        print_r($_REQUEST);
        extract($_REQUEST);

        $project_name = Config::project_name();
        $domain = Config::domain();

        $settings = SiteSettings::site_settings();
        $noreply_email = $settings['noreply_email'];
        $support_email = $settings['support_email'];

        $email_message = "
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

			       <p>We have received your inquiry and a support ticket with the ID: <b>{$support_ticket->code}</b>
			        has been generated for you. We would respond shortly.</p>

			      <p>You can click the link below to update your inquiry.</p>

			       <p><a href='{$support_ticket->link}'>{$support_ticket->link}</a></p>

	               <br />
	               <br />
	               <br />
	               <a href='$domain'> $project_name </a>


	               ";


        $support_email_address = $noreply_email;

        $client_email_message = MIS::compile_email($client_email_message);
        $email_message = MIS::compile_email($email_message);


        $mailer = new Mailer();

        $mailer->sendMail(
            $support_email_address,
            "$project_name Support - Ticket ID: $support_ticket->code",
            $client_email_message,
            "Support");


        $response = $mailer->sendMail(
            "$support_ticket->customer_email",
            "$project_name Support - Ticket ID: $support_ticket->code",
            $client_email_message,
            $support_ticket->customer_name
        );

        Session::putFlash('success', "Message sent successfully.");

        Redirect::back();

        die();


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
        } else {
            echo "[]";
        }


        unset($_SESSION['flash']);

    }


    public function close_ticket()
    {
        $ticket = SupportTicket::where('code', $_REQUEST['ticket_code'])->first();
        $ticket->mark_as_closed();
        Redirect::back();
    }


    public function support_message()
    {

        $project_name = Config::project_name();
        $domain = Config::domain();

        $settings = SiteSettings::site_settings();
        $noreply_email = $settings['noreply_email'];
        $support_email = $settings['support_email'];


        $files = MIS::refine_multiple_files($_FILES['documents']);

        $ticket = SupportTicket::where('code', $_POST['ticket_code'])->first();
        $ticket->update(['status' => '0']);

        $message = SupportMessage::create([
            'ticket_id' => $ticket->id,
            'message' => $_POST['message'],
        ]);


        $message->upload_documents($files);

        $support_email_address = "$support_email";
        $_headers = "From: {$ticket->customer_email}";

        $client_email_message = "Dear Admin, Please respond to this support ticket on the admin <br>
	                            From:<br>
	                            $ticket->customer_name,<br>
	                            $ticket->customer_email,<br>
	                            $ticket->customer_phone,<br>
	                            Ticket ID: $ticket->code<br>
	                            <br>
	                             ";
        $client_email_message .= $message->message;

        $client_email_message = $ticket->compile_email($client_email_message);

        $mailer = new Mailer();

        $mailer->sendMail(
            "$support_email_address",
            "$project_name Support - Ticket ID: $ticket->code",
            $client_email_message,
            "Support"
        );

        Redirect::back();
    }


    public function index($page = null)
    {

        // Redirect::to('login');

        switch ($page) {
            case 'supportmessages':

                $this->view('guest/support-messages');

                break;

            case 'about':

                $this->view('guest/about');
                break;

            case 'packages':

                $this->view('guest/packages');
                break;

            case 'services':
                $this->view('guest/services');
                break;

            case 'products':
                $this->view('guest/products');
                break;

            case 'payment-method':
                $this->view('guest/payment-method');
                break;


            case 'referral':
                $this->view('guest/referral');
                break;

            case 'leadership-program':
                $this->view('guest/leadership-program');
                break;

            case 'how-to-be-part':
                $this->view('guest/how-to-be-part');
                break;

            case 'trucash':
                $this->view('guest/trucash');
                break;

            case 'faqs':
                $this->view('guest/faqs');
                break;

            case 'contact-us':
                

                $this->view('guest/contact-us');
                break;

            case 'terms':
                $this->view('guest/terms');
                break;

            case 'privacy':
                $this->view('guest/privacy');
                break;

            case 'user-agreement':
                $this->view('guest/user-agreement');
                break;

            case null:

                $this->view('guest/index');
                // Redirect::to('w');
                break;

            default:

                $this->view('guest/404');
                break;
        }


    }


    public function about_us()
    {
        $this->view('guest/about_us');
    }


    public function how_it_works()
    {
        $this->view('guest/how-it-works');
    }

    public function contact()
    {
        $this->view('guest/contact');
    }

    public function faqs()
    {
        $this->view('guest/faq');
    }


}


?>