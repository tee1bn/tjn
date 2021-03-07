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
            Session::putFlash("info","This merchant does not exist");
            Redirect::to('shop');
        }

        $merchant = $user;

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
            $domain = Config::domain();
            $request_url = "$domain/shop/market/?seller_id=$user->id";
            $this->view('merchant/shop', compact('model','show_personal','user','merchant','request_url'));

            break;
        }



    }


}


?>