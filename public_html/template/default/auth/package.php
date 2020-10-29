<?php
$page_title = "Package";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Package</h3>
          </div>
          
         <!--  <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
              </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a>
            </div>
          </div> -->
        </div>
        <div class="content-body">

          <style>
            .small-padding{
              padding: 3px;
            }
          </style>




              <div class="row match-height">   
          <?php foreach (SubscriptionPlan::available()->get() as  $subscription):?>

              <div class=" col-md-4">   
              <div class="card">   
                 <div class="card-content">
                  <div class="card-body">
                    <h4 class="card-title"><?=$subscription->package_type;?></h4>
                    <h6 class="card-subtitle text-muted"> <b class="float-right">
                      <?=$currency;?><?=MIS::money_format($subscription->price);?><!--  /Month --></b>
                    </h6> 
                  </div>

                        <div class="card-body">
                      <!-- <h6 class="card-subtitle text-muted">Support card subtitle</h6> -->
                    <p class="card-text">Exlcuding VAT <?=(int)$subscription->percent_vat;?>% </p>
                    <ul class="list-group list-group-flush">
                      <?php foreach ($subscription->featureslist as $feature):?>

                          <li class="list-group-item small-padding">
                            <span class="badge badge-pill bg-primary float-right"><i class="fa fa-check"></i></span>
                            <?=$feature;?>
                          </li>
                                                                           
                      <?php endforeach;?>
                  </ul>
                  <br>
                   <form 
                      id="upgrade_form<?=$subscription->id;?>"
                      method="post"
                      class="ajax_form"
                      data-function="initiate_payment"
                      action="<?=domain;?>/user/create_upgrade_request">
                      <input type="hidden" name="subscription_id" value="<?=$subscription->id;?>">
                    <button href="#" class="btn btn-outline-teal">Buy</button>
                    </form>

                  </div>
                </div>
              </div>
            </div>
          
          <?php endforeach;?>
              </div>

              <script>
                initiate_payment= function($subscription_order){
                  alert("Thank you. You will be able to complete the process after we integrate a payment method");
                  return;
                }
              </script>

        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
