<?php
$page_title = "Confirm Withdrawal";
 include 'includes/header.php';

 ;?>


 <script src="https://js.paystack.co/v1/inline.js"></script>
  <script src="<?=general_asset;?>/js/payments/paystack-checkout.js"></script>


  <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
  <script src="<?=general_asset;?>/js/payments/rave-checkout.js"></script>



    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
       
        <div class="content-body">

              <div class="app-content">

                    <div class="content-wrapper">
                  <div class="content-header row">
                    <div class="content-header-left col-md-6 mb-2">
                      <h3 class="content-header-title mb-0">Confirm Withdrawal</h3>
                    </div>
                   <div class="content-header-right text-md-right col-md-6">
                      
                    </div>
                  </div>
                  <div class="content-body">

              

                  <div class="card">
                     <div  class="card-content collapse show">
                              <div class="card-body card-dashboard">

                                <div class="card-body col-xs-6">
                                    
                                    <h6>Summary</h6>
                                    <table class="table table-striped">
                                     
                                        <tbody id="payment_breakdown">
                                            <?=($breakdown['line']);?>
                                        </tbody>
                                    </table>

                                    <form id="" method="post" action="<?=domain;?>/withdrawal_crud/confirm_order">
                                       <input type="hidden" name="withdrawal_id" value="<?=$withdrawal->id;?>">
                                      <button type="submit" class="btn btn-success"  id="submit_btn">Continue >></button> 
                                    </form>


                                </div>


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
