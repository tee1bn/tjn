<?php 

include 'includes/header.php';?>




    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0"> Courses</h3>
            <div class="row breadcrumbs-top">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=domain;?>">
                  Home</a>
                  </li>
                  <li class="breadcrumb-item active"><a href="#">All Courses</a>
                  </li>
               
                </ol>
              </div>
            </div>
          </div>

          <div class="content-header-right col-md-6 col-12">
           
          </div>
      </div>

        <?php include "$template/composed/shop/shop.php";?>

      </div>


    </div>

    <?php //include 'includes/cutomiser.php';?>


<?php include 'includes/footer.php';?>