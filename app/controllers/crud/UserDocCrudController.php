<?php

use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\AdminComment;
use v2\Models\UserDocument;


/**
 *
 */
class UserDocCrudController extends controller
{


    public function __construct()
    {

    }

    public function index($value = '')
    {
        # code...
    }

    public function push_to_state()
    {
        $doc_id = $_POST['doc_id'];
        $state = $_POST['status'];
        $comment = $_POST['comment'];
        $doc = UserDocument::find($doc_id);

        if (($doc == null) || (!file_exists($doc->path))) {
            Session::putFlash('danger', 'File Not Found');
            Redirect::back();
        }
        DB::beginTransaction();
        try {

            AdminComment::create([
                'admin_id' => $this->admin()->id,
                'model' => 'user_document',
                'model_id' => $doc->id,
                'comment' => $comment,
                'status' => $state
            ]);


            $doc->update([
                'status' => $state
            ]);


            Session::putFlash('success', 'Changes saved successfully');

            DB::commit();

            $this->sendNotification($doc->id);
        } catch (Exception $e) {
            DB::rollback();
            print_r($e->getMessage());
            Session::putFlash('danger', 'Something went wrong');
        }

        Redirect::back();
    }

    public function sendNotification($document_id)
    {


        $document = UserDocument::find($document_id);
        $domain = Config::domain();
        $project_name = Config::project_name();

        $user = $document->user;
        $view = $this->buildView('composed/user_documents', compact('user'), true);
        $document_type = $document->Type['name'];
        switch ($document->status) {
            case 2: //approved

                $content = "Dear {$document->user->firstname},
							<p>Your profile documents have been approved. 

							<p>&nbsp;</p>

							<p>Thank you for choosing to do business with us.</p>
							
							<p>&nbsp;</p>

							";

                $admin_content = "
							<p><strong>NOTICE</strong></p>

							<p>A  $document_type document for {$document->user->fullname} as been $document->DisplayStatus
							 by {$document->admin->fullname}</p>

						<p>Please <a href='$domain/login/admin_login'>login </a>to confirm.</p>
				";

                break;


            case 3: //declined
                $comment = $document->adminComments()->where('status', 3)->last()->comment;

                $content = "Dear {$document->user->firstname},
						<p>Your $document_type as been declined.</p>


						<p>&nbsp;</p>
						Comment: $comment


						<p>Thank you for choosing to do business with us.</p>
						
						<p>&nbsp;</p>

						";


                $admin_content = "
						<p><strong>NOTICE</strong></p>

						<p>A  $document_type document for {$document->user->fullname} as been $document->DisplayStatus
						 by {$document->admin->fullname}</p>

					<p>Please <a href='$domain/login/admin_login'>login </a>to confirm.</p>
			";


                break;


            default:

                return;

                break;
        }


        $settings = SiteSettings::site_settings();
        $noreply_email = $settings['noreply_email'];
        $support_email = $settings['support_email'];
        $notification_email = $settings['notification_email'];


        $subject = "Document Notification - $project_name";
        $mailer = new Mailer;

        $content = MIS::compile_email($content);
        $admin_content = MIS::compile_email($admin_content);


        //client
        $mailer->sendMail(
            "{$document->user->email}",
            "$subject",
            $content,
            "{$document->user->firstname}",
            "{$support_email}",
            "$project_name"
        );


        /*
                //ADMIN
                $mailer->sendMail(
                    $notification_email,
                    "$subject",
                    $admin_content,
                    "$project_name",
                    "$support_email",
                    "$project_name"
                );*/
    }


    public function upload_document()
    {
        echo "<pre>";/*
		print_r($_POST);
		print_r(Input::all());
		print_r($_FILES);*/

        $document_type = $_POST['type'];

        $auth = $this->auth();


        $last_doc = UserDocument::where('user_id', $auth->id)->where('document_type', $document_type)->latest()->first();

        $translated_doc = UserDocument::$document_types[$document_type]['name'];

        if ($last_doc != null) {
            if ($last_doc->is_status(1) || $last_doc->is_status(2)) {
                Session::putFlash("danger", "$translated_doc is in review or approved.");
                Redirect::back();
            }
        }

        DB::beginTransaction();

        try {

            $directory = 'uploads/verification';
            $file = $_FILES['document'];
            $handle = new Upload ($file);

            $file_type = explode('/', $handle->file_src_mime)[0];

            if (($handle->file_src_mime == 'application/pdf') || ($file_type == 'image')) {
                $label = MIS::random_string(10);
                $handle->file_new_name_body = "{$auth->fullname}_$label";

                $handle->Process($directory);
                $file_path = $directory . '/' . $handle->file_dst_name;

            } else {
                Session::putFlash("danger", "only .pdf and image format  is  allowed");
                throw new Exception("Only Pdf is allowed ", 1);

            }

            $doc = UserDocument::create([
                'user_id' => $auth->id,
                'path' => $file_path,
                'document_type' => $document_type,
                'status' => 1,
            ]);
            DB::commit();
            Session::putFlash("success", "$translated_doc uploaded successfully.");
        } catch (Exception $e) {
            DB::rollback();
            print_r($e->getMessage());
            Session::putFlash("danger", "Something went wrong.");
        }

        Redirect::back();

    }


}


?>