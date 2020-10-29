<?php 

$router =[
	''=>'home',
	'home'=>'home',
	// 'w'=>'home',
	'user'=>'UserController',			//this is used to build all urls of the user dashboard

	'support' 			=> 'SupportController',

	'user-profile'		=>'UserProfileController',
	'register' 			=> 'RegisterController',
	'login' 			=> 'LoginController',
	'verify' 			=> 'VerificationController',
	'shop' 				=> 'shopController',
	'error' 			=> 'ErrorController',
	'forex-account' 			=> 'AccountController',

	'test' => 'test/home',
	'about' => 'AboutBrokersController',

	'course_api' => 'courses/CoursesApiController',
	// 'courses' => 'courses/CoursesController',
	'courses' => 'courses/FreeCoursesController',
	'instructor' => 'courses/InstructorController',

	'guest' 	=> 'GuestController',
	'blog' 	=> 'BlogController',
	'genealogy' => 'GenealogyController',
	'ref' 		=> 'ReferralController', //referral link handler
	'forgot-password' 	=> 'forgotPasswordController',

	'auto-match' => 'AutoMatchingController',	//this handles routine checks and commssions

	'settings' => 'SettingsController',

	'category_crud' => 'crud/CategorySpoof',
	'campaign_crud' => 'crud/CampaignCrudController',
	'campaign_execution' => 'crud/CampaignExecution',
	'userbankcrud' => 'crud/UserBankCrudController',
	'user_doc_crud' => 'crud/UserDocCrudController',
	'deposit_crud' => 'crud/UserDepositCrudController',
	'offer' => 'crud/OfferController',
	'withdrawal_crud' => 'crud/UserWithdrawalCrudController',
	'ticket_crud' => 'crud/TicketCrudController',
	'access_crud' => 'crud/AccessCrud',
	'survey_crud' => 'crud/SurveyCrud',
	'cms_crud' => 'crud/CmsCrud',
	'media' => 'crud/MediaController',
	'survey_submit' => 'crud/SurveySubmit',
	'survey' => 'SurveyController',
	'signals' => 'SignalsController',


	'survey_crud_2' => 'SurveyCrud2',
	#apis
	'world' => 'api/WorldAPi',


	#admin
	'admin-dashboard' => 'AdminDashboardController', 
	'admin' => 'AdminController', 
	'admin-profile' => 'AdminProfileController', 
	'admin-products' => 'AdminProductsController', 
];

