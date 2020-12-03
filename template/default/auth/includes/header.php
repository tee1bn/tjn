
<!DOCTYPE html>
<html ng-app="app" class="" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
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

    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/vendors.min.css">
<!--     <link rel="stylesheet" type="text/css" href="<?=asset;?>/vendors/css/tables/datatable/datatables.min.css">    
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/charts/jquery-jvectormap-2.0.3.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/charts/morris.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/weather-icons/climacons.min.css">
 -->    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/bootstrap-extended.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/colors.min.css"> -->
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/components.min.css">
    <!-- END: Theme CSS-->

    <!-- tree css -->
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/binary-tree.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/core/menu/menu-types/vertical-menu.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/core/colors/palette-gradient.min.css"> -->
    <!-- link(rel='stylesheet', type='text/css', href=app_assets_path+'/css'+rtl+'/pages/users.css')-->
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css" href="<?=asset;?>/fonts/feather/style.min.css">
    <script src="<?=asset;?>/js/jquery1.12.min.js"></script>
  </head>
  <!-- END: Head-->

  <?php include_once "app/others/angularjs_installation.php" ; ?>



  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <!-- <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow"> -->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-light navbar-shadow">
      
      <div class="navbar-wrapper">
        <div class="navbar-header" style="">
          <ul class="nav navbar-nav flex-row">
            <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
              <i class="ft-menu font-large-1"></i></a></li>
            <li class="nav-item"><a class="navbar-brand" href="<?=domain;?>" style="padding: 0px;">
              <img class="brand-logo" alt="<?=project_name;?> logo" src="<?=$logo;?>"
               style="
    height: 45px;
    width: 172px;
    object-fit: contain;
    margin-top: 5px;"></a>
</li>
            <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
          </ul>
        </div>
        <div class="navbar-container content">
          <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="nav navbar-nav mr-auto float-left">
              <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>


              <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i class="ficon ft-maximize"></i></a></li>
              <li id="translator" class="nav-item" style="position: relative;top: 20px;"><div><?php  'template/default/app-assets/translator.php';?> </div></li>

            <!--   <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#"><i class="ficon ft-search"></i></a>
                <div class="search-input">
                  <input class="input" type="text" placeholder="Explore <?=project_name;?>...">
                </div>
              </li> -->
            </ul>
            <ul class="nav navbar-nav float-right">


              <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i><span class="badge badge-pill badge-dark badge-up">
                <?php 
                $unseen_notifications = Notifications::unseen_notifications($auth->id);
                echo $unseen_notifications->count();
              ;?></span></a>

                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                  <li class="dropdown-menu-header">
                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span><span class="notification-tag badge badge-dark float-right m-0">
                      <?=$unseen_notifications->count();?>
                     New</span></h6>
                  </li>
                  <li class="scrollable-container media-list">


                    <?php 

                     foreach ($unseen_notifications as $notification):?>

                    <a href="<?=$notification->DefaultUrl;?>">
                      <div class="media">
                        <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-dark"></i></div>
                        <div class="media-body">
                          <h6 class="media-heading"><?=$notification->heading;?></h6>
                          <div class="notification-text font-small-3 text-muted" style="color: black !important;">
                            <?=$notification->short_message;?>
                          </div>
                            <small><time class="media-meta text-muted" ><?=date("M j Y, h:ia", strtotime($notification->created_at));?></time></small>
                        </div>
                      </div>
                    </a>

                    <?php endforeach ;?>
                    <?php if ($unseen_notifications->count() == 0) :?>
                        <center style="padding: 30px;">Your no notifcations.</center>
                    <?php endif ;?>
                  </li>

                  <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="<?=domain;?>/user/notifications">See all notifications</a></li>
              
                </ul>
              </li>

              <?php include_once 'template/default/composed/auth_dropdown.php'; ;?>


          <!--     <li class="dropdown dropdown-user nav-item">
                <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                  <span class="avatar avatar-online"><img src="<?=domain;?>/<?=$auth->profilepic;?>" alt="avatar">
                    <i></i></span><span class="user-name"><?=$auth->fullname;?></span></a>

                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="<?=domain;?>/user/profile">
                    <i class="ft-user"></i> Profile 
                  </a>
                  <a class="dropdown-item" href="<?=domain;?>/user/change-password"><i class="ft-lock"></i> Change Password</a>
                  <div class="dropdown-divider"></div><a class="dropdown-item" href="<?=domain;?>/login/logout">
                    <i class="ft-power"></i> Logout</a>
                </div>
              </li> -->
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <!-- END: Header-->

    <style>
      
    .card-group,.card-header{

    /*border: 1px solid #c985294a;*/
    }
    </style>


  <?php include 'sidebar.php';?>
  