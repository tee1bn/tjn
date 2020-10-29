<?php

use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\Wallet;


/**
 *
 */
class DepositController extends controller
{

    public function __construct()
    {


        if (!$this->admin()) {
            $this->middleware('current_user')
                ->mustbe_loggedin()
                ->must_have_verified_email();
            // ->must_have_verified_company();
        }

    }


    public function push($deposit_id, $status, $wallet_key=null)
    {
        if (!$this->admin()) {
            die();
        }



        $wallet_class = Wallet::$wallet_classes[$wallet_key]['class'] ;

        if ($wallet_class == null) {
            Session::putFlash('danger', "Could not complete this request.");
            Redirect::back();
        }


        $line = $wallet_class::find($deposit_id);


        if ($line == null) {
            Session::putFlash('danger', "Invalid Request.");
            Redirect::back();
        }

/*        if ($line->is_complete()) {
            Session::putFlash('danger', "Already  completed.");
            Redirect::back();
        }
*/

        DB::beginTransaction();

        try {

            $line->update([
                'status' => $status,
                'admin_id' => $this->admin()->id,
            ]);

            DB::commit();
            Session::putFlash('success', "Transaction marked as $status");

        } catch (Exception $e) {
            DB::rollback();
            Session::putFlash('success', "Something went wrong. Please try again.");
        }


        Redirect::back();

    }


}


?>