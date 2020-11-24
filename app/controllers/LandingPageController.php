<?php

use  v2\Models\Market;

/**
 */
class LandingPageController extends controller
{


    public function __construct()
    {
        
    }


    public function index($username, $page=null)
    {

        $user = User::where('username', $username)->first();

        if ($user==null) {
            //return;
        }


        switch ($page) {
            case 'store':
                # code...
                break;
            
            case 'posts':
                # code...
                break;

            case 'contact':
                # code...
                break;
            
            default:

            $model = 'course';
            $show_personal = '1';
            $this->view('merchant/shop', compact('model','show_personal','user'));

            break;
        }



    }


}


?>