<?php

/**
 *
 */
class CompanyController extends controller
{


    public function __construct()
    {

    }


    public function request_for_review()
    {
        $company = $this->auth()->company;
        $response = $company->request_for_review();
        header("content-type:application/json");

        echo json_encode(compact('response'));


    }


    public function delete_document($key)
    {
        $company = $this->auth()->company;
        $response = $company->delete_document($key);
        header("content-type:application/json");

        echo json_encode(compact('response'));


    }


    public function upload_company_supporting_document()
    {

        $company = $this->auth()->company;
        $files = MIS::refine_multiple_files($_FILES['files']);

        $combined_files = array_combine($_POST['label'], $files);

        $response = $company->upload_documents($combined_files);


        // Redirect::back();
    }

    public function fetch_company_list()
    {
        $company = $this->auth()->company;
        header("content-type:application/json");

        $documents = ($company->documents);

        $disable_btn = 'false';
        if (($company->approval_status == 'verifying') && (!$this->admin())) {
            $disable_btn = 'true';
        }

        echo json_encode(compact('documents', 'company', 'disable_btn'));

    }


    public function update_company_logo()
    {

        if ($_FILES['profile_pix']['error'] != 4) {
            echo getcwd();
            $profile_pictures = $this->update_company_logo_img($_FILES);
            Session::putFlash('success', 'Logo Updated Successfully.');
        }

        Redirect::back();
    }


    public function update_company_logo_img($file)
    {

        $directory = 'uploads/companies/logo';
        $handle = new Upload($file['profile_pix']);


        $auth = $this->auth();
        if ($auth->company == null) {

            $company = Company::create([
                'user_id' => $auth->id
            ]);
        } else {

            $company = $auth->company;
        }

        //if it is image, generate thumbnail
        if (explode('/', $handle->file_src_mime)[0] == 'image') {
            $handle->Process($directory);
            $original_file = $directory . '/' . $handle->file_dst_name;
        } else {
            return;
        }

        if ($company->logo != Config::default_profile_pix()) {
            (new Upload($company->logo))->clean();
        }

        $company->update([
            'logo' => $original_file,
        ]);
    }


    public function update_company()
    {

        echo "<pre>";
        print_r($_POST);


        $auth = $this->auth();
        if ($auth->company == null) {

            $company = Company::create([
                'user_id' => $auth->id
            ]);
        } else {

            $company = $auth->company;
        }


        $this->validator()->check(Input::all(), array(

            'name' => [
                'required' => true,
                'min' => 2,
            ],

            'address' => [
                'min' => 3,
            ],

            'iban_number' => [
                'min' => 2,
            ],
        ));


        if (!$this->validator()->passed()) {
            Session::putFlash('danger', "Please try again ");
            return;
        }

        if ($_POST['id'] == '') {


            Company::updateOrCreate(['id' => $_POST['id']],
                [
                    'name' => $_POST['name'],
                    'address' => $_POST['address'],
                    'office_email' => $_POST['office_email'],
                    'iban_number' => $_POST['iban_number'],
                    'office_phone' => $_POST['office_phone'],
                    'pefcom_id' => $_POST['pefcom_id'],
                    'created_by' => $auth->id,
                    'rc_number' => $_POST['rc_number']
                ]);
        } else {

            $existing_company = $auth->company;


            $update = Company::updateOrCreate(['id' => $_POST['id']],
                [
                    'name' => $_POST['name'],
                    'address' => $_POST['address'],
                    'office_email' => $_POST['office_email'],
                    'office_phone' => $_POST['office_phone'],
                    'iban_number' => $_POST['iban_number'],
                    'pefcom_id' => $_POST['pefcom_id'],
                    // 'approval_status' => 'verifying',
                    'rc_number' => $_POST['rc_number']
                ]);

        }

        Session::putFlash('success', "Changes saved successfully.");
        // Redirect::back();
    }


    public function index()
    {

        echo "index function";

    }


}


?>