<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <style>
          body{
              /*background: red !important;*/
              background : url(<?=$asset;?>/images/logo/auth-background.png) !important;
              background-repeat: no-repeat !important;
              background-size: cover !important;

              /*color: white!important;*/
          }

  </style>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="<?=@$page_description;?>">
    <meta name="keywords" content="<?=@$page_keywords;?>">
    <meta name="author" content="<?=@$page_author;?>">
    <title><?=@$page_title;?> | <?=project_name;?></title>
    <link rel="apple-touch-icon" href="<?=$fav_icon;?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?=$fav_icon;?>">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?=asset;?>/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?=asset;?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=asset;?>/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="<?=asset;?>/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=asset;?>/css/components.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=asset;?>/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="<?=asset;?>/css/core/colors/palette-gradient.min.css">
    <link rel="stylesheet" type="text/css" href="<?=asset;?>/css/pages/login-register.min.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?=asset;?>/fonts/feather/style.min.css">
  </head>
  <!-- END: Head-->
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu 1-column   blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper" >
        <div class="content-header row">
        </div>
        <div class="content-body" >
            <section class="flexbox-contain">
                <?php

                    $current_url =    MIS::current_url();
                    if ($current_url == 'register') {
                        $col =4;
                    }else{

                        $col = 4;
                    }
                ;?>

    <style type="text/css">
     

        input, select{
/*
            border: none !important;
            background: #073f2d45 !important;
            color: white !important;*/
        }

        .btn{

            background: black !important;
            /*border: none;*/
        }
        button{
            text-transform: capitalize !important;
        }
        .authcard {
           
           background: #ffffffe6 !important;
        }

        .spanntext{
            background: transparent;  !important;
        }

        fieldset{
            margin-bottom: 4px !important;
        }
    </style>



    <div class="col-md-12 d-flex align-items-center justify-content-center" >
        <div class="col-md-<?=$col;?> box-shado-2 p-0 mt-3" style="
    border-radius: 4px;
    background: url(<?=domain;?>/template/default/app-assets/images/logo/Logo-head.png) !important;
    /*background-attachment: fixed !important;*/
    background-position: center!important;
    background-repeat: no-repeat !important;
    background-size: 248px 257px !important;
">
			<div class="card authcard border-grey border-lighten-3 px-2 py-2 m-0">
				<div class=" authcard card-header border-0" style="background: transparent !important;">
					<div class="card-title text-center">
                        <a href="<?=domain;?>/login/logout"><i class="text-dark float-right fa fa-times"></i></a>
                              <!-- <a href="<?=Config::main_domain();?>" class="pull-right text-dark"  title="Go to Home page"><i class="fa fa-home fa-2x"></i></a> -->

                        <a href="<?=Config::main_domain();?>">
						  <img src="<?=$logo;?>" style="height: 50px;" alt="branding logo">
                        </a>
					</div>


                    