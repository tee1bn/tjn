<?php
$page_title = "Confirm Deposit";
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
                    <div class="content-header-left col-6 mb-2">
                      <h3 class="content-header-title mb-0">Confirm Deposit</h3>
                    </div>
                   <div class="content-header-right text-right col-6">
                   
                    </div>
                  </div>
                  <div class="content-body">

                    <?php if ($auth->deposits->where('status','completed')->count() < 2) :?>
                     <!--  <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Notice!</strong> 
                        <ol>
                          <li>We are not an investment company, do not hold funds. So, money deposited is meant for forex trading.</li>
                          <li>You can only make deposits in person, using your own cash funds, bank accounts, or cards.</li>
                          <li>You bear total responsibilities for the funds deposited into your trading account(s).</li>
                          <li><a href="http://www.9gforex.com/" target="_blank">www.9gforex.com</a>&nbsp;is owned and operated by Forze Technologies Ltd.</li>
                        </ol>
                      </div>   -->
                    <?php endif;?>




                  <div class="card">
                     <div  class="card-content collapse show">
                              <div class="card-body card-dashboard">

                                <div class="card-body col-xs-6">
                                    
                                    <span>Summary</span>
                                      <span class="float-right"> Order:  $<?=$deposit->amount;?></span>
                                    <table class="table table-striped">
                                      
                                        <tbody id="payment_breakdown">

                                            <?=($breakdown['line']);?>
                                        </tbody>
                                    </table>

                                    <form id="" class="ajax_form" data-function="on_complete_order"
                                     method="post" action="<?=domain;?>/deposit_crud/complete_order/get_breakdown">
                                        <textarea style="display: none;" name="cart">
                                            {{$shop.$cart}}
                                        </textarea>
                                        <!-- <input type="hidden" name="payment_method" value="paystack"> -->
                                        
                                        
                                        <div class="form-group">                                
                                            <label>Pay With* </label> <small class="float-right">  </small>

                                            <select class="form-control" required="" name="payment_method" onchange="present_payment_methods(form);">
                                                <option value="">Select Payment method</option>
                                                <?php foreach ($shop->get_available_payment_methods() as $key => $option):?>
                                                    <option value="<?=$key;?>"><?=$option['name'];?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>

                                      <button id="get_breakdown_btn" type="button" style="display: none;"
                                       class="btn btn-dark" onclick="get_breakdown(form)"> Set Payment Method</button>
                                      <button type="submit" class="btn btn-success" style="display: none" id="submit_btn">Continue >></button> 
                                    </form>


                                    <script>
                                      get_breakdown = function($form){

                                        $($form).attr('data-function', 'on_complete_breakdown');

                                        $action = $base_url+ '/deposit_crud/confirm_order/<?=$deposit->id;?>/get_breakdown';
                                        $($form).attr('action', $action);

                                        $('#submit_btn').click();
                                      }
                                      
                                      on_complete_breakdown = function($data){
                                        $('#payment_breakdown').html($data.breakdown.line);
                                        $('#get_breakdown_btn').css('display', 'none');
                                        $('#submit_btn').css('display', 'block');

                                        $action = $base_url+ '/deposit_crud/confirm_order/<?=$deposit->id;?>/make_payment';
                                        $($form).attr('action', $action);
                                        $($form).attr('data-function', 'on_complete_order');
                                        // console.log($data);
                                      }


                                      present_payment_methods = function($form){
                                        $('#submit_btn').css('display', 'none');
                                        $('#get_breakdown_btn').css('display', 'block');

                                        $action = $base_url+ '/deposit_crud/confirm_order/get_breakdown';
                                        $($form).attr('action', $action);
                                        $($form).attr('data-function', 'on_complete_breakdown');

                                        get_breakdown($form);

                                      }

                                      on_complete_order = function(data){

                                                  try{
                                                    
                                                      switch(data.gateway) {
                                                        case 'paystack':
                                                        $order = data;
                                                            payWithPaystack(data);
                                                          break;

                                                        case 'rave':

                                                            payWithRave(data);
                                                          break;

                                                        case 'bank_transfer':

                                                          location.href = $base_url+"/user/bank-transfer/"+data.order_unique_id+"/deposit";

                                                          break;

                                                        case 'website':

                                                          location.href = $base_url+"/user/my-games";
                                                          break;

                                                       
                                                        default:
                                                          // code block
                                                          break;
                                                      }


                                                  }catch(e){}
                                          }



                                      
                                    </script>


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
