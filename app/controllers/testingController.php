<?php

use v2\Models\Sales;
use Illuminate\Database\Capsule\Manager as DB;

/**
 * this class is the default controller of our application,
 *
 */
class testingController extends controller
{


    public function __construct()
    {

        $this->middleware('administrator')->mustbe_loggedin();

    }


    public function index()
    {
        $this->view('admin/tests');
    }




    public function test_basic_bonus($sale_id)
    {        echo "<pre>";


        $sale = Sales::where('id' , $sale_id)->where('commission_settled','=', null)->first();

        if ($sale == null) {
            Session::putFlash("danger", "Sale not found or this commission is already distributed");
            Redirect::back();
        }



        DB::beginTransaction();

        try {

            $sale->give_referral_commissions();
            
            DB::commit();
            Session::putFlash("success","Commission distributed successfully");
        } catch (Exception $e) {
            Session::putFlash("danger","Something went wrong");
            DB::rollback();
            
        }

        Redirect::back();

    }


    public function create_sale()
    { 
           echo "<pre>";

        print_r($_POST);

        DB::beginTransaction();

        try {

            $sale = Sales::create($_POST);
            $sale->set_point();
            $sale->update(['is_paid'=> 1]);
            $sale->update_amount_with_conversion();
            DB::commit();
            Session::putFlash("success","Course Sale created successfully");
        } catch (Exception $e) {
            Session::putFlash("danger","Something went wrong");
            DB::rollback();
            
        }


        Redirect::back();
    }

    public function change_user_rank()
    {
        print_r($_POST);



        DB::beginTransaction();

        try {

            
            $user = User::find($_POST['user_id']);
            $user->update(['rank' => $_POST['rank']]);

            DB::commit();
            Session::putFlash("success","Rank updated  successfully");
        } catch (Exception $e) {
            Session::putFlash("danger","Something went wrong");
            DB::rollback();
            
        }
        Redirect::back();

    }

}


?>