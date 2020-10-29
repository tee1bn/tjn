<?php


/**
 * this class is the default controller of our application,
 *
 */
class GuestController extends controller
{


    public function __construct()
    {

    }


    public function send_request()
    {
        if (Input::exists('send_request')) {
            RequestsForm::create(Input::all());
            Session::putFlash('info', 'Request Sent successfully!');
        }

        Redirect::to('guest');

    }


    public function index()
    {

        $this->view('guest/request-form');

    }


}


?>