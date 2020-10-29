<?php


/**
 * this class is the default controller of our application,
 *
 */
class TermsController extends controller
{


    public function __construct()
    {

    }


    public function send_request()
    {
    }


    public function index()
    {

        $this->view('guest/terms');

    }


}


?>