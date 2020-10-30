<?php 
$page_title = 'Support Messages ';
$page_description = "Client can respond to support messages on forex";

include 'includes/header.php';?>



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




            <?php
              $template = Config::views_template();
             require_once "template/$template/composed/support_chat.php";?>



<!-- 
          <div class="col-md-3">
              
              Basic Funding etc
          </div>

          <div class="col-md-9">
            Slider and details

          </div>

          <div class="col-md-12">
            
          </div>
 -->


        </div>


        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?php //include 'includes/cutomiser.php';?>


<?php include 'includes/footer.php';?>