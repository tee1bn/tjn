<?php

use Illuminate\Database\Capsule\Manager as DB;

require_once "app/controllers/home.php";


/**
 *
 */
class CmsCrud extends controller
{


    public function fetch_faqs()
    {

        header('content-type:application/json');

        $faq = SiteSettings::where('criteria', 'faqs')->first()->settingsArray;


        print_r(json_encode(compact('faq')));

    }

    public function update_faq()
    {
        print_r($_POST);

        try {

            $faq = SiteSettings::updateOrCreate(
                [
                    'criteria' => 'faqs',
                ],
                [
                    'settings' => $_POST['faq'],
                ]);
            Session::putFlash('success', 'Changes saved Successfully');

        } catch (Exception $e) {
            print_r($e->getMessage());
            Session::putFlash('danger', 'Something went wrong.');
        }
        // Redirect::back();
    }


    public function update_cms()
    {

        echo "<pre>";

        print_r($_POST);

        // $page = CMS::where('criteria', $_POST['criteria'])->first();

        DB::beginTransaction();

        try {

            CMS::updateOrCreate([
                'criteria' => $_POST['criteria']
            ], [
                'settings' => $_POST['settings'],
            ]);


            DB::commit();
            Session::putFlash("success", "Changes Saved");
        } catch (Exception $e) {
            DB::rollback();
            print_r($e->getMessage());
        }

        Redirect::back();
    }


}


?>