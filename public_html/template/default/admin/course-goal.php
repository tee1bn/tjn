<?php
$page_title = "Course Goal";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
       


        <?php 
          $this->view('composed/course-goal', compact('course'));
        ;?>





        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
