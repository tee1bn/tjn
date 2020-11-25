<?php 
$page_title = 'Terms of service';
$page_description = "Terms of service and conditions";

include 'includes/header.php';?>



    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
      
        <div class="row">

          <div class="col-md-12">
            <div class="card">
                    <div class="card-content">




                      <div class="card-body">

                        <?=CMS::fetch('terms');?>


                      </div>



                    </div>
                  </div>

            
          </div>

         


        </div>


        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?php //include 'includes/cutomiser.php';?>


<?php include 'includes/footer.php';?>