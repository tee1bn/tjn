<?php 
$page_title = 'Survey/Quiz on forex trading';
$page_description = "";

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

          <div class="card col-md-12" >
            <div class="card-content">
               <div class="card-body">

                   
                 <div class="container" style="margin-top: 20px;">
                   
                   <?=$questionaire->html_form()->form;?>

                 </div>

               </div>
             </div>
           </div>





        </div>


        </div>
      </div>
    </div>
    <!-- END: Content

    <?php //include 'includes/cutomiser.php';?>


<?php include 'includes/footer.php';?>