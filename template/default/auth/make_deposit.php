<?php
$page_title = "Make Deposit";
 include 'includes/header.php';



   $rules_settings =  SiteSettings::find_criteria('rules_settings');
   $min_deposit = $rules_settings->settingsArray['min_deposit_usd'];


 ;?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6  mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Make Deposit</h3>
          </div>
          
          <div class="content-header-right col-6">
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
              <a class="btn btn-outline-primary" href="javascript:void(0);">
                Current Bal: 
                <?=$currency;?><?=MIS::money_format($deposit_balance);?>
              </a>
              <!-- <a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a> -->
            </div>
          </div>
        </div>
        <div class="content-body">


          <div class="row" >
            <div class="col-12">
              <div class="card">
                <div class="card-header"  data-toggle="collapse" data-target="#make_deposit">
                  <h1 href="javascript:void;" class="card-title">Make Deposit</h1>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                  </div>

                </div>
                <div class="card-body collapse show" id="make_deposit">

                  <form class="col-12" method="POST" action="<?=domain;?>/user/submit_make_deposit" data-function="initiate_payment">
                    <small>Minimum Deposit: <?=$currency;?><?=MIS::money_format($min_deposit);?></small><br>
                    <hr />

                    <div class="form-group">
                      <label>Amount (<?=$currency;?>)</label>
                      <input type="number" step="1" min="<?=$min_deposit;?>" name="amount" required="" class="form-control">
                    </div>


                    <div class="form-group">
                      <label>Select Processor</label>
                      <select class="form-control" required="" name="payment_method">
                          <option value="">Select Payment method</option>
                          <?php foreach ($shop->get_available_payment_methods() as $key => $option):?>
                              <option value="<?=$key;?>"><?=$option['name'];?></option>
                          <?php endforeach;?>
                      </select>                   
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn">Deposit</button>
                    </div>
                    
                  </form>

                </div>

              </div>
            </div>
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
                 case 'livepay':
                   // code block
                       window.location.href = $base_url+ 
                       "/shop/checkout?item_purchased=packages&order_unique_id="+$data.id+"&payment_method=livepay";

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




          <div class="row" >
            <div class="col-12">
              <div class="card">

                <div class="card-header"  data-toggle="collapse" data-target="#deposit_history">
                  <h1 href="javascript:void;" class="card-title">Deposit History</h1>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                  </div>

                </div>
                <div class="card-body collapse show" id="deposit_history">
                  <table id="myTable" class="table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Amount (<?=$currency;?>)</th>
                      </tr>
                      <!-- <th>Description</th> -->
                    </thead>
                    <tbody>
                      <?php foreach ($deposits as $key => $deposit):?>
                      <tr>
                        <td><?=$deposit->id?></td>
                        <td><?=date("M j Y, H:iA", strtotime($deposit->paid_at));?></td>
                        <td><?=MIS::money_format($deposit->amount);?></td>
                        <!-- <td><?=$deposit->id?></td> -->
                      </tr>
                      <?php endforeach;?>
                    </tbody>
                  </table>
                 

                </div>

              </div>
            </div>
          </div>








        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
