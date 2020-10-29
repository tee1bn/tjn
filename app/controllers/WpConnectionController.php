<?php
use wp\Models\User as WpUser;
use Illuminate\Database\Capsule\Manager as DB;

// use User, Validator;
/**
 * this class is the default controller of our application,
 *
 */
class WpConnectionController extends controller
{


    public function __construct()
    {

        if (!$this->admin()) {

            $this->middleware('current_user')
                ->mustbe_loggedin();
        }


        $this->setting = SiteSettings::site_settings();


    }


    public function confirm()
    {   

        $user_email = $_POST['email'];
        $id = $_POST['id'];
        $user = WpUser::where('user_email', $user_email)->where('ID', $id)->first();

        if ($user==null) {
            Session::putFlash("danger","Could not resolve");
            return;
        }
        
        $data = ['wp_user_id' => $id];

        $validator = new Validator;

        $validator->check($data, array(
            'wp_user_id' => [
                'required'=> true,
                'unique'=> 'User',
            ],
        ));


        if (! $validator->passed()) {
            Session::putFlash("danger", "This email is taken");
            return;
        }


        $auth= $this->auth();

        DB::beginTransaction();

        try {

            $auth->tie_to_wp_user_with_id($user->ID);
            DB::commit();
            Session::putFlash("success", "Connected Successfully");


            
            $response = true;


        } catch (Exception $e) {
            $response = false;
            DB::rollback();
            
        }


        header("content-type:application/json");
        echo json_encode(compact('response'));

    }
    public function connect()
    {


        $user_email = $_POST['email'];
        $user = WpUser::where('user_email', $user_email)->first();

        if ($user==null) {
            Session::putFlash("danger","Record not found");
            return;
        }
        
        $view = $this->buildView('composed/wp_user_detail', compact('user'), null, true);

        // $data, $action, $button, $function='', $require_confirmation=false


        $domain = Config::domain();
        $action = "$domain/connect/confirm";
        $confirmation = MIS::generate_form([
            'email'=>$user_email,
            'id'=>$user->ID,
        ], $action, 'Confirm', 'finish_connection');

        $view .= $confirmation ;
        $response = compact('view');
        
        header("content-type:application/json");
        echo json_encode($response);
    }

    public function wp()
    {      
        if ($this->auth()->wp_user != null) {

            Session::putFlash("danger","Connection already exist");
            Redirect::back();
        }

        $this->view('auth/wp');
    }


}


?>