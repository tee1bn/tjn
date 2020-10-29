<?php
$page_title = "Purchase";
include 'includes/header.php';
use v2\Models\InvestmentPackage;
;?>

<script>
  
  function Investment() {
    this.$setting  = JSON.parse('<?=json_encode($investment->DetailsArray);?>');
    this.$amount = 0;

    this.total_return  = function(){
      if (this.$amount == undefined) {
        return 0;
      }
      $total_return =  this.$setting.annual_roi_percent * this.$amount * 0.01;
      return $total_return;
    }

    this.weekly_return  = function(){
      if (this.$amount == undefined) {
        return 0;
      }
      $weekly_return =  this.$setting.weekly_roi_percent * this.$amount * 0.01;
      return $weekly_return;
    }

    this.total_profit  = function(){
      $total_profit =  this.total_return() -  this.$amount ;
      return $total_profit;
    }


    console.log(this.$setting);
  }

  app.controller('SelecPackController', function($scope, $http) {

    $scope.$no_in_cart="6453";
    $scope.$investment = new Investment;
  });



</script>



<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Purchase</h3>
      </div>

    </div>
    <div class="content-body">

      <style>
        .small-padding{
          padding: 3px;
        }
      </style>

      <div class="row match-height" ng-controller="SelecPackController" ng-cloak>   

      <div class="col-md-2 d-none d-lg-block">   
        &nbsp;
      </div>
      <div class=" col-md-4">   
          <div class="card">   
           <div class="card-content">
            <div class="card-body">
              <h4 class="card-title"><span class="investment-name"><?=$investment->name;?></span></h4>
              <h6 class="card-subtitle text-mute"> 
                 <small>Investment ranges</small>
                <span class="float-right">
                   <b class="price-range"><?=$currency;?><?=MIS::money_format($investment->DetailsArray['min_capital']);?> -
                  <?=MIS::money_format($investment->DetailsArray['max_capital']);?><!--  /Month --></b></span>
                </h6> 
              </div>

              <div class="card-body">
                 <ul class="list-group list-group-flush">
                      <li class="list-group-item use-bg small-padding">
                        <span class="badge badge-pill custom-warning float-right"><i class="fa fa-check"></i></span>
                        Annual Roi: <?=$investment->DetailsArray['annual_roi_percent'];?>%
                      </li>

                      <li class="list-group-item use-bg small-padding">
                        <span class="badge badge-pill custom-warning float-right"><i class="fa fa-check"></i></span>
                        Weekly Roi: <?=$investment->DetailsArray['weekly_roi_percent'];?>%
                      </li>
                    </ul>
                    <br>
                   <form 
                      id="upgrade_form<?=$subscription->id;?>"
                      method="post"
                      class="ajax_for"
                      data-overlay="in"
                      data-function="initiate_payment"
                      action="<?=domain;?>/user/submit_investment">
                    <div class="form-group">
                      <label>Amount</label>
                      <input type="number" ng-model="$investment.$amount" step="1" placeholder="Enter capital"
                      required="" min="<?=$investment->DetailsArray['min_capital'];?>" max="<?=$investment->DetailsArray['max_capital'];?>"  
                      name="amount" class="form-control">
                     
                    </div>


                    <div class="form-group">
                      <label>Using Wallet</label>
                      <select class="form-control" required="" name="wallet">
                          <option value="">Select Wallet</option>
                          <?php foreach ($wallet->available_wallets($auth) as $key => $option):?>
                              <option value="<?=$key;?>"><?=$option['name'];?> &nbsp;&nbsp; (<?=$currency;?><?=$option['balance'];?>) </option>
                          <?php endforeach;?>
                      </select>                   
                    </div>
                    <input type="hidden" name="investment_id" value="<?=$investment->id;?>">

                    <div class="form-group">
                      <button href="#" class="btn btn-outline-warning">Buy</button>
                    </div>
                    </form>

                   

                </div>
              </div>
            </div>
          </div>



      <style>
        td{
          padding-top: 0px !important;
          padding-bottom:  0px !important;
        }
      </style>
      <div class=" col-md-4">   
          <div class="card">   
           <div class="card-content">
            <div class="card-body">
              <!-- <h4 class="card-title"></h4> -->
              <h6 class="card-subtitle text-mute text-center"> 
                <span>Summary</span>
                </h6> 

                <table class="table table-sm">
                  <tr>
                    <td><small> Amount</small></td>
                    <td><?=$currency;?>{{$investment.$amount}}</td>
                  </tr>
                  <tr>
                    <td><small> Annual ROI</small></td>
                    <td><?=$investment->DetailsArray['annual_roi_percent'];?>%</td>
                  </tr>
                  <tr>
                    <td><small> Total Return</small></td>
                    <td><?=$currency;?>{{$investment.total_return() | number:2}}</td>
                  </tr>
                  <tr>
                    <td><small> Total Profit</small></td>
                    <td><?=$currency;?>{{$investment.total_profit() | number:2}}</td>
                  </tr>
                  <tr>
                    <td><small> Weekly ROI</small></td>
                    <td><?=$investment->DetailsArray['weekly_roi_percent'];?>%</td>
                  </tr>
                  <tr>
                    <td><small> Weekly Return</small></td>
                    <td><?=$currency;?>{{$investment.weekly_return() | number:2}}</td>
                  </tr>
                </table>
                
        </div>
            </div>
          </div>
        </div>


          


      </div>


      

      <script>
        initiate_payment= function($data){
          
          switch($data.payment_method) {
             case 'coinpay':
               // code block
                   window.location.href = $base_url+ 
                   "/shop/checkout?item_purchased=packages&order_unique_id="+$data.id+"&payment_method=coinpay";

               break;

             case 'paypal':
               // code block
                   window.location.href = $base_url+ 
                   "/shop/checkout?item_purchased=packages&order_unique_id="+$data.id+"&payment_method=paypal";

               break;
             case 'razor_pay':
               // code block
               window.SchemeInitPayment($data.id);
               break;
             default:
               // code block
           }
        }
      </script>


    </div>
  </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
