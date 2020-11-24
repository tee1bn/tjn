<?php
$page_title = "Account plan";
include 'includes/header.php';

;?>




<script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<script src="<?=asset;?>/angulars/payments/rave-checkout.js"></script>



<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Account plan</h3>
      </div>

    </div>
    <div class="content-body">

      <style>
        .small-padding{
          padding: 3px;
        }

        .custom-lightgreen{
          background: #1e7257 ;
        }
      </style>

      <div class="row match-height">   

        <div class="col-md-2 d-none d-lg-block">   
          &nbsp;
        </div>


      <?php foreach (SubscriptionPlan::available()->get() as  $subscription): 
      if ($subscription->price ==0) {continue;}
      ?>

      <div class=" col-md-4">   
        <div class="card">   
         <div class="card-content">
          <div class="card-body">
            <h4 class="card-title"><?=$subscription->name;?></h4>
            <h6 class="card-subtitle text-mute"> <b class="float-right">
              <?=$currency;?><?=MIS::money_format($subscription->price);?>/<?=SubscriptionPlan::$cycle;?></b>
            </h6> 
          </div>

          <div class="card-body">
            <!-- <h6 class="card-subtitle text-mute">Support card subtitle</h6> -->
            <!-- <p class="card-text">Excluding VAT <?=(int)$subscription->percent_vat;?>% </p> -->
            <ul class="list-group list-group-flush">
              <?php foreach (SubscriptionPlan::$benefits as $key => $benefit): ?>

                  <?php if (@$subscription->DetailsArray['benefits'][$key] == 1) :?>
                    <li class="list-group-item use-bg small-padding">
                    <span class="badge bg-success float-right"><i class="fa fa-check"></i></span>
                    <?=$benefit['title'];?>
                    </li>
                    <?php endif ;?>

                <?php endforeach;?>


              <?php foreach (SubscriptionPlan::$comparison as $key => $benefit): ?>
                <li class="list-group-item use-bg small-padding">
                  <?php if ($subscription->DetailsArray['comparison'][$key] == 1) :?>
                    <span class="badge bg-success float-right"><i class="fa fa-check"></i></span>
                    <?php else :?>
                      <span class="badge bg-danger float-right"><i class="fa fa-times"></i></span>
                    <?php endif ;?>
                    <?=$benefit['title'];?>
                  </li>

                <?php endforeach;?>

              <?php foreach ($subscription->FeaturesList as $key => $feature): ?>
                <li class="list-group-item use-bg small-padding">
                    <span class="badge bg-success float-right"><i class="fa fa-check"></i></span>
                    <?=$feature;?>
                  </li>

                <?php endforeach;?>
                
              </ul>
              <pre>
              </pre>
              <br>
              <?php if ($auth->ActiveSubscriptions[$subscription->id] == null):?>
               <form 
               id="upgrade_form<?=$subscription->id;?>"
               method="post"
               class="ajax_form"
               data-overlay="in"
               data-function="initiate_payment"
               action="<?=domain;?>/subscribe/create_upgrade_request">


                <input type="hidden" name="wallet" value="deposit">

               <div class="form-group">
                   <select class="form-control payment_method_selection" required="" name="payment_method">
                       <option value="">Select Payment method</option>
                       <?php foreach ($shop->get_available_payment_methods() as $key => $option): ?>
                           <option value="<?= $key; ?>"><?= $option['name']; ?></option>
                       <?php endforeach; ?>
                   </select>
               </div>


              <input type="hidden" name="subscription_id" value="<?=$subscription->id;?>">
              <br>
              <div class="form-group">
                <button href="#" class="btn btn-outline-dark">Subscribe</button>
              </div>
            </form>
          <?php endif ;?>



          <?php  if ($auth->ActiveSubscriptions[$subscription->id] != null):?>
            <div class="form-group">
              <small><?=$auth->subscriptions[$subscription->id]->NotificationText;?></small>
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

    try {

        switch ($data.gateway) {
            case 'coinpay':
                // code block
                window.location.href = $base_url +
                    "/shop/checkout?item_purchased=packages&order_unique_id=" + $data.order_unique_id + "&payment_method=coinpay";

                break;

            case 'paypal':
                // code block
                window.location.href = $base_url +
                    "/shop/checkout?item_purchased=packages&order_unique_id=" + $data.order_unique_id + "&payment_method=paypal";

                break;


                case 'bank_transfer':

                  window.location.href = $base_url+"/shop/bank-transfer/"+$data.order_unique_id+"/packages";

                break;
                case 'rave':
                  payWithRave($data);
                break;
            default:
            // code block
        }

    } catch (e) {

    }

    
  }
                 </script>

               </div>
             </div>
           </div>
           <!-- END: Content-->

           <?php include 'includes/footer.php';?>
