<?php

use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\HotWallet;
use v2\Models\InvestmentPackage;

require_once "app/controllers/home.php";


/**
 *
 */
class PackageCrudController extends controller
{

    public function __construct()
    {

        if (!$this->admin()) {
            $this->middleware('current_user')
                ->mustbe_loggedin();
        }

    }


    public function resume_package($package_id)
    {
        # code...
    }


    public function pause_package($package_id)
    {

        $pack = HotWallet::find($package_id);

        if ($pack == null) {
            Session::putFlash("danger","Not Exiiting");
        }


        if ($pack->running_status == 1) {

            $pack->pause();
        }else{

            $pack->play();
        }

        echo "<pre>";
        print_r($pack->toArray());

        Redirect::back();
    }


    public function submit_simulate_packages()
    {
        echo "<pre>";
        print_r($_POST);

        $investment = InvestmentPackage::find($_POST['investment_id']);


        $amount = $_POST['amount'];


        $investment->in_range($_POST['amount']);


        if (($investment == null) || (!$investment->in_range($amount))) {
            Session::putFlash('danger', "Amount not in range of pack.");
            Redirect::back();
        }


        $this->validator()->check(Input::all(), array(
            'amount' => [
                'required' => true,
                'min_value' => $investment->DetailsArray['min_capital'],
                'max_value' => $investment->DetailsArray['max_capital'],
            ],

            'investment_id' => [
                'required' => true,
            ],
        ));


        if (!$this->validator->passed()) {
            Session::putFlash('danger', Input::inputErrors());
            Redirect::back();
        }

        $username = $_POST['username'];
        $auth = User::where('username', $username)->first();

        if ($auth == null) {
            Session::putFlash('danger', "User with username: <code>$username</code> not found. Please enter the correct username");
            Redirect::back();

        }


        //ensure more than one same pack is not running
        $running_investment = InvestmentPackage::for ($auth->id, $investment->id, 0)->first();

        if ($running_investment != null) {
            Session::putFlash('danger', "<code>$investment->name</code> is currently running. Please choose another pack");
            Redirect::back();
        }


        DB::beginTransaction();

        try {

            $value_date =  $_POST['paid_at'] ?? date("Y-m-d");

            //now create record for package investment
            $investment->setAmount($amount);
            $i_details = [
                'investment' => $investment->toArray(),
                'annual_worth' => $investment->getWorth('annual'),
                'total_worth' => $investment->getWorth('annual'),
                'capital' => $amount,
                'annual_roi' => $investment->DetailsArray['annual_roi_percent'],
                'weekly_worth' => $investment->getWorth('weekly'),
                'spread' => $investment->spread('weekly', false, $value_date),
                'is_complete' => 0
            ];

            print_r($i_details);

            $extra_detail = json_encode($i_details);
            $comment = '';


            $roi = HotWallet::createTransaction(
                'credit',
                $auth->id,
                null,
                0.00,
                'completed',
                'investment',
                $comment,
                null,
                null,
                $this->admin()->id,  //having admin id means it was created by and admin
                $extra_detail,
                $value_date
            );

            $roi->update(['cost' => $amount]);

            if ($roi == false) {
                throw new Exception("Could not creeate roi", 1);
            }


            DB::commit();
            Session::putFlash('success', "$investment->name purchased for $username successfully");

        } catch (Exception $e) {
            DB::rollback();
            print_r($e->getMessage());
            Session::putFlash('danger', 'Action Failed');
        }

        Redirect::back();
    }

}


?>