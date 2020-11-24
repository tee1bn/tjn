

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light navbar-border">
 <!--  <div class=" container" style="padding-top: 10px;">

    <div class="row">


     <div class="col-md-4" style="padding: 30px;">
     </div>

     <style>
       .f-link{
        text-decoration: none;
        color: tomato;
      }
    </style>


    <div class="col-md-3">

      <b>Contact us</b><hr>
      <ul class="nav navbar-nav ml-1">

        <li class="nav-item">
          <i class="fa fa-envelope"></i>
          <b>Support Email</b><br>
          <a href="mailto://<?=$site_setting['support_email']??'';?>"><?=$site_setting['support_email']??'';?></a>
        </li>

        <li class="nav-item">
          <i class="fa fa-phone"></i>
          <b>Phone</b><br>
          <a href="tel://<?=$site_setting['contact_phone']??'';?>"><?=$site_setting['contact_phone']??'';?></a>
        </li>

        <li class="nav-item">
          <i class="fa fa-map-marker"></i>
          <b>Address</b><br>
          <span> <?=$site_setting['contact_address']??'';?></span>
        </li>
      </ul>                

    </div>
    <div class="col-md-3">
      <b>Forex traders</b><hr>
      <ul class="nav navbar-nav ml-1">
      <li class="nav-item"><a href="<?=domain;?>/fx-signals" class="text-muted f-link">Forex Signals</a></li>

      <li class="nav-item"><a href="<?=domain;?>/event-calendar" class="text-muted f-link">Event Calendar</a></li>

      <li class="nav-item"><a href="#" class="text-muted f-link"></a></li>
    </ul>                

  </div>
  <div class="col-md-2">

    <b>Socials</b><hr>
    <ul class="nav navbar-nav ml-1" style="display: inline;">
      <li class="nav-" style="display: inline;"><a href="<?=$site_setting['facebook']??'';?>"><i class="ft-facebook fa-3x"></i></a></li>
      <li class="nav-" style="display: inline;"><a href="<?=$site_setting['twitter']??'';?>"><i class="ft-twitter fa-3x"></i></a></li>
      <li class="nav-" style="display: inline;"><a href="<?=$site_setting['instagram']??'';?>"><i class="ft-instagram fa-3x"></i></a></li>

    </ul>                

    <br>

  </div>




</div>
</div> -->

<p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2">
         <!--  <small class="" style="color: #00000061; font-size: 10px;">
            <b class="text-danger">RISK WARNING </b>: Foreign Exchange Trading and Investments is not suitable for many members of the public, it has large potential rewards, but also large potential risks. Please do not trade with borrowed money or money you cannot afford to lose. This website does not take into account special investment goals, situations or specific requirements of individual users.  All information on this website is provided as general market commentary and does not constitute investment advice. We will not accept liability for any loss or damage, including without limitation to, any loss of profit, which may arise directly or indirectly from the use of or reliance on such information. Please remember that the past performance of any trading system or methodology is not necessarily indicative of future results.
          </small> -->

          <div class="text-center" style="color: #00000061; font-size: 12px;">
            <span class=""> 
              Copyright  &copy;<?=date("Y");?> All rights reserved. 
            </span>
          </div>
        </p>

      </footer>
     
      <!-- END: Footer-->


      <!-- BEGIN: Vendor JS-->
      <script src="<?=$asset;?>/vendors/js/vendors.min.js"></script>
      <!-- BEGIN Vendor JS-->



<!-- 
    <script src="<?=asset;?>/vendors/js/extensions/jquery.steps.min.js"></script>
    <script src="<?=asset;?>/js/scripts/forms/wizard-steps.min.js"></script> -->

    <script src="<?=$asset;?>/vendors/js/ui/jquery.sticky.js"></script>
    <!-- BEGIN: Page Vendor JS--><!-- 
    <script src="<?=$asset;?>/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="<?=$asset;?>/vendors/js/charts/raphael-min.js"></script>
    <script src="<?=$asset;?>/vendors/js/charts/morris.min.js"></script>
    <script src="<?=$asset;?>/vendors/js/extensions/unslider-min.js"></script>
    <script src="<?=$asset;?>/vendors/js/timeline/horizontal-timeline.js"></script> -->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="<?=$asset;?>/js/core/app-menu.min.js"></script>
    <script src="<?=$asset;?>/js/core/app.min.js"></script>
    <!-- <script src="<?=$asset;?>/js/scripts/customizer.min.js"></script> -->
    <!-- END: Theme JS-->


    <?php       //require_once "app/others/drift_installation.php" ; ?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- 
 <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5e89e51af4a2b3001991f56b&product=sticky-share-buttons&cms=sop' async='async'></script> -->


    <!-- BEGIN: Page JS--><!-- 
    <script src="<?=$asset;?>/js/scripts/ui/breadcrumbs-with-stats.min.js"></script>
    <script src="<?=$asset;?>/js/scripts/pages/dashboard-ecommerce.min.js"></script> -->
    <!-- END: Page JS-->

  </body>
  <!-- END: Body-->
  </html>