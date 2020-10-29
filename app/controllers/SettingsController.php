<?php


/**
 * this class is the default controller of our application,
 *
 */
class SettingsController extends controller
{


    public function __construct()
    {

        $this->middleware('administrator')->mustbe_loggedin();
    }


    public function update_payment_settings()
    {
        $settings = json_decode($_POST['settings'], true);


        $payment_gateway = SiteSettings::where('criteria', $_POST['criteria'])->first();

        $payment_gateway->update([
            'settings' => json_encode($settings['json_settings'])
        ]);
        Session::putFlash('success', "{$settings['name']} Changes Saved Successfully!");


    }


    //to pull from db with angularjs
    public function fetch_payment_gateway_settings()
    {
        header("content-type:application/json");

        $payment_gateway_settings = SiteSettings::payment_gateway_settings()->keyBy('criteria');

        foreach ($payment_gateway_settings as $payment_setting) {
            $payment_setting->json_settings = json_decode($payment_setting->settings, true);
            unset($payment_setting->settings);
        }

        echo json_encode($payment_gateway_settings);
    }


    public function fetch_site_settings()
    {
        header("content-type:application/json");
        echo(SiteSettings::where('criteria', 'site_settings')->first()->settings);
    }

    public function update_site_settings()
    {
        print_r($_POST);

        SiteSettings::where('criteria', 'site_settings')->first()
            ->update(['settings' => $_POST['content']]);
        Session::putFlash('success', 'Settings Updated Successfully!');
    }


    public function fetch($criteria)
    {
        header("content-type:application/json");
        echo(SiteSettings::where('criteria', $criteria)->first()->settings);
    }



    public function update($criteria)
    {

        $setting = SiteSettings::where('criteria', $criteria)->first();
        $setting->update(['settings' => $_POST['content']]);

        Session::putFlash('success', "$setting->name Settings Updated Successfully!");
    }

    

    public function update_commission_settings()
    {
        print_r($_POST);

        SiteSettings::where('criteria', 'commission_settings')->first()
            ->update(['settings' => $_POST['content']]);
        Session::putFlash('success', 'Commission Settings Updated Successfully!');
    }


    //to pull from db with angularjs
    public function fetch_admin_bank_details()
    {
        header("content-type:application/json");
        echo(SiteSettings::where('criteria', 'admin_bank_details')->first()->settings);
    }


    public function update_admin_bank_details()
    {
        print_r($_POST);


        SiteSettings::where('criteria', 'admin_bank_details')->first()
            ->update(['settings' => $_POST['content']]);


        Session::putFlash('success', 'Bank Details Updated Successfully!');
    }


    //to pull from db with angularjs
    public function fetch_major_rank_qualification()
    {
        header("content-type:application/json");
        echo(SiteSettings::where('criteria', 'major_rank_qualification')->first()->settings);
    }


    public function update_major_rank_qualification()
    {

        // print_r($_POST);
        $settings = json_decode($_POST['content'], true);

        //remove all js 'hashKeys'
        foreach ($settings as $main_key => $main_class) {
            unset($settings[$main_key]['$$hashKey']);
            foreach ($main_class['sub_ranks'] as $key => $value) {
                unset($settings[$main_key]['sub_ranks'][$key]['$$hashKey']);
            }
        }


        // print_r(json_encode($settings));

        SiteSettings::where('criteria', 'major_rank_qualification')->first()
            ->update(['settings' => json_encode($settings)]);
        Session::putFlash('success', 'Rank Qualifications Updated Successfully!');
    }


}


?>