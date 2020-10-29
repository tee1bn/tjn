<?php


/**
 * this class is the default controller of our application,
 *
 */
class AdminDashboardController extends controller
{


    public function __construct()
    {

        Redirect::to('admin/dashboard');
    }


    public function index()
    {
        $this->view('admin/dashboard');

    }


}


?>