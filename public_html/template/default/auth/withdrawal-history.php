<?php
$page_title = "Withdrawal History";
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
                      <h3 class="content-header-title mb-0">Withdrawal History</h3>
                    </div>
                    <div class="content-header-right text-right col-6">
                        <a class="btn btn-outline-dark" href="<?=domain;?>/user/make-withdrawal"> Make withdrawal</a>
                    </div>
                  </div>

                  <div class="content-body">

              

                  <div class="card">
                     <div  class="card-content collapse show">
                              <div class="card-body card-dashboard">
                            <?php include_once 'template/default/composed/filters/user_withdrawals.php';?>


                                 <p class="card-text float-right">List of withdrawals - <?=$withdrawals->count();?></p>
                                  <table id="payment-histor" class="table table-striped table-bordered zero-configuration">
                                      <tbody>

                                        <?php foreach ($withdrawals as $key => $withdrawal):?>

                                        <tr>
                                          <td style="padding: 2px;">
                                            <div class="col-lg-12" style="padding: 0px;">
                                              <div class="alert bg-dark " role="alert" style="overflow: auto;">
                                                <small class="float-left">
                                                 Order: $<?=$withdrawal->amount;?><br>
                                                 Payable: <?=$currency;?><?=MIS::money_format($withdrawal->amount_payable);?>
                                                  <br>
                                                      Bank:
                                                        <?=$withdrawal->bank->account_number;?><br>
                                                        <?=$withdrawal->bank->financial_bank->bank_name;?>
                                                </small>
                                                <small>
                                                   <span class="float-right text-right">
                                                    <?=$withdrawal->PaidStatus;?>
                                                    <?=$withdrawal->DisplayStatus;?>
                                                    ID:<?=$withdrawal->trans_id;?><br>
                                                    <?= date('M j Y, h:iA', strtotime($withdrawal->created_at));?>
                                                    <br>
                                                    <small>Acc Num: </small><?=$withdrawal->account_number;?><br><?=$withdrawal->broker->name;?>
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
