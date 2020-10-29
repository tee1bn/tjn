<?php
$page_title = "User Transfer";
 include 'includes/header.php';

 $rules_settings =  SiteSettings::find_criteria('rules_settings');
 $transfer_fee = $rules_settings->settingsArray['user_transfer_fee_percent'];
 $min_transfer = $rules_settings->settingsArray['min_transfer_usd'];


 ;?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6  mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Transfer</h3>
          </div>
          
          <div class="content-header-right col-6">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <a class="btn btn-outline-dark" href="javascript:void(0);">
                Current Bal: 
                <?=$currency;?><?=MIS::money_format($balance);?>
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
                  <h1 href="javascript:void;" class="card-title"> Transfer Money</h1>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                      <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                  </div>

                </div>
                <div class="card-body  collapse show " id="make_deposit">

                  <form class="col-12" method="POST" action="<?=domain;?>/user/submit_user_transfers">
                    <small>Deposit Wallet: <?=$currency;?><?=MIS::money_format($balance);?></small><br>
                    <small>Transfer Fee: <?=$transfer_fee;?>% </small><br>
                    <small>Minimum Transfer : <?=$currency;?> <?=$min_transfer;?> </small>
                    <hr>

                    <div class="form-group">
                      <label>Amount to Transfer (<?=$currency;?>)</label>
                      <input type="number" step="1" min="<?=$min_transfer;?>" required="" name="amount" class="form-control">
                    </div>


                    <div class="form-group">
                      <label>From Wallet</label>
                      <select class="form-control" required="" name="wallet">
                          <option value="">Select Wallet</option>
                          <?php foreach ($wallet->available_wallets($auth) as $key => $option):?>
                              <option value="<?=$key;?>"><?=$option['name'];?> &nbsp;&nbsp; (<?=$currency;?><?=$option['balance'];?>) </option>
                          <?php endforeach;?>
                      </select>                   
                    </div>


                    <div class="form-group">
                      <label>To Username</label>
                      <input type="text" min="" required="" name="username" class="form-control">
                    </div>



                    <div class="form-group">
                      <button type="submit" class="btn btn-outline-dark">Transfer</button>
                    </div>
                    
                  </form>

                </div>

              </div>
            </div>
          </div>






        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
