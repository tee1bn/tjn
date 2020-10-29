<?php
$page_title = "Make Withdrawal";
include 'includes/header.php';


use v2\Models\Withdrawal;
$balances = Withdrawal::payoutBalanceFor($auth->id);

;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6  mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0" style="display: inline;">Make Withdrawal</h3>
      </div>

          <div class="content-header-right col-6">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <a class="btn btn-sm btn-outline-secondary" href="javascript:void(0);">
                Bal: <?=$currency;?><?=MIS::money_format($balances['payout_book_balance']);?>
              </a>
              <a class="btn btn-sm btn-outline-secondary" href="javascript:void(0);">
               Avail Bal: <?=$currency;?><?=MIS::money_format($balances['available_payout_balance']);?>
              </a>
            </div>
          </div>
        </div>
        <div class="content-body">

            <div class="row" >
              <div class="col-12">
                <div class="card">
                  <div class="card-header"  data-toggle="collapse" data-target="#make_deposit">
                    <h1 href="javascript:void;" class="card-title"> Information</h1>
                    <div class="heading-elements">
                      <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      </ul>
                    </div>

                  </div>
                  <div class="card-body collapse show" id="make_deposit">
                      <div class="col-12">
                        
                      <small>Payout: <?=$currency;?><?=MIS::money_format($balances['payout_balance']);?></small><br>
                      <small>Withdrawal Fee: <?=$balances['withdrawal_fee'];?>% </small><br>
                      <small>Minimum Withdrawal: <?=$currency;?><?=MIS::money_format($balances['min_withdrawal']);?></small><br>
                      <hr>
                      </div>
                    <?php if ($balances['available_payout_balance'] > 0):?>

                    <form class="col-12 ajax_for" method="POST" action="<?=domain;?>/withrawals/submit_withdrawal_request">



                      <div class="form-group">
                        <label>Amount (<?=$currency;?>)</label>
                        <input type="number" step="1" min="<?=$balances['min_withdrawal'];?>" name="amount" required="" class="form-control">
                      </div>


                      <div class="form-group">
                        <label>Select Processor</label>
                        <select class="form-control" required="" name="method">
                            <option value="">Select Payment method</option>
                            <?php foreach (v2\Models\UserWithdrawalMethod::ForUser($auth->id)->get() as $key => $option):?>
                                <option value="<?=$option->id;?>"><?=v2\Models\UserWithdrawalMethod::$method_options[$option['method']]['name'];?></option>
                            <?php endforeach;?>
                        </select>                   
                      </div>


                       <!-- <?=$this->use_2fa_protection();?> -->


                      <div class="form-group">
                        <button type="submit" class="btn btn-outline-dark">Submit</button>
                      </div>

                    </form>
                    <?php else:?>

                      <div class="col-12">
                        
                      <center>
                      You need  <?=$currency;?><?=MIS::money_format($balances['min_withdrawal']);?> at least to be able to request a withdrawal.
                      </center>
                      </div>


                    <?php endif ;?>

                  </div>

                </div>
              </div>
            </div>



        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?php include 'includes/footer.php';?>
