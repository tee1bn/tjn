<?php


use Illuminate\Database\Eloquent\Model as Eloquent;
require_once "app/controllers/home.php";


class Menu 
{
	
	public static function get_menu()
	{
		$domain = Config::domain();
		$controller = new home;
		$auth = $controller->auth();

	 $main_menu =  [

		[
			'menu' => '<i class="ft-home"></i> Dashboard',
			'link' =>  "$domain/user/dashboard",
			'show'=> true,
			'index'=> 1,
		],

		[
			'menu' => "<i class='ft-users'></i>My Profile $auth->DisplayCompleteProfileStatus",
			'link' =>  "$domain/user/profile",
			'show'=> true,
			'index'=> 2,
		],





		[
			'menu' => '<i class="fa fa-list"></i> Transactions',
			'link' =>  '#',
			'show'=> true,
			'index'=> 3,
			'submenu' => [

				[
					'menu'       => 'Make Withdrawals',
					'link'       => "$domain/user/make-withdrawal",
					'show'=>false,
					'index'=>4,
				],


				[
					'menu' => "Commissions",
					'link' =>  "$domain/user/commissions",
					'show'=> true,
					'index'=> 14,
				],


				[
					'menu'       => 'Payouts',
					'link'       => "$domain/user/payouts",
					'show'=>true,
					'index'=>5,
				],


			]

		],


		[
			'menu' => '<i class="fa fa-briefcase"></i> Packages',
			'link' =>  '#',
			'show'=> true,
			'index'=> 6,
			'submenu' => [
				[
					'menu'       => 'All Packages',
					'link'       => "$domain/user/package",
					'show'=>true,
					'index'=>7,
				],

				[
					'menu'       => 'Merchant Packages',
					'link'       => "$domain/user/merchant-packages",
					'show'=>true,
					'index'=>8,
				],

				[
					'menu'       => 'Partner Packages',
					'link'       => "$domain/user/partner-packages",
					'show'=>true,
					'index'=>9,
				],

				[
					'menu'       => 'My Invoices',
					'link'       => "$domain/user/my-invoices",
					'show'=>true,
					'index'=>10,
				],



			]                                                    
		],  




		[
			'menu' => '<i class="ft-users"></i>My Team</span>',
			'link' =>  '#',
			'show'=> true,
			'index'=> 11,
			'submenu' => [
				[
					'menu'       => 'Team Overview',
					'link'       => "$domain/genealogy/team",
					'show'=>true,
					'index'=>12,
				],

				[
					'menu'       => 'Team Tree',
					'link'       => "$domain/genealogy/team_tree",
					'show'=>true,
					'index'=>13,
				],





			]                                                    
		],  

/*

      [
        'menu' => "<i class='ft-align-justify'></i>Commissions",
        'link' =>  "$domain/user/commissions",
        'show'=> true,
        'index'=> 14,
      ],
*/
      [
      	'menu' => "<i class='ft-star'></i>InvitePro",
      	'link' =>  "$domain/user/invite-pro",
      	'show'=> true,
      	'index'=> 15,
      ],

      [
      	'menu' => "<i class='ft-airplay'></i>Events & Webinar",
      	'link' =>  "$domain/user/events-and-webinar",
      	'show'=> true,
      	'index'=> 16,
      ],



      [
      	'menu' => "<i class='fa fa-film'></i>Media Center",
      	'link' =>  "$domain/user/media",
      	'show'=> true,
      	'index'=> 18,
      ],


      [
      	'menu' => "<i class='ft-shopping-cart'></i> Shop",
      	'link' =>  "$domain/user/online-shop",
      	'show'=> true,
      	'index'=> 19,
      	'submenu' => [
      		[
      			'menu'       => 'Online Shop',
      			'link'       => "$domain/user/online-shop",
      			'show'=>true,
      			'index'=>19,
      		],

      		[
      			'menu'       => 'Orders',
      			'link'       => "$domain/user/products-orders",
      			'show'=>true,
      			'index'=>19,
      		],                                                    

      	]                                                    

      ],




      [
      	'menu' => '<i class="ft-shopping-cart"></i>Shop</span>',
      	'link' =>  '#',
      	'show'=> false,
      	'index'=> 20,
      	'submenu' => [
      		[
      			'menu'       => 'Online Shop',
      			'link'       => "$domain/user/online-shop",
      			'show'=>true,
      			'index'=>21,
      		],

      		[
      			'menu'       => 'Orders',
      			'link'       => "$domain/user/products-orders",
      			'show'=>true,
      			'index'=>22,
      		],                                                    

      	]                                                    
      ],  



      [
      	'menu' => '<i class="fa fa-question-circle-o"></i>Support</span>',
      	'link' =>  '#',
      	'show'=> true,
      	'index'=> 23,
      	'submenu' => [
      		[
      			'menu'       => 'Support Tickets',
      			'link'       => "$domain/user/support",
      			'show'=>true,
      			'index'=>24,
      		],

      		[
      			'menu'       => 'Contact us',
      			'link'       => "$domain/user/contact-us",
      			'show'=>true,
      			'index'=>25,
      		],                                                    

      	]                                                    
      ],  


      [
      	'menu' => "<i class='fa fa-folder-o'></i>Downloads",
      	'link' =>  "$domain/user/downloads",
      	'show'=> true,
      	'index'=> 26,
      ],


      [
      	'menu' => "<i class='fa fa-file-text-o'></i>News",
      	'link' =>  "$domain/user/broadcast",
      	'show'=> false,
      	'index'=> 27,
      ],


      [
      	'menu' => "<i class='ft-power'></i>Log Out",
      	'link' =>  "$domain/login/logout",
      	'show'=> true,
      	'index'=> 28,
      ],

  ];   

  return $main_menu;
}

}


















?>