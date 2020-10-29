<?php
$page_title = "Cart";
 include 'includes/header.php';?>

 <script src="https://js.paystack.co/v1/inline.js"></script>
  <script src="<?=general_asset;?>/js/payments/paystack-checkout.js"></script>


  <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
  <script src="<?=general_asset;?>/js/payments/rave-checkout.js"></script>

    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
       
        <div class="content-body">

              <div class="" >

                    <div class="">
                  <div class="content-header row">
                    <div class="content-header-left col-md-6 col-12 mb-2">
                      <h3 class="content-header-title mb-0">Cart</h3>
                   
                    </div>
                   <div class="content-header-right text-md-right col-md-6 col-12">

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
                    </style>
                            <div id="content"  ng-controller="ShopController" ng-cloak>
                            <div class="content-detached content-left" >
                              <div class="content-body"><section class="row">
                        <div class="col-sm-12">
                            <!-- Kick start -->
                            <div id="kick-start" class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{$shop.$cart.$items.length}} Item(s) in Cart</h4>
                                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <!-- <li><a data-action="collapse"><i class="ft-minus"></i></a></li> -->
                                        </ul>
                                    </div>
                                </div>
               

                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <div class="card-text">
                                          <center ng-hide="$shop.$cart.$items.length>0" style='margin:30px; '><i class="fa fa-spinner fa-spin fa-2x"></i></center>
                                            <div ng-repeat="($index, $item) in $shop.$cart.$items" class="media courses-in-cart">
                                                <a class="media-left pr-1" href="#">
                                               <img class="media-object"
                                                src="{{$item.market_details.thumbnail}}" alt="{{$item.market_details.name}} image" style="width: 64px;height: 64px; object-fit: cover;">
                                                </a>
                                                <div class="media-body">
                                                    <h4 class="media-heading"><b>{{$item.market_details.name}}</b>
                                                    </h4>
                                                    <span class="badge badge-dark">{{$item.market_details.offers_available[$item.offer_id].name}}</span>
                                                     <span ng-bind-html = $item.market_details.short_description></span>
                                                </div>
                                                    <ul>
                                                        <li class="text-danger" ng-click="$shop.$cart.remove_item($item)"><a>Remove</a></li>
                                                        <li>
                                                          <h2>
                                                            
                                                            <b> <?=$currency;?> {{$item.deal_price }}<i class="fa fa-tags"></i> </b></h2></li>
                                                    </ul><br>
                                                  <!--   <div class="quantity">
                                                        <input style="width:  35px;"
                                                         ng-change="$shop.$cart.update_server();" type="number" class="quantity-input" ng-model="$item.qty" id="qty-4"  min="1"
                                                          >
                                                    </div> -->

                                            </div>

                                              <hr />
                                              <a href="javascript:void;" ng-click="$shop.$cart.empty_cart()"  class="btn btn-outline-danger">Empty Cart</a>
                                              <a href="{{$shop.$links.shop}}" class="pull-right btn btn-outline-dark "> Continue Shopping</a><br>
                                                                  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ Kick start -->
                        </div>
                    </section>

                              </div>
                            </div>
                            <div id="sticky-wrapper" class="sticky-wrapper" style="float: right; height: 1133.75px;">
                              <div class="sidebar-detached sidebar-right sidebar-sticky">
                              <div class="sidebar"><div class="sidebar-content card  d-lg-block">
                            <center ng-hide="$shop.$cart.$items.length>0" style='margin:30px; '><i class="fa fa-spinner fa-spin fa-2x"></i></center>
                            
                        <div class="card-body" ng-show="$shop.$cart.$items.length>0">
                            <h6>Summary</h6>
                            <table class="table table-striped">
                                <tr>
                                    <th style="padding: 5px;">Order</th>
                                    <td class="text-right" style="padding: 5px;">
                                       <span ng-bind-html="$shop.$config.currency"></span> {{($shop.$cart.calculate_total()) |  number:2}} 
                                    </td>  
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

                            <form id="" class="ajax_form" data-function="on_complete_order"
                             method="post" action="<?=domain;?>/shop/complete_order/get_breakdown">
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
                                // console.log($form);
                                $($form).attr('data-function', 'on_complete_breakdown');
                                $('#submit_btn').click();
                              }
                              
                              on_complete_breakdown = function($data){
                                $('#payment_breakdown').html($data.breakdown.line);
                                $('#get_breakdown_btn').css('display', 'none');
                                $('#submit_btn').css('display', 'block');

                                $action = $base_url+ '/shop/complete_order/make_payment';
                                $($form).attr('action', $action);
                                $($form).attr('data-function', 'on_complete_order');
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

                              on_complete_order = function(data){
                                        // console.log(data);

                                          try{
                                            
                                              switch(data.gateway) {
                                                case 'paystack':
                                                    payWithPaystack(data);
                                                  break;

                                                case 'rave':

                                                    payWithRave(data);
                                                  break;



                                                case 'bank_transfer':

                                                  location.href = $base_url+"/user/bank-transfer/"+data.order_unique_id+"/course";

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
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
