<?php
$page_title = "Payouts";
 include 'includes/header.php';?>
    <script src="<?=asset;?>/angulars/payouts.js"></script>


    <!-- BEGIN: Content-->
    <div class="app-content content" ng-controller="PayoutController" ng-cloak>
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Payouts</h3>
          </div>
          
          <div class="content-header-right col-md-6 col-12">
            <fieldset>
              <div class="input-group">
                <!-- <label>Period </label> -->
                <input type="month" id="schedule_period" ng-model="$month" ng-change="load();" class="form-control">
                <div class="input-group-append" id="button-addon4">
                  <button class="btn btn-primary" ng-click="export_as_pdf();" ng-hide="$month == undefined">Print</button>
                </div>
              </div>
            </fieldset>

          </div>
        </div>
        <div class="content-body">

       
      <section id="video-gallery" class="card">
       <!--  <div class="card-header">
          <h4 class="card-title">Payouts</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
              </div>
        </div> -->
           <div class="card-content">
            <div class="card-body">


              <center ng-click="export_as_pdf();" ng-show="$month == undefined">Please Enter the Period </center>
              <span ng-include="$path"> </span>


              

            </div>
          </div>
      </section>



        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
