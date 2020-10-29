<?php

use Illuminate\Database\Capsule\Manager as DB;
use v2\Models\UserWithdrawalMethod;
use v2\Models\Withdrawal;
use v2\Shop\Shop;



use League\Csv\Writer;
use League\Csv\Reader;
use League\Csv\Statement;




/**
 *
 */
class WithdrawalsController extends controller
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






    public function process_bulk_action()
    {

        $model_register = [
            'withdrawal' => [
                'model' => 'v2\Models\Withdrawal',
            ],
        ];

        $model = $model_register[$_POST['model']]['model'];
        $response =     $model::bulk_action($_POST['action'], $_POST['records']);

        if ($response || false) {
            Redirect::back();
        }

    }



    public function process($withdraw_id, $gateway)
    {
        if (!$this->admin()) {
            die();
        }

        echo "<pre>";

        $withdrawal = Withdrawal::find($withdraw_id);

        if ($withdrawal == null) {
            Session::putFlash('danger', "Invalid Request.");
            Redirect::back();
        }

        if ($withdrawal->is_complete()) {

            Session::putFlash('danger', "Already  completed.");
            Redirect::back();
        }


        switch ($withdrawal->withdrawal_method->method) {
            case 'bitcoin':


                $shop = new Shop();
                $attempt = $shop
                    ->setPaymentMethod('livepay')
                    ->setWithdrawalRequest($withdrawal);
                break;

            default:
                # code...
                break;
        }


    }

    public function push($withdraw_id, $status)
    {
        if (!$this->admin()) {
            die();
        }


        $withdrawal = Withdrawal::find($withdraw_id);

        if ($withdrawal == null) {
            Session::putFlash('danger', "Invalid Request.");
            Redirect::back();
        }

        if ($withdrawal->is_complete()) {

            Session::putFlash('danger', "Already  completed.");
            Redirect::back();
        }


        DB::beginTransaction();

        try {

            $withdrawal->update([
                'status' => $status,
                'admin_id' => $this->admin()->id,
            ]);

            DB::commit();
            Session::putFlash('success', "Withdrawal marked as $status");

        } catch (Exception $e) {
            DB::rollback();
            Session::putFlash('danger', "Something went wrong. Please try again.");
        }


        Redirect::back();

    }


    public function submit_withdrawal_request()
    {

        echo "<pre>";
        print_r($_POST);

        $auth = $this->auth();
        $balances = Withdrawal::payoutBalanceFor($auth->id);


        $this->validator()->check(Input::all(), array(
            'method' => [
                'required' => true,
            ],
            'amount' => [
                'required' => true,
                'positive' => true,
                'min_value' => $balances['min_withdrawal'],
            ],
        ));


        if (!$this->validator->passed()) {
            Session::putFlash('danger', Input::inputErrors());
            Redirect::back();
        }

        // $this->verify_2fa();

        $currency = Config::currency();

        $amount_requested = $_POST['amount'];
        $fee = $amount_requested * 0.01 * $balances['withdrawal_fee'];
        $total_amount_to_debit = $amount_requested;


        //ensure user can withdraw;
        if ($total_amount_to_debit > $balances['available_payout_balance']) {
            $balance = MIS::money_format($balances['available_payout_balance']);
            Session::putFlash('danger', "Insufficient Balance:<code> $currency $balance </code> <br> 
				Requesting: <code>$currency$total_amount_to_debit </code> (Fee inclusive)");
            Redirect::back();
        }


        //ensure method exists and belongs to user
        $method_details = UserWithdrawalMethod::where('id', $_POST['method'])->where('user_id', $auth->id)->first();
        if ($method_details == null) {
            Session::putFlash('danger', "Withdrawal method does not exist");
            Redirect::back();
        }


        DB::beginTransaction();

        try {

            $withdrawal = Withdrawal::create([
                'user_id' => $auth->id,
                'withdrawal_method_id' => $_POST['method'],
                'amount' => $total_amount_to_debit,
                'method_details' => json_encode($method_details->toArray()),
                'fee' => $fee,
            ]);

            DB::commit();
            Session::putFlash('success', "Withdrawal initiated successfully");

        } catch (Exception $e) {
            DB::rollback();
            Session::putFlash('danger', "Something went wrong. Please try again.");
        }


        Redirect::back();
    }


    public function submit_withdrawal_information($value = '')
    {

        $encoded_details = json_encode($_POST['details']);


        $this->validator()->check(Input::all(), array(
            'method' => [
                'required' => true,
            ],
            'payment_method' => [
                // 'required'=> true,
            ],

            'details' =>[
                'replaceable'=> "v2\Models\UserWithdrawalMethod|{$this->auth()->id}|user_id",
            ]

        ));

        $auth = $this->auth();


        if (!$this->validator->passed()) {
            Session::putFlash('danger', Input::inputErrors());
            Redirect::back();
        }


        // $this->verify_2fa();


        $available_methods = UserWithdrawalMethod::$method_options;
        $decoded_method = MIS::dec_enc('decrypt', $_POST['method']);

        if (!array_key_exists($decoded_method, $available_methods)) {
            Session::putFlash('danger', Input::inputErrors());
            Redirect::back();
        }

        $option = $available_methods[$decoded_method];

        DB::beginTransaction();

        try {

            $user_withdrawal = UserWithdrawalMethod::updateOrCreate([
                'user_id' => $auth->id,
                'method' => $decoded_method,
            ],
                [
                    'details' => ($encoded_details)
                ]);


            $resolve = $user_withdrawal->AccountHolder;

            if ($resolve == null) {

                throw new Exception("Error Processing Request", 1);
            }

            $detail = $user_withdrawal->DetailsArray;
            $detail['account_name'] = $resolve;

            $user_withdrawal->update(['details' => json_encode($detail)]);


            DB::commit();
            Session::putFlash('success', "$option[name] changes saved");


        } catch (Exception $e) {
            DB::rollback();
            Session::putFlash('success', "Something went wrong. Please try again.");

        }


        Redirect::back();
    }

}


?>