<?php
$page_title = "$broker->name - Open Live Account";
 include 'includes/header.php';

 ;?>



    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
          <!-- <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index-2.html">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Gallery</a>
                </li>
                <li class="breadcrumb-item active">Gallery Media Grid
                </li>
              </ol>
            </div>
          </div>

 -->
        <div class="row">

          <?php include 'includes/sidebar.php';?>

          <div class="col-md-9">
            <div class="card">
                    <div class="card-content">
                      <div class="card-body">
                        <h4 class="card-title"><?=$broker->name;?> - Open Live Account</h4>


                                  <?php
                                    $file = $broker->getAccountOpeningPage();
                                    $this->view("composed/live_accounts/$file", compact('broker'));
                                  ;?>




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