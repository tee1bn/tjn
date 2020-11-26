  <?php 

    $current_url = MIS::current_url();

    $allowed =[
      'user/cart',
      'user/shop',
      'user/courses',
      'user/view_cart',
      'shop/view_cart',
      'shop/cart',
      'shop',
      'shop/full_view',
      's/s',
    ];
  ;?>

  
  <script>
    var $model = '<?=(isset($model))?  $model: '';?>';
    var $request_url = `<?=$request_url ?? "$domain/shop/market?";?>`;

  </script>

  <script src="<?=asset;?>/angulars/shop.js" type="module"></script>
  <?php if (in_array($current_url, $allowed) || true)  :?>
    <li ng-cloak ng-controller="CartNotificationController" id="cart-notification" ng-show="$cart.$items.length>0" class="dropdown dropdown-notification nav-item">
      <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-shopping-cart"></i>
        <span class="badge badge-pill badge-default badge-danger badge-default badge-up">{{$cart.$items.length}} </span>
      </a>
      <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">

        <li class="dropdown-menu-header" ng-show="$cart.$items.length==0">
          <center class="dropdown-header m-0"><span class="grey darken-2">Your Cart is Empty</span>
          </center>
        </li>
        <li class=" media-list" style="max-height: 250px; overflow-y: scroll;">

            <a ng-repeat="($index, $item) in $cart.$items" href="javascript:void(0)">
            <div class="media">
              <div class="media-left align-self-center"><i class="ft-file icon-bg-circle bg-dark"></i></div>
              <div class="media-body">
                <h6 class="media-heading">{{$item.market_details.short_name}}</h6><small>
                  <time class="media-meta text-muted" style="font-size: 16px; font-weight: bold;">
                    <span ng-bind-html="$cart.$config.currency"></span>{{$item.market_details.price  | number:2}} </time></small>
                    <!-- <span class="float-right">x{{$item.qty}} qty</span> -->
                    <!-- <small class="float-right text-danger" ng-click="$shop.$cart.remove_item($item)">Remove</small> -->
              </div>
            </div>
          </a>
          </li>

          <li class="dropdown-menu-header">
          <div class="dropdown-header m-0"  ng-hide="$cart.$items.length==0">
            <span class="grey darken-2">Total:
              <span ng-bind-html="$cart.$config.currency"></span> 
              <b style="font-size: 20px;">{{($cart.calculate_total())  | number:2}} </b>
            </span>
            <span class="notification-tag badge badge-default badge-danger float-right m-0">
              {{$cart.$items.length}} Item(s)
            </span>
          </div>
          <a ng-hide="$cart.$items.length==0" class="btn btn-success btn-block text-center" href="<?=domain;?>/shop/cart">Proceed to Checkout</a>
        </li>
      </ul>
    </li>   
  <?php endif ;?>

  <?php if ($auth):?>
      <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown"><span class="avatar avatar-online">
        <img src="<?=domain;?>/<?=$auth->profilepic;?>" alt="avatar"
        style="height: 30px;object-fit: cover;"><i></i></span><span class="user-name">
    <?=$auth->fullname;?>
      
    </span></a>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="<?=domain;?>/user/dashboard"><i class="fa fa-dashboard"></i> Dashboard </a>
          <a class="dropdown-item" href="<?=domain;?>/user/profile"><i class="ft-user"></i> Profile </a>
          <a class="dropdown-item" href="<?=domain;?>/user/password"><i class="ft-lock"></i> Password</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?=domain;?>/login/logout"><i class="ft-power"></i> Logout</a>


        </div>

      </li>
    <?php else:?>

    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
    <span class=" ft ft-lock" style="position: relative;top: 5px;font-size: 20px;"></span></a>

      <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="<?=domain;?>/register"><i class=""></i> Sign Up</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="<?=domain;?>/login"><i class=""></i> Sign In</a>
      </div>
    </li>
 <?php endif;?>