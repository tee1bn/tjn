<?php
$page_title = "Bank Transfer";
 include 'includes/header.php';

 ;?>


 <script src="https://js.paystack.co/v1/inline.js"></script>
  <script src="<?=general_asset;?>/js/payments/paystack-checkout.js"></script>


  <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
  <script src="<?=general_asset;?>/js/payments/rave-checkout.js"></script>



    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
       
        <div class="content-body">

              <div class="app-content">

                    <div class="content-wrapper">
                <!--   <div class="content-header row">
                    <div class="content-header-left col-6 mb-2">
                      <h3 class="content-header-title mb-0">Bank Transfer</h3>
                    </div>
                   <div class="content-header-right text-right col-6">

                    </div>
                  </div> -->
                  <div class="content-body">

              

                  <div class="card">
                     <div  class="card-content collapse show">

                      <iframe style="height: 564px;width: 100%;" src="<?=domain;?>/user/show_invoice/<?=$order->id;?>/<?=$type;?>" frameborder="0" scrolling="no" onload="resizeIframe(this)" ></iframe>


                          </div>
                      </div>
                  </div>
                </div>
              </div>

              <script>
                function resizeIframe(obj) {
                  obj.style.height = obj.contentWindow.document.documentElement.scrollHeight + 'px';
                }
              </script>
        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
