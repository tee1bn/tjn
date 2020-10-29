<?php
$page_title = "Package";
 include 'includes/header.php';

 ;?>




    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Package</h3>
          </div>
          
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
                    <p class="card-text">Excluding VAT <?=(int)$subscription->percent_vat;?>% </p>
                    <ul class="list-group list-group-flush">
                      <?php foreach ($subscription->featureslist as $feature):?>

                          <li class="list-group-item small-padding">
                            <span class="badge badge-pill bg-primary float-right"><i class="fa fa-check"></i></span>
                            <?=$feature;?>
                          </li>
                                                                           
                      <?php endforeach;?>
                  </ul>
                  <br>
                  <?php if (@$auth->subscription->plandetails['price']  < $subscription->price):?>
                   <form 
                      id="upgrade_form<?=$subscription->id;?>"
                      method="post"
                      class="ajax_form"
                      data-overlay="in"
                      data-function="initiate_payment"
                      action="<?=domain;?>/user/create_upgrade_request">

                    <div class="form-group">
                     <select class="form-control" required="" name="payment_method">
                         <option value="">Select Payment method</option>
                         <?php foreach ($shop->get_available_payment_methods() as $key => $option):?>
                             <option value="<?=$key;?>"><?=$option['name'];?></option>
                         <?php endforeach;?>
                     </select>
                    </div>
                    <input type="hidden" name="subscription_id" value="<?=$subscription->id;?>">

                    <div class="form-group">
                      <button href="#" class="btn btn-outline-teal">Buy</button>
                    </div>
                    </form>
                    <?php endif ;?>

                    <?php if (@$auth->subscription->plandetails['id']  == $subscription->id):?>
                    <div class="form-group">
                      <button type="button" class="btn btn-success btn-sm">Current</button>
                      <small><?=$auth->subscription->NotificationText;?></small>
                    </div>
                    <?php endif ;?>

                  </div>
                </div>
              </div>
            </div>
          
          <?php endforeach;?>
              </div>
              
            

              <script>
                initiate_payment= function($data){
                  
                  switch($data.payment_method) {
                     case 'coinpay':
                       // code block
                           window.location.href = $base_url+ 
                           "/shop/checkout?item_purchased=packages&order_unique_id="+$data.id+"&payment_method=coinpay";

                       break;

                     case 'paypal':
                       // code block
                           window.location.href = $base_url+ 
                           "/shop/checkout?item_purchased=packages&order_unique_id="+$data.id+"&payment_method=paypal";

                       break;
                     case 'razor_pay':
                       // code block
                       window.SchemeInitPayment($data.id);
                       break;
                     default:
                       // code block
                   }
                }
              </script>

        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
