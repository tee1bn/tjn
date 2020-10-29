<?php
$page_title = "Instructor";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">



    <?php 
      $this->view('composed/publish-course', compact('course'));
    ;?>





     </div>
   </div>
   <!-- END: Content-->

   <?php include 'includes/footer.php';?>
