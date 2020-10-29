<?php
@session_start();

// use Illuminate\Database\Eloquent\Model as Eloquent;

class admin_user_role_check extends controller
{
	// list of accessable controleers based on user role

	public $admin_access = ['admin_users', 'admin_posts' , 'admin_dashboard', 'admin_media', 'admin_newsletter', 'admin_comment', 'admin_site_identity']; 
	public $sub_admin_access = ['admin_posts' , 'admin_dashboard', 'admin_media', 'admin_newsletter', 'admin_comment'];
	public $writer_access = ['admin_posts' , 'admin_dashboard', 'admin_media'];
	public $access ;

	public function __construct(){
/*
		if(!$this->logged_in()){
$this->view('admin/login');  //note this is a path to the view
		die();
	}*/
	}
	




public function has_role($controller , $role){


switch ($role) {
    case "writer":
	$this->access = $this->writer_access   ;
	     break;
    case "sub_admin":
	$this->access = $this->sub_admin_access   ;
        break;
    case "admin":
	$this->access = $this->admin_access   ;
        break;
   
}


	
	
if(in_array("$controller", $this->access )){ //if user has permission to reach contoller
// echo " can acces this page";
 return true;

		}else{
echo "cant acees thid page";	
echo headers_sent() ; 

header("Location: $this->domain/admin_dashboard");
		
die();
}

}



}


















?>