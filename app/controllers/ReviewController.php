<?php

use Illuminate\Database\Capsule\Manager as DB;

use v2\Models\AdminComment;
/**
 */
class ReviewController extends controller
{



    public function __construct()
    {


        if (!$this->admin() &&  !$this->auth()) {
            die();
        }

    }



    public function push_to_state($key)
    {

        $product_id = $_POST['product_id'];
        $state = $_POST['status'];
        $comment = $_POST['comment'];

        echo "<pre>";
        print_r($_POST);

        $commentables = AdminComment::$commentables[$key];

        $product = $commentables['model']::find($product_id);

        if (($product == null)) {
            Session::putFlash('danger','File Not Found');
            Redirect::back();
        }


        DB::beginTransaction(); 
        try {

            AdminComment::create([
                        'admin_id' => $this->admin()->id,
                        'model' => $key,
                        'model_id' => $product->id,
                        'comment' => $comment,
                        'status' => $state                      
            ]);



            DB::commit();   
            $this->sendNotification($product);
            
            Session::putFlash('success','Changes saved successfully');
        } catch (Exception $e) {
            DB::rollback(); 
            print_r($e->getMessage());
            Session::putFlash('danger','Something went wrong');
        }

        Redirect::back();
    }


    public function sendNotification($product=null, $reason=null)
    {


        $domain = Config::domain();
        $project_name = Config::project_name();
        $comment =      $product->adminComments()->last()->comment;

        $content = "
                    <p><strong>NOTICE</strong></p>

                    <p>Your product $product->name has been {$product->State}</p>


                <p>Please <a href='$domain/login'>login </a>to confirm.</p>
        ";

        $admin_content = "
                    <p><strong>NOTICE</strong></p>

                    <p>Your product $product->name has been {$product->State} by {$this->admin()->fullname}</p>


                <p>Please <a href='$domain/login'>login </a>to confirm.</p>
        ";



        $settings = SiteSettings::site_settings();
        $noreply_email = $settings['noreply_email'];
        $support_email = $settings['support_email'];
        $notification_email = $settings['notification_email'];



        $subject = "Notification on Product - $project_name";
        $mailer = new Mailer;

        $content = MIS::compile_email($content);
        $admin_content = MIS::compile_email($admin_content);


        //client
        $mailer->sendMail(
            "{$product->user->email}",
            "$subject",
            $content,
            "{$product->user->firstname}",
            "{$support_email}",
            "$project_name"
        );



        //ADMIN
        $mailer->sendMail(
            $notification_email,
            "$subject",
            $admin_content,
            "$project_name",
            "$support_email",
            "$project_name"
        );
    }

    
}


?>