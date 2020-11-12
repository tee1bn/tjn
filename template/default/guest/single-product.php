<?php 
$page_title = MIS::encode_for_url($product->title);
include 'includes/header.php' ;?>


<script src="<?=asset;?>/angulars/single-product.js" type="module"></script>

<div class="app-content container center-layout mt-2" ng-controller="CarouselController">
  <div class="content-wrapper" style="margin: 0px;">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <h3 class="content-header-title mb-0"><?=$product->title;?></h3>
        <div class="row breadcrumbs-top">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?=domain;?>/shop"> &nbsp;</a></li>
              <!-- <li class="breadcrumb-item"><a href="<?=domain;?>/shop">See all courses</a></li> -->
          </ol>
      </div>
  </div>
</div>
<div class="content-header-right text-right col-6 ">

    <!-- <div w3-test-directive></div> -->

    


    <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
        <?php if (! $product->is_free()) :?>
            <a onclick="add_item_singly();"  style="<?=$show_add_to_cart;?>" title="Order Now" class="btn btn-outline-primary ft ft-shopping-cart" href="Javascript:void(0);">
            Order Now </a>
        <?php endif;?>
        <?php if ($product->is_free()) :?>
          <a class="btn btn-outline-primary" href="<?=domain;?>/courses/read/<?=$product->id;?>">
            Start Course
        </a>
    <?php endif;?>
</div>

</div>
</div>


<style>
  .img-fluid{

    /*height: 450px !important; */
    width: 100%;
    object-fit: cover;
}

.price{
    border-bottom: 1px dotted white;
}

.cover-video{
    height: 25em !important;
    width: 100%;
    object-fit: cover;
}

body{
    overflow-x: hidden;
}
</style>
<div class="content-detached content-left">
  <div class="content-body"><section class="row">
    <div class="col-sm-12">
      <?=$this->buildView('composed/view_product', compact('product'));?>
    </div>
</div>

</div>
</div>
<div id="sticky-wrapper" class="sticky-wrapper" style="float: right; height: 1133.75px;"><div class="sidebar-detached sidebar-right sidebar-sticky" ,="," style="float: none;">
  <div class="sidebar"><div class="sidebar-content card">
    <div class="card-body" id="content" ng-controller="ShopController">
        <div class="category-title pb-1">
            <h6>By <?=$product->user->username ?? '';?> </h6>
            <!-- <small>Updated <?=date("M j, Y h:iA" , strtotime($product->updated_at));?></small> -->
        </div>
        <!-- Card sample -->
        <!-- <div class="text-center">
            <img style="width: 260px; height: 170px; object-fit: cover;" class="card-img-top mb-1 img-fluid" data-src="holder.js/100px180/" src="<?=domain;?>/<?=$product->imageJson;?>" alt="Card image cap">
        </div> -->
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

        <?php if (! $product->is_free()) :?>
            <a href="javascript:void;" class="form-control text-center btn-primary"
            onclick="add_item_singly();"  style="<?=$show_add_to_cart;?>"><i class="ft ft-shopping-cart"></i> Order Now</a>
        <?php endif;?>

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

                    window.location.href = $base_url+"/shop/cart";

                },
                error: function (data) {
                },
                complete: function(){}
            });
            }

            
        </script>
        <hr>
        <span id="to_find_scope"></span>                        
    </div>
</div>

</div>
</div></div>
</div>
</div>

<?php include'includes/footer.php' ;?>