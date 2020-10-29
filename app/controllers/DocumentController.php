<?php

/**
 *
 */
class DocumentController extends controller
{

    public function __construct()
    {


        // $this->middleware('current_user')->mustbe_loggedin();
    }


    public function delete_document($key)
    {

        $documents_settings = SiteSettings::where('criteria', 'documents_settings')->first();
        $response = $documents_settings->delete_document($key);
        header("content-type:application/json");

        echo json_encode(compact('response'));
    }


    public function fetch_documents_list()
    {
        $documents_settings = SiteSettings::documents_settings();
        header("content-type:application/json");
        $documents = ($documents_settings);
        echo json_encode(compact('documents'));
    }


}


?>