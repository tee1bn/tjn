<?php
$page_title = "Make Payment";
include 'includes/header.php';


$payment_details =$order->PaymentDetailsArray;
$livepay_order_id = $payment_details['approval']['order_id'];

;?>



<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0"></h3>
      </div>

    </div>
    <div class="content-body">


      <center>
          <script type="text/javascript"src="https://gw17.livepay.io/gw/paywidget/?orderId=<?=$livepay_order_id;?>">
          </script>
      </center>


    </div>
  </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
