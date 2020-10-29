<?php
$page_title = "Trading Accounts";
 include 'includes/header.php';

    $financial_banks = v2\Models\FinancialBank::all();


 ;?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
       
        <div class="content-body">

              <div class="app-content " >

                    <div class="content-wrapper">
                  <div class="content-header row">
                    <div class="content-header-left col-md-6 mb-2">
                      <h3 class="content-header-title mb-0">Trading Accounts</h3>
                    </div>
                   <div class="content-header-right text-md-right col-md-6">
                      
                    </div>
                  </div>
                  <div class="content-body">

              

                  <div class="card">
                     <div  class="card-content collapse show">
                              <div class="card-body card-dashboard">
                                <div class="dropdown">
                                  <button type="button" class="btn btn-dark float-right  btn-sm dropdown-toggle" data-toggle="dropdown">
                                    Open Account
                                  </button>
                                    <div class="dropdown-menu">
                                      <?php foreach (v2\Models\Broker::Active()->get() as $broker):?>
                                        <a class="dropdown-item" target="_blank" href="<?=$broker->getOpenAccountLink();?>">
                                        <small><b><?=$broker->name;?></b> Live Account</small>
                                         </a>
                                      <?php endforeach ;?>
                                  </div>
                                </div>

                                 <p class="card-text">List of Trading Accounts - <?=$trading_accounts->count();?></p>
                                  <table id="payment-histor" class="table table-striped table-bordered zero-configuration">
                                      <tbody>

                                        <?php foreach ($trading_accounts as $key => $account):?>

                                        <tr>
                                          <td style="padding: 2px;">
                                            <div class="col-xl-12 col-lg-12" style="padding: 0px;">
                                              <div class="alert bg-dark  alert-dismissible mb-2" role="alert">
                                                <strong class="float-right">
                                                  <div class="dropdown">
                                                    <button type="button" class="btn btn-secondary  btn-sm dropdown-toggle" data-toggle="dropdown">
                                                      Actions
                                                    </button>
                                                    <div class="dropdown-menu">
                                                      <a class="dropdown-item" 
                                                      href="<?=domain;?>/user/make-deposit/<?=$account->account_number;?>/<?=$account->broker->id;?>">Make Deposit </a>
                                                      <a class="dropdown-item" 
                                                      href="<?=domain;?>/user/make-withdrawal/<?=$account->account_number;?>/<?=$account->broker->id;?>">Make Withdrawal </a>
                                                    </div>
                                                  </div>
                                                </strong><br>
                                                <strong><?=$account->broker->name;?></strong>
                                                 <br>
                                                <small>Account Number: </small><?=$account->account_number;?>
                                                <span class="float-right"><?=$account->DisplayActiveStatus;?></span>
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


                       <ul class="pagination">
                        <?= $this->pagination_links($data, $per_page);?>
                      </ul>

                  </div>
                </div>
              </div>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
