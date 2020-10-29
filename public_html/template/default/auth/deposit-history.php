<?php
$page_title = "Deposit History";
include 'includes/header.php';

$financial_banks = v2\Models\FinancialBank::all();
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">

    <div class="content-body">

      <div class="app-content">
          <div class="content-header row">
            <div class="content-header-left col-6 mb-2">
              <h3 class="content-header-title mb-0">Deposit History</h3>
            </div>
          <div class="content-header-right text-right col-6">
              <a class="btn btn-outline-dark" href="<?=domain;?>/user/make-deposit"> Make Deposit</a>
          </div>

          </div>
          <div class="content-body">


<div class="alert alert-dark alert-dismissible" >
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Info!</strong> Please click the notify button to inform us that you have made payment.
</div>
         
            <div class="card">
             <div  class="card-content collapse show">
              <div class="card-body card-dashboard">

              <?php include_once 'template/default/composed/filters/user_deposits.php';?>          

               <p class="card-text float-right" style="display: inline;">List of Deposits - <?=$deposits->count();?></p>
                <table id="payment-histor" class="table table-striped table-bordered zero-configuration">
                  <tbody>

                    <?php foreach ($deposits as $key => $deposit):?>

                      <tr>
                        <td style="padding: 2px;">
                          <div class="col-md-12" style="padding: 0px;">
                            <div class="alert bg-dark " role="alert" style="overflow: auto;">
                              <small class="float-left">
                               Order: $<?=$deposit->amount;?><br>
                               Payable: <?=$currency;?> 
                               <?=$deposit->amount_payable;?><br>
                               <?=$deposit->PaidStatus;?>
                               <?=$deposit->DisplayStatus;?><br><br>

                               <?php if (in_array($deposit->status, ['initialized'])) :?>
                                <button title="Use this button to notify us that you have made payment. This will speed up the process." onclick="$confirm_dialog = 
                                new ConfirmationDialog('<?=domain;?>/user/notify_deposit/<?=$deposit->encrypt_id();?>', 'Only paid deposit will be processed. Have you paid <?=$currency;?><?=MIS::money_format($deposit->paymentBreakdownArray['total_payable']['value']);?> ? <br><small class=\'text-danger\'>* False notification is not allowed.</small>');" 
                                class="btn btn-sm btn-warning">Notify</button> 
                              <?php endif;?>
                             </small>
                             <small>
                               <span class="float-right text-right">
                                ID:<?=$deposit->TransactionID;?><br>
                                <?= date('M j Y, h:iA', strtotime($deposit->created_at));?><br>
                                <small>-Acc No:  </small><?=$deposit->account_number;?><br> <?=$deposit->broker->name;?>
                              </span> 
                            </small>
                            <br>
                          </div>
                        </div>

                      </td>
                    </tr>
                  <?php endforeach;?>
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>

      <ul class="pagination">
        <?= $this->pagination_links($data, $per_page);?>
      </ul>

    </div>
</div>
</div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
