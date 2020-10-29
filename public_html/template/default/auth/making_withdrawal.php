<?php
$page_title = "Make Withdrawal";
include 'includes/header.php';

;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
   
    <div class="content-body">

      <div class="app-content "  ng-controller="ShopController">
        <div class="content-header row">
          <div class="content-header-left col-md-6 mb-2">
            <h3 class="content-header-title mb-0">Make Withdrawal</h3>
          </div>
          <div class="content-header-right text-md-right col-md-6">
            
          </div>
        </div>
        <div class="content-body">

          

          <div class="card">
           <div  class="card-content collapse show">
            <div class="card-body card-dashboard">

              <?php require_once 'make-withdrawal.php';?>

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
