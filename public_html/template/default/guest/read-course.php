<?php 

$section = (array) $course->CurriculumJson[($chapter -1)];
$lecture = $section['$lectures'][0];
$lecture = (array) $lecture;
$data = $lecture['$data'];
$data = (array) $data;      

$page_title = strip_tags("{$data['$title']} | $course->title");

// $page_description = "{$data['$title']}";

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

          <?php include 'includes/sidebar.php';?>

          <div class="col-md-9">
           
           <?php 
             $this->view('composed/read-course', compact('course','chapter'));
           ;?>


        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?php //include 'includes/cutomiser.php';?>


<?php include 'includes/footer.php';?>