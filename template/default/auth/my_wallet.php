<?php
$page_title = "My Wallet";
include 'includes/header.php';


;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-12  mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0" style="display: inline;">My Wallet</h3> <small>- Withdrawal Information</small>
      </div>

         <!--  <div class="content-header-right col-6">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <a class="btn btn-outline-primary" href="javascript:void(0);">
                Current Bal: 
                <?=$currency;?><?=MIS::money_format($deposit_balance);?>
              </a>
            </div>
          </div> -->
        </div>
        <div class="content-body">

          <?php foreach (v2\Models\UserWithdrawalMethod::$method_options as $key => $option):?>
            <div class="row" >
              <div class="col-12">
                <div class="card">
                  <div class="card-header"  data-toggle="collapse" data-target="#make_deposit<?=$key;?>">
                    <span href="javascript:void;" class="card-title"><?=$option['name'];?> Information</span>
                    <div class="heading-elements">
                      <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      </ul>
                    </div>

                  </div>
                  <div class="card-body  collapse show" id="make_deposit<?=$key;?>">


                    <form class="col-12 ajax_for" method="POST" action="<?=domain;?>/withrawals/submit_withdrawal_information">

                      <input type="hidden" name="method" value="<?=MIS::dec_enc('encrypt',$key);?>">


                      <?php

                        $this->view($option['view']);

                      ;?>

                      <!-- <?=$this->use_2fa_protection();?> -->



                      <div class="form-group">
                        <button type="submit" class="btn btn-outline-dark ">Save</button>
                      </div>

                    </form>

                  </div>

                </div>
              </div>
            </div>

          <?php endforeach;?>






        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?php include 'includes/footer.php';?>
