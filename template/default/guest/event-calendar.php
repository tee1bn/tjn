<?php 
$page_title = 'Event Calendar';
$page_description = "Forex Events and Economic Calendar that keeps forex traders in form to fundamentally analyse forex market";

include 'includes/header.php';?>



    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
          
          
        <div class="row">

          <?php include 'includes/sidebar.php';?>


          <div class="col-md-9" style="height: 900px;">

            <!-- TradingView Widget BEGIN -->
            <div class="tradingview-widget-container">
              <div class="tradingview-widget-container__widget"></div>
              <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/markets/currencies/economic-calendar/" rel="noopener" target="_blank"><span class="blue-text">Economic Calendar</span></a> by TradingView</div>
              <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-events.js" async>
              {
              "colorTheme": "light",
              "isTransparent": false,
              "width": "100%",
              "height": "100%",
              "locale": "en",
              "importanceFilter": "0,1"
            }
              </script>
            </div>
            <!-- TradingView Widget END -->

          </div>

          <div class="col-md-12">
            
          </div>



        </div>


        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?php //include 'includes/cutomiser.php';?>


<?php include 'includes/footer.php';?>