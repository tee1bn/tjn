<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="Gitstar Digital">
    <title>Error</title>
    <link rel="apple-touch-icon" href="<?=$logo;?>">
    <link rel="shortcut icon" type="image/x-icon" href="<?=$logo;?>">
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
    <link rel="stylesheet" type="text/css" href="<?=asset;?>/css/pages/error.min.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?=cs;?>/style.css">
    <!-- END: Custom CSS-->

  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu 1-column   blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><section class="flexbox-container">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-lg-4 col-md-8 col-10 p-0">
            <div class="card-header bg-transparent border-0">
                <h2 class="error-code text-center mb-2">404</h2>
                <h3 class="text-uppercase text-center">Page Not Found !</h3>
            </div>
            <div class="card-content">
                <!-- <fieldset class="row py-2">
                    <div class="input-group col-12">
                        <input type="text" class="form-control form-control-xl input-xl border-grey border-lighten-1 " placeholder="Search..." aria-describedby="button-addon2">
                        <span class="input-group-append" id="button-addon2">
                           <button class="btn btn-secondary border-grey border-lighten-1" type="button"><i class="ft-search"></i></button>
                       </span>
                   </div>
                </fieldset> -->
                <div class="row py-2">
                    <div class="col-12  mb-1">
                        <a href="<?=domain;?>" class="btn btn-primary btn-block"><i class="ft-home"></i> Home</a>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="row">
                    <p class="text-muted text-center col-12 py-1">© <span class=""><?=date("Y");?></span>
                     <a href="<?=domain;?>"><?=project_name;?> </a>
                 </p>
                 <p>
                   <!--  <div class="col-12 text-center">
                        <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook"><span class="fa fa-facebook"></span></a>
                        <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter"><span class="fa fa-twitter"></span></a>
                        <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin"><span class="fa fa-linkedin font-medium-4"></span></a>
                        <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-github"><span class="fa fa-github font-medium-4"></span></a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

        </div>
      </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="<?=asset;?>/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="<?=asset;?>/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?=asset;?>/js/core/app-menu.min.js"></script>
    <script src="<?=asset;?>/js/core/app.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="<?=asset;?>/js/scripts/forms/form-login-register.min.js"></script>
    <!-- END: Page JS-->

  </body>
  <!-- END: Body-->
</html>