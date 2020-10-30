<?php include 'includes/header.php' ;?>



  <script>
    $category_id = <?=(isset($category_id))?  $category_id: 0;?>;
  </script>



<div ng-cloak class="app-content container center-layout mt-2" ng-controller="ShopController">


      <div class="content-wrapper" style="margin: 0px;">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0">Checkout</h3>
            <div class="row breadcrumbs-top">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=domain;?>">
                  User</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#">Shop</a>
                  </li>
                  <li class="breadcrumb-item active">checkout
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="content-header-right text-md-right col-md-6 col-12">
          <!--   <div class="form-group"> 
              <button class="btn-icon btn btn-secondary btn-round" type="button"><i class="ft-bell"></i></button>
              <button class="btn-icon btn btn-secondary btn-round" type="button"><i class="ft-life-buoy"></i></button>
              <button class="btn-icon btn btn-secondary btn-round" type="button"><i class="ft-settings"></i></button>
            </div> -->
          </div>
        </div>
        <div class="content-detached content-left">
          <div class="content-body"><section class="row">
    <div class="col-sm-12">
        <!-- Kick start -->
        <div id="kick-start" class="card">
            <div class="card-header">
                <h4 class="card-title">{{$shop.$cart.$items.length}} Courses in Cart</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <!-- <li><a data-action="collapse"><i class="ft-minus"></i></a></li> -->
                    </ul>
                </div>
            </div>
<style>
    .courses-in-cart ul li{
        list-style-type: none;
    }

    .courses-in-cart{
    border: 1px solid #00000014;
    padding: 5px;
    }
</style>

            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="card-text">
                                      
                        <div ng-repeat="($index, $item) in $shop.$cart.$items" class="media courses-in-cart">
                            <a class="media-left pr-1" href="#">
                           <img class="media-object" src="<?=domain;?>/{{$item.thumbnail}}" alt="Generic placeholder image" style="width: 64px;height: 64px; object-fit: cover;">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><b>{{$item.title}}</b></h4>
                                 {{$item.description}}
                            </div>
                                <ul>
                                    <li class="text-danger" ng-click="$shop.$cart.remove_item($item)"><a>Remove</a></li>
                                    <li><h2><b> <?=$currency;?> {{$item.price  | number:2}}<i class="fa fa-tags"></i> </b></h2></li>
                                </ul>

                        </div>


                    </div>
                </div>
            </div>
        </div>
        <!--/ Kick start -->

    </div>
</section>

          </div>
        </div>
        <div id="sticky-wrapper" class="sticky-wrapper" style="float: right; height: 1133.75px;"><div class="sidebar-detached sidebar-right sidebar-sticky" ,="," style="float: none;">
          <div class="sidebar"><div class="sidebar-content card d-none d-lg-block">
    <div class="card-body">
        
        <h4 class="card-title">Total:</h4>

        <h1><?=$currency;?> {{$shop.$cart.$total | number:2}}</h1>

        <hr>

        <a href="<?=domain;?>/shop/payments" class="form-control btn-primary text-center">CheckOut</a>
        <!-- /Card sample -->
        <hr>
   
      
    </div>
</div>

          </div>
        </div></div>
      </div>
    </div>
   






    <?php //include'includes/theme-customizer.php' ;?>
    <?php include'includes/footer.php' ;?>