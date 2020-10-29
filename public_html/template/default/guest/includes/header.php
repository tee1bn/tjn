
<!DOCTYPE html>
<html ng-app="app" class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="<?=@$page_description;?>">
    <meta name="keywords" content="<?=@$page_keywords;?>">
    <meta name="author" content="<?=@$page_author;?>">
    <title><?=@$page_title;?> | <?=project_name;?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?=domain;?>/<?=$fav_icon;?>">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/components.min.css">
    <!-- END: Theme CSS-->




    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/core/menu/menu-types/horizontal-menu.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/core/colors/palette-gradient.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/fonts/simple-line-icons/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/core/colors/palette-gradient.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/pages/timeline.min.css">
    <!-- END: Page CSS-->




    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/fonts/meteocons/style.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$asset;?>/vendors/css/charts/morris.css">
    <!-- END: Vendor CSS-->



    <link rel="stylesheet" type="text/css" href="<?=asset;?>/fonts/feather/style.min.css">

    <meta name="google-site-verification" content="uHs718_iV5yGsoQJxVE9s4gKYo7hVzkxcmX_ciw0nTY" />


    <!-- Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '1561914987303002');
      fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=1561914987303002&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-165930205-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-165930205-1');
    </script>


  </head>
  <!-- END: Head-->

  <?php   

  $brokers_in_header = v2\Models\Broker::Active()->get();

  include_once "../app/others/angularjs_installation.php" ; ?>

  <style>
    .app-content{
      min-height: 200px !important;
    }
    
  </style>

  <!-- BEGIN: Body-->
  <body class="horizontal-layout horizontal-menu 2-columns  " data-open="click" data-menu="horizontal-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-white bg-white navbar-border navbar-brand-center">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <ul class="nav navbar-nav flex-row">
            <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
            <li class="nav-item"><a class="navbar-brand" href="<?=domain;?>">
                <!-- <h2 class="brand-text"><?=project_name;?></h2> -->
                <img src="<?=domain;?>/<?=$logo;?>" style="height: 34px; width:auto;">

              </a></li>
            <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
          </ul>
        </div>
        <div class="navbar-container content">
          <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="nav navbar-nav mr-auto float-left">
            </ul>

            <ul class="nav navbar-nav float-right">

         
              <!-- 
              <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail"></i><span class="badge badge-pill badge-warning badge-up">3</span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                  <li class="dropdown-menu-header">
                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Messages</span><span class="notification-tag badge badge-warning float-right m-0">4 New</span></h6>
                  </li>
                  <li class="scrollable-container media-list"><a href="javascript:void(0)">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="<?=$asset;?>/images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">Margaret Govan</h6>
                          <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p><small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time></small>
                        </div>
                      </div></a><a href="javascript:void(0)">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-busy rounded-circle"><img src="<?=$asset;?>/images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">Bret Lezama</h6>
                          <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p><small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Tuesday</time></small>
                        </div>
                      </div></a><a href="javascript:void(0)">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="<?=$asset;?>/images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">Carie Berra</h6>
                          <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p><small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Friday</time></small>
                        </div>
                      </div></a><a href="javascript:void(0)">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-away rounded-circle"><img src="<?=$asset;?>/images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">Eric Alsobrook</h6>
                          <p class="notification-text font-small-3 text-muted">We have project party this saturday.</p><small>
                            <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">last month</time></small>
                        </div>
                      </div></a></li>
                  <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all messages</a></li>
                </ul>
              </li> -->


                        <?php include_once 'template/default/composed/auth_dropdown.php'; ;?>

            </ul>
          </div>
        </div>
      </div>
    </nav>
    <!-- END: Header-->



    <!-- BEGIN: Main Menu-->
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-shadow menu-border" role="navigation" data-menu="menu-wrapper">
      <!-- Horizontal menu content-->
      <div class="navbar-container main-menu-content" data-menu="menu-container" style="margin: auto;">
        <!-- include ../../../includes/mixins-->
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">

          <li class=" nav-item" data-menu="">
            <a class="-toggle nav-link" href="<?=domain;?>" data-toggle="">
              <i class="ft-home"></i>
              <span>Home</span></a>
          </li>


     <!-- 
          <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
            <i class="ft-users"></i><span>About</span></a>

            <ul class="dropdown-menu">
              <li class="" data-menu=""><a class="dropdown-item" href="<?=domain;?>/blog" data-toggle="dropdown">Company News</a></li>
              <?php foreach ($brokers_in_header as $key => $broker_in_header) :?>

                <li class="" data-menu="">
                   <a class="dropdown-item" href="<?=domain;?>/about/broker/<?=MIS::dec_enc('encrypt',$broker_in_header->id);?>" 
                    data-toggle="dropdown"><?=$broker_in_header->name;?></a>
                </li>

              <?php endforeach;?>
            </ul>

          </li>
           -->

           <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
             <i class="ft-users"></i><span>Traders</span></a>

             <ul class="dropdown-menu">
               <li class="" data-menu=""><a class="dropdown-item" href="<?=domain;?>/fx-signals" data-toggle="dropdown">Forex Signals</a></li>
               <li class="" data-menu=""><a class="dropdown-item" href="<?=domain;?>/event-calendar" data-toggle="dropdown">Event Calendar</a></li>
               <li class="" data-menu="">
                <a class="dropdown-item" target="_blank" href="<?=$brokers_in_header->first()->DetailsArray['copy_trading'];?>" data-toggle="dropdown">
                  <b><?=$brokers_in_header->first()->name;?></b> Copy Trading</a></li>
               
             </ul>

           </li>

          <li class=" nav-item" data-menu="">
            <a class="-toggle nav-link" href="<?=domain;?>/courses/1/access" data-toggle="">
              <i class="ft-bookmark"></i>
              <span>Fx Academy</span></a>
          </li>
          
          <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
            <i class="ft-box"></i><span>Open Account</span></a>
            <ul class="dropdown-menu">
              <?php foreach ($brokers_in_header as $key => $broker_in_header) :?>

                <li class="" data-menu="">
                   <a class="dropdown-item"  target="_blank"
                   href="<?=domain;?>/forex-account/open-live-account/<?=MIS::dec_enc('encrypt',$broker_in_header->id);?>" 
                    data-toggle="dropdown"><small><b><?=$broker_in_header->name;?></b> Live Account</small></a>
                </li>

                <li class="" data-menu="">
                   <a class="dropdown-item"  target="_blank"
                   href="<?=domain;?>/forex-account/open_demo_account/<?=MIS::dec_enc('encrypt',$broker_in_header->id);?>" 
                    data-toggle="dropdown"><small><b><?=$broker_in_header->name;?></b> Demo Account</small></a>
                </li>


              <?php endforeach;?>

            </ul>
          </li>
      

          <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
            <i class="ft-phone"></i><span>Support</span></a>
            <ul class="dropdown-menu">
              <li class="active" data-menu=""><a class="dropdown-item" href="<?=domain;?>/faqs" data-toggle="dropdown">Faqs</a>
              </li>
              <li data-menu=""><a class="dropdown-item" href="<?=domain;?>/contact-us" data-toggle="dropdown">Contact us</a>
              </li>
              <!-- <li data-menu=""><a class="dropdown-item" href="<?=domain;?>/blog" data-toggle="dropdown">Blog</a> -->
              </li>
            </ul>
          </li>
      
          <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
            <i class="ft-lock"></i><span>Personal Area</span></a>
            <ul class="dropdown-menu">

              <?php foreach ($brokers_in_header as $key => $broker_in_header) :?>

                <li class="" data-menu="">
                   <a class="dropdown-item" target="_blank" href="<?=$broker_in_header->ClientCabinet;?>" 
                    data-toggle="dropdown"><small>Log in to <b><?=$broker_in_header->name;?></b> Personal Area</small></a>
                </li>

              <?php endforeach;?>

              </li>
            </ul>


          </li>
            
          
          <li class="dropdown nav-item d-block d-sm-none"  data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown">
            <i class="ft-user"></i><span>9gforex Profile</span></a>

            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?=domain;?>/register"><i class=""></i> Sign Up</a></li>
              <li><a class="dropdown-item" href="<?=domain;?>/login"><i class=""></i> Sign In</a></li>
            </ul>
          </li>


      
        </ul>

      </div>
      <!-- /horizontal menu content-->
    </div>
    <!-- END: Main Menu-->

