<?php
$page_title = "Bank Account";
 include 'includes/header.php';

    $financial_banks = v2\Models\FinancialBank::all();


 ;?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
       
        <div class="content-body">

              <div class="app-content "  ng-controller="ShopController">

                    <div class="content-wrapper">
                  <div class="content-header row">
                    <div class="content-header-left col-md-6 mb-2">
                      <h3 class="content-header-title mb-0">Bank Accounts</h3>
                    </div>
                   <div class="content-header-right text-md-right col-md-6">
                      
                    </div>
                  </div>
                  <div class="content-body">

                    <!-- The Modal -->
                    <div class="modal" id="myModal">
                      <div class="modal-dialog">
                        <div class="modal-content">

                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Add Bank</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>

                          <!-- Modal body -->
                          <div class="modal-body">
                          	<small>Account must be in the name <b><?=$auth->fullname;?> </b></small>
                            <form id="bank_info_form"
                            class="ajax_for" 
                            action="<?=domain;?>/userbankcrud/add_user_bank" method="post">                               
                            
                              <div class="form-group">
                                  <label for="bank_name" class="pull-left">Bank<sup>*</sup></label>
                                  <select name="bank_id" class="form-control" required="">
                                    <option value="">Select</option>
                                    <?php foreach ($financial_banks as  $bank):?> 
                                      <option value="<?=$bank->id;?>" ><?=$bank->bank_name;?></option>
                                    <?php endforeach ;?> 

                                  </select>
                              </div>

                                
                             <div class="form-group">
                                 <label for="account_number" class="pull-left">Bank Account Number <sup></sup></label>
                                  <input type="account_number" maxlength="10" name="account_number" required=""  value="" id="account_number" class="form-control" >
                              </div>


                              <div class="form-group">

                                    <button type="submit" class="btn btn-secondary btn-block btn-flat">Save</button>

                              </div>
                            </form>




                          </div>

                        </div>
                      </div>
                    </div>

                  <div class="card">
                     <div  class="card-content collapse show">
                              <div class="card-body card-dashboard">
                                <button type="button" class="btn btn-dark btn-sm float-right" data-toggle="modal" data-target="#myModal">
                                  + Add Bank
                                </button>
                                 <p class="card-text">List of Bank Accounts - <?=$auth->banks->count();?></p>
                                  <table id="payment-histor" class="table table-striped table-bordered zero-configuration">
                                      <tbody>

                                        <?php foreach ($auth->banks->sortByDesc('created_at') as $key => $bank):?>

                                        <tr>
                                          <td style="padding: 2px;">
                                            <div class="col-xl-12 col-lg-12" style="padding: 0px;">
                                              <div class="alert bg-dark  alert-dismissible mb-2" role="alert">
                                                <strong class="float-right"><?=$bank->AccountHolder;?></strong><br>
                                                <strong><?=$bank->financial_bank->bank_name;?></strong>
                                                 <br>
                                                <?=$bank->account_number;?>
                                                <span class="float-right"><?=$bank->DisplayStatus;?></span>
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
                </div>
              </div>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
