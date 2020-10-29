<?php
$page_title = "Courses";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">

  	<!-- <button>Course Verification</button> -->

      <?php 
        $this->view('composed/single-course', compact('course','access'));
      ;?>



</div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
