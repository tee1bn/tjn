<?php 
$page_title = '';
$page_description = "";

include 'includes/header.php';?>


<!-- 
<script src="https://js.paystack.co/v1/inline.js"></script>
<script src="<?=asset;?>/angulars/payments/paystack-checkout.js"></script> -->


<script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<script src="<?=asset;?>/angulars/payments/rave-checkout.js"></script>



<div class="app-content container center-layout mt-2 ">
  <div class="content-wrapper">

    <div class="content-body">

      <div class="" >

        <div class="">
          <div class="content-header row">
            <div class="content-header-left col-6 mb-2">
              <h3 class="content-header-title mb-0">Cart</h3>

            </div>
            <div class="content-header-right text-right col-6">
              <small><b>Need help?</b> Whatsapp 08123351819 <br>
            Email: support@salesra.com </small>

            </div>
          </div>
          <div class="content-body">
            <style>
              .courses-in-cart ul li{
                list-style-type: none;
              }

              .courses-in-cart{
                border: 1px solid #00000014;
                padding: 5px;
              }

              .form-group{
                margin-bottom: 2px !important;
              } 
            </style>
            <div id="content"  ng-controller="ShopController" ng-cloak>
              <div class="content-detached content-lef" >
                <div class="content-body">
                  <section class="row">
                    <div id=" " class="card col-md-7">
                      <div class="card-header">
                        <h4 class="card-title">{{$shop.$cart.$items.length}} Item(s) in Cart</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                      </div>


                      <div class="card-content collapse show">
                        <div class="card-body">
                          <div class="card-text">
                            <center ng-hide="$shop.$cart.$items.length>0" style='margin:30px; '><i class="fa fa-spinner fa-spin fa-2x"></i></center>
                            <div ng-repeat="($index, $item) in $shop.$cart.$items" class="media courses-in-cart">


                                <!-- 
                                <a class="media-left pr-1" href="#">
                                 <img class="media-object" 
                                 src="{{$item.market_details.thumbnail}}" alt="{{$item.market_details.name}} image" style="width: 64px;height: 64px; object-fit: cover;">
                               </a> -->


                               <div class="media-body">
                                <h4 class="media-heading"><b>{{$item.market_details.name}}</b></h4>
                                <!-- <span ng-bind-html = $item.market_details.short_description></span> -->
                              </div>
                              <ul style="margin-bottom: 0px;">
                                <li class="text-danger" ng-click="$shop.$cart.remove_item($item)"><a>Remove</a></li>
                                <li><h2><b><?=$currency;?>{{$item.market_details.price }}</b></h2></li>
                              </ul>
                                  <br>
                                  <div class="quantity">
                                    <input style="width:  35px; display: none;"
                                    ng-change="$shop.$cart.update_server();" type="number" class="quantity-input" ng-model="$item.qty" id="qty-4"  min="1"
                                    >
                                  </div>

                                </div>
                                <hr />
                                <a href="javascript:void;" ng-click="$shop.$cart.empty_cart()"  class="btn btn-outline-dark">Empty Cart</a>
                                <a href="{{$shop.$cart.$config.shop_link}}" class="pull-right btn btn-outline-light"> Continue Shopping</a><br>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!--/ Kick start -->



                        <div class=" col-md-5" >
                          <div class=" card ">
                            <div class="card-body">
                              <h6>Summary</h6>
                              <table class="table table-striped">
                                <!-- <tr>
                                  <th style="padding: 5px;">Order</th>
                                  <td class="text-right" style="padding: 5px;">
                                   <span ng-bind-html="$shop.$config.currency"></span> {{($shop.$cart.calculate_total()) |  number:2}} 
                                 </td>   -->
                               </tr>

                               <tbody id="payment_breakdown">

                                <tr class="order-total">
                                  <th style="padding: 5px;">Total Payable</th>
                                  <td class="text-right" style="padding: 5px;"><b>
                                    <?=$currency;?> 
                                    {{($shop.$cart.calculate_total()) |  number:2}}  

                                  </b>
                                </td>  
                              </tr>
                            </tbody>
                          </table>

                          <form ng-show="$shop.$cart.$items.length > 0" id="" class="ajax_form" data-function="on_complete_order"
                          method="post" action="<?=domain;?>/shop/complete_order/get_breakdown">
                          <textarea style="display:none ;" name="cart">
                            {{$shop.$cart}}
                          </textarea>

                          <?php if (!$auth) :?>
                          <br>
                          <div class="form-group">                               
                            <label><small>First Name</small></label>
                            <input type="" name="firstname" class="form-control" ng-init="$shop.$cart.$extra_detail.firstname='<?=$auth->firstname ??'';?>'"
                            ng-model="$shop.$cart.$extra_detail.firstname" value=""  required=""> 
                          </div> 

                          <div class="form-group">                               
                            <label><small>Last Name</small></label>
                            <input type="" name="lastname" class="form-control" ng-init="$shop.$cart.$extra_detail.lastname='<?=$auth->lastname ??'';?>'"
                            ng-model="$shop.$cart.$extra_detail.lastname" value=""  required=""> 
                          </div> 

                          <div class="form-group">                               
                            <label><small>Your Email</small></label>
                            <input type="email" name="email" class="form-control" ng-init="$shop.$cart.$extra_detail.email='<?=$auth->email ??'';?>'"
                            ng-model="$shop.$cart.$extra_detail.email" value=""  required=""> 
                          </div> 

                          <div class="form-group">                               
                            <label><small>Your Phone</small></label>
                            <input type="" name="phone" class="form-control" ng-init="$shop.$cart.$extra_detail.phone='<?=$auth->phone ??'';?>'"
                            ng-model="$shop.$cart.$extra_detail.phone" value=""  required=""> 
                          </div> 


                          <?php endif ;?>
                          <div class="form-group">                               
                            <input type="hidden" name="product_ref"
                             class="form-control" ng-init="$shop.$cart.$extra_detail.product_ref='<?=$_SESSION['product_ref'] ?? '' ;?>'"
                            ng-model="$shop.$cart.$extra_detail.product_ref"  required=""> 
                          </div> 


                          <div class="form-group" ng-if="$shop.$cart.calculate_total()>0">                                
                            <label>Pay With* </label> <small class="float-right">  </small>

                            <select class="form-control" required="" name="payment_method" onchange="present_payment_methods(form);">
                              <option value="">Select Payment method</option>
                              <?php foreach ($shop->get_available_payment_methods() as $key => $option):?>
                                <option value="<?=$key;?>"><?=$option['name'];?></option>
                              <?php endforeach;?>
                            </select>
                          </div>

                          <span ng-if="$shop.$cart.calculate_total()==0">
                            <input type="hidden" name="payment_method" value="bank_transfer">
                            <button   type="submit" 
                            class="btn btn-dark" onclick="get_breakdown(form)"> Complete Order</button>
                          </span>

                          <button id="get_breakdown_btn" type="button" style="display: none;"
                          class="btn btn-dark" onclick="get_breakdown(form)"> Set Payment Method</button>
                          <button type="submit" class="btn btn-success" style="display: none" id="submit_btn">Continue >></button> 
                        </form>


                        <script>
                          get_breakdown = function($form){
                            // console.log($form);
                            $($form).attr('data-function', 'on_complete_breakdown');
                            $('#submit_btn').click();
                          }
                          
                          on_complete_breakdown = function($data){
                            try{
                              if (typeof $data.url !== 'undefined') {
                                window.location.href = $data.url;
                                return;
                              }


                              $('#payment_breakdown').html($data.breakdown.line);
                              $('#get_breakdown_btn').css('display', 'none');
                              $('#submit_btn').css('display', 'block');

                              $action = $base_url+ '/shop/complete_order/make_payment';
                              $($form).attr('action', $action);
                              $($form).attr('data-function', 'on_complete_order');
                            }catch(e){}
                            // console.log($form);
                          }


                          present_payment_methods = function($form){
                            $('#submit_btn').css('display', 'none');
                            $('#get_breakdown_btn').css('display', 'block');

                            $action = $base_url+ '/shop/complete_order/get_breakdown';
                            $($form).attr('action', $action);
                            $($form).attr('data-function', 'on_complete_breakdown');

                            get_breakdown($form);

                          }

                          on_complete_order = function($data){

                            try{

                              var $data = $data;
                              console.log($data);

                              switch($data.gateway) {

                                case 'bank_transfer':
                                window.location.href = $base_url+"/shop/bank-transfer/"+$data.order_unique_id+"/product";
                                break;

                                case 'paystack':

                                payWithPaystack($data);
                                break;

                                case 'rave':
                                payWithRave($data);
                                break;


                                case 'razor_pay':
                                                // code block
                                                window.SchemeInitPayment($data.id);
                                                break;
                                                default:
                                                // code block


                                              }


                                            }catch(e){}
                                          }




                                        </script>


                                      </div>
                                    </div>

                                  </div>

                                </section>

                              </div>
                            </div>

                          </div>


                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>




              <?php include 'includes/footer.php';?>