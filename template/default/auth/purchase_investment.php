<?php
$page_title = "Purchase";
include 'includes/header.php';
use v2\Models\InvestmentPackage;
use v2\Models\Withdrawal;

$balances = Withdrawal::payoutBalanceFor($auth->id);

;?>




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
        .card{
          border-radius: 15px !important;
        }

      </style>

      <div class="row match-height">   



        <div class=" col-md-3">   
          <div class="card">   
           <div class="card-content">
            <div class="card-body">
              <h4 class="card-title">Buy TruCash</h4>
              <h6 class="card-subtitle text-mute"> 
                <span>Price: <?=tch;?>/USD <?=$balances['trucash_exchange'];?></span>
                <b class="float-right">
                </b>
              </h6> 
            </div>

            <div class="card-body">

              <form 
              id="upgrade_form<?=$subscription->id;?>"
              method="post"
              class="ajax_form"
              action="<?=domain;?>/user/submit_buy_trucash">
              <div class="row">

               <div class="form-group col-8">
                 <!-- <label>Amount</label> -->
                 <input type="number" onkeyup="update_equivalent(this);" step="0.01" placeholder="Amount ($)"
                 required="" min="" max=""  
                 name="amount" class="form-control">

               </div>
               <div class="form-group col-4">
                <?=tch;?><br><span id="equi">0.00</span>
              </div>

              <script>
                update_equivalent = function($input){
                  $equivalent = $input.value / <?=$balances['trucash_exchange'];?>;
                  $('#equi').html($equivalent.toFixed(2));
                }
                
              </script>
              <div class="form-group col-12">
               <!-- <label>Using Wallet</label> -->
               <select class="form-control" required="" name="wallet">
                 <option value="">Select Wallet</option>
                 <?php foreach ($wallet->available_wallets($auth) as $key => $option):?>
                   <option value="<?=$key;?>"><?=$option['name'];?> &nbsp;&nbsp; (<?=$currency;?><?=$option['balance'];?>) </option>
                 <?php endforeach;?>
               </select>                   
             </div>

             <div class="form-group col-12">
               <button href="#" class="btn custom-warning">Buy</button>
             </div>
           </div>
         </form>



       </div>
     </div>
   </div>
 </div>


 <?php foreach (InvestmentPackage::available()->get() as  $investment):    
 $has_this_running =  InvestmentPackage::user_has_investment_running($auth->id, $investment->id);
 if ($has_this_running) {continue;}

 ?>

 <div class=" col-md-3">   
  <div class="card">   
   <div class="card-content">
    <div class="card-body">
      <h4 class="card-title">
        <span class="investment-name">
          <?=$investment->name;?>
        </span>
      </h4>
      <br>
      <h6 class="card-subtitle text-mute"> 
        <span class="float-right">
          <b class="price-range"><?=$currency;?><?=MIS::money_format($investment->DetailsArray['min_capital']);?> -
          <?=MIS::money_format($investment->DetailsArray['max_capital']);?></b></span>
        </h6> 
        <br>
        <small class="float-right">Investment ranges</small>
      </div>

      <div class="card-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item small-padding use-bg ">
            <span class="badge badge-pill custom-warning float-right"><i class="fa fa-check"></i></span>
            Annual Roi: <?=$investment->DetailsArray['annual_roi_percent'];?>%
          </li>

          <li class="list-group-item small-padding use-bg">
            <span class="badge badge-pill custom-warning float-right"><i class="fa fa-check"></i></span>
            Weekly Roi: <?=$investment->DetailsArray['weekly_roi_percent'];?>%
          </li>
        </ul>
        <br>

        <form 
        method="post"
        action="<?=domain;?>/user/select_pack">
        <input type="hidden" name="investment_id" value="<?=$investment->id;?>">

        <div class="form-group">
          <button href="#" class="btn custom-warning">Purchase</button>
        </div>
      </form>


    </div>
  </div>
</div>
</div>

<?php endforeach;?>
</div>




</div>
</div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
