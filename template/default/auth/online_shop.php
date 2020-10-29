<?php


$page_title = "Online Shop";
 include 'includes/header.php';?>
  <?php

    ;?>




    <!-- BEGIN: Content-->
    <div class="app-content content"  id="content" ng-controller="ShopController">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6  mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Online Shop</h3>
          </div>
          




          <div class="content-header-right col-6">
           <!-- 
               <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                   <?php if (! $product->is_free()) :?>
                       <a onclick="add_item_singly();" title="add to cart" class="btn btn-outline-primary ft ft-shopping-cart" href="Javascript:void(0);">
                       Add to Cart </a>
                   <?php endif;?>
           </div> -->
          </div>
        </div>
        <div class="content-body">

            <style>
                .product-img{
                    width: 100% !important;
                    height: 400px !important;
                    object-fit: cover;
                }
            </style>

          <div class="row match-height">

            <div class="col-md-7">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                   
                                    <div class="row">
                                        <div class="col-md-12">
                                           <img class="product-img" src="<?=$product->mainimage;?>" >
                                        </div>
                                        <div class="col-md-10">
                                            <p></p>
                                            <hr>
                                            <!-- <h3>Dimontis HUP</h3> -->
                                            <span> Basic workshop for partners</span>
                                            <div class="row">
                                                
                                                <div class="col-md-6">

                                                    <h3><?=$product->name;?></h3>
                                                </div>

                                                <div class="col-md-6 text-right">
                                                    <h3><?=MIS::money_format($product->tax_breakdown()['breakdown']['before_tax']);?><?=$currency;?></h3>
                                                    <small>Excl. VAT 20%</small><br>
                                                    <small>Compensation assessment basis: <?=MIS::money_format($product->commission_price ?? 0);?><?=$currency;?> </small><br>
                                            </div>
                                            </div>

                                        </div>
                                     
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                            <!-- <select class="form-control" >
                                <option>Select a payment method</option>
                            </select> -->
                            </div>
                            <div class="form-group col-md-6">
                                    <button onclick="buy_now();" class="btn btn-outline-dark btn-block">Buy Now</button>
                            </div>
                        </div>

                    </div>


  <div class=" col-md-5">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4 class="card-tile border-0">Product description</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?=$product->description;?>                                                
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

    <script>
      try{
          $this_item = <?=$product->id;?>;
      }catch(e){}
      
      add_item_singly = function () {

          $.ajax({
              type: "POST",
              url: $base_url+'/shop/get_single_item_on_market/product/'+$this_item,
              data: null,
              contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
              processData: false, // NEEDED, DON'T OMIT THIS
              cache: false,
              success: function(data) {
                  $item = data.single_good;
                  $scope = angular.element($('#content')).scope();
                  $scope.$shop.$cart.add_item($item);
                  $scope.$apply();
              },
              error: function (data) {
              },
              complete: function(){}
          });
      }

      
      buy_now = function () {

          $.ajax({
              type: "POST",
              url: $base_url+'/shop/get_single_item_on_market/product/'+$this_item,
              data: null,
              contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
              processData: false, // NEEDED, DON'T OMIT THIS
              cache: false,
              success: function(data) {
                  $item = data.single_good;
                  $scope = angular.element($('#content')).scope();
                  $scope.$shop.$cart.buy_now($item);
                  $scope.$apply();
              },
              error: function (data) {
              },
              complete: function(){}
          });
      }

        
    </script>

<?php include 'includes/footer.php';?>

