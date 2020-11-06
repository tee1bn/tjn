<?php 

$router =[
	''=>'home',
	'home'=>'home',
	'supportmessages' => 'crud/TicketCrudController',
	'w'=>'home',
	'user'=>'UserController',			//this is used to build all urls of the user dashboard
	'withrawals'=>'WithdrawalsController',		
	'deposits'=>'DepositController',		
	'media' => 'crud/MediaController',

	'document' 			=> 'DocumentController',
	'support' 			=> 'SupportController',

	'user-profile'		=>'UserProfileController',
	'register' 			=> 'RegisterController',
	'login' 			=> 'LoginController',
	'verify' 			=> 'VerificationController',
	'shop' 				=> 'shopController',
	'error' 			=> 'ErrorController',

	'test' => 'test/home',

	'company' => 'api/CompanyController',

	'connect' => 'WpConnectionController',
	'cms_api' => 'CmsApiController',
	'guest' 	=> 'GuestController',
	'terms' 	=> 'TermsController',
	'genealogy' => 'GenealogyController',
	's' 	=> 'SalesController',
	's' 	=> 'shopController',
	'ref' 		=> 'ReferralController', //referral link handler
	'r' 		=> 'ReferralController', //referral link handler
	'forgot-password' 	=> 'forgotPasswordController',

	'auto-match' => 'AutoMatchingController',	//this handles routine checks and commssions

	'settings' => 'SettingsController',
	'testing' => 'testingController',




	'ticket_crud' => 'crud/TicketCrudController',
	'cms_crud' => 'crud/CmsCrud',
	'user_doc_crud' => 'crud/UserDocCrudController',
	'package_crud' => 'crud/PackageCrudController',
	'subscribe' => 'crud/PackageCrudController',
	'paypal' => 'payments/PayPalController', 

	'product' => 'ProductsController', 



	#admin
	'admin-dashboard' => 'AdminDashboardController', 
	'admin' => 'AdminController', 
	'admin-profile' => 'AdminProfileController', 
	'admin-products' => 'AdminProductsController', 
];

