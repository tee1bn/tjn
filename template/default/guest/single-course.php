<?php 
$page_title = MIS::encode_for_url($product->title);
include 'includes/header.php' ;?>



<div class="app-content container center-layout mt-2">
  <div class="content-wrapper" style="margin: 0px;">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <h3 class="content-header-title mb-0"><?=$product->title;?></h3>
            <div class="row breadcrumbs-top">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=domain;?>/shop">See all courses</a>
                  </li>
                  </ol>
              </div>
          </div>
        </div>
<div class="content-header-right text-right col-6 ">


    <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
        <?php if (! $product->is_free()) :?>
            <a onclick="add_item_singly();"  style="<?=$show_add_to_cart;?>" title="add to cart" class="btn btn-outline-primary ft ft-shopping-cart" href="Javascript:void(0);">
            Add to Cart </a>

            <a  class="btn btn-outline-primary fa fa-gift" href="#offers" style="<?=$show_offer;?>">
            See Offers </a>
        <?php endif;?>
        <?php if ($product->is_free()) :?>
          <a class="btn btn-outline-primary" href="<?=domain;?>/courses/read/<?=$product->id;?>">
            Start Course
            </a>
        <?php endif;?>
    </div>

</div>
</div>
<div class="content-detached content-left">
  <div class="content-body"><section class="row">
    <div class="col-sm-12">




<div id="how-to" class="card">
    <div class="card-header">
        <h4 style="cursor: pointer;" data-toggle="collapse" href="#course_description"  class="card-title">Description
            <a data-toggle="collapse" href="#course_description"><i class="ft-chevron-down" class="float-right"></i></a>
        </h4>
        
    </div>
    <div class="card-content collapse show" id="course_description">
        <div class="card-body">
            <div class="card-text">
                <p><?=$product->description;?></p>
            </div>
        </div>
    </div>
</div>

     
      



</div>
<!--/ How to-->


</div>
</section>

</div>
</div>
<div id="sticky-wrapper" class="sticky-wrapper" style="float: right; height: 1133.75px;"><div class="sidebar-detached sidebar-right sidebar-sticky" ,="," style="float: none;">
  <div class="sidebar"><div class="sidebar-content card">
    <div class="card-body" id="content" ng-controller="ShopController">
        <div class="category-title pb-1">
            <h6>By <?=$product->instructor->firstname;?> </h6>
            <small>Updated <?=date("M j, Y h:iA" , strtotime($product->updated_at));?></small>
        </div>
        <!-- Card sample -->
        <div class="text-center">
            <img style="width: 260px; height: 170px; object-fit: cover;" class="card-img-top mb-1 img-fluid" data-src="holder.js/100px180/" src="<?=domain;?>/<?=$product->imageJson;?>" alt="Card image cap">
        </div>
        <hr>
        <span style="color: #00b5b8;">
            <?=($product->market_details()['star_rating']['stars']);?>
        </span>
        <h4 class="card-title">

            <?php  if ($product->old_price != '') :?>
                <del class="cent" style="color: grey;">
                    <?=$currency;?><?=$this->money_format((int)$product->old_price);?>
                </del>&nbsp;
            <?php  endif  ;?>
            
            <?=$currency;?><?=$this->money_format($product->price);?>

        </h4>



        <!-- <p class="card-text">content.</p> -->

        <?php if (! $product->is_free()) :?>
            <a href="javascript:void;" class="form-control text-center btn-primary"
            onclick="add_item_singly();"  style="<?=$show_add_to_cart;?>"><i class="ft ft-shopping-cart"></i> Add to Cart</a>

            <a  class="btn btn-outline-primary text-center fa fa-gift" href="#offers" style="<?=$show_offer;?>">
            See Offers </a>

        <?php endif;?>

        <script>
            try{
                $this_item = <?=$product->id;?>;
            }catch(e){}
            
            add_item_singly = function ($with_offer_id=null) {

                $.ajax({
                    type: "POST",
                    url: $base_url+'/shop/get_single_item_on_market/course/'+$this_item,
                    data: null,
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT THIS
                cache: false,
                success: function(data) {
                    $item = data.single_good;
                    $scope = angular.element($('#content')).scope();
                    $scope.$shop.$cart.add_item($item, $with_offer_id);
                    $scope.$apply();

                    console.log($scope.$shop.$cart);
                },
                error: function (data) {
                },
                complete: function(){}
            });
            }

            
        </script>
        


            <!-- /Card sample -->
            <hr>

            <span id="to_find_scope"></span>
            
            <script>
                add_item = function ($product_id) {

                    $form = new FormData();
                    $.ajax({
                        type: "POST",
                        url: $base_url+"/course_api/find/"+$product_id,
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: $form,
                        success: function(data) {

                // show_notification(data);
                console.log(data);
                $scope = angular.element($('#to_find_scope')).scope();
                $scope.$shop.$cart.add_item(data);
                $scope.$apply();
                
              // $scope.fetch_page_content();
          },
          error: function (data) {
                 //alert("fail"+data);
             }

         });




    }


                
            </script>
            
            
        </div>
    </div>

</div>
</div></div>
</div>
</div>







<?php// include'includes/theme-customizer.php' ;?>
<?php include'includes/footer.php' ;?>