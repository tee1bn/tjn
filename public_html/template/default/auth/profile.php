<?php
$page_title = "Profile";
include 'includes/header.php';?>

<script src="<?=general_asset;?>/js/angulars/registration.js"></script>
<!-- BEGIN: Content-->
<div class="app-content content" ng-controller="RegisterationController">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Profile</h3>
      </div>

      <style>
        .full_pro_pix{
          width: 120px;
          height: 120px;
          object-fit: cover;
          border-radius: 100%;
          border: 1px solid #cc444433;
        }
      </style>


         <!--  <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
              </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a>
            </div>
          </div> -->
        </div>
        <div class="content-body row" ng-controller="ShopController" id="content" ng-cloak>
          <div class=" card col-md-4">
              <!-- <div class="card-header">
                <h4 class="card-title">
                  <a data-toggle="collapse" href="#pix">Profile</a>
                </h4>
              </div> -->
              <div id="pix" class=" collapse show">
                <div class="card-body">

                  <form class="form-horizontal ajax_form" 
                  id="registration_form" method="post" enctype="multipart/form-data" action="<?=domain;?>/user-profile/update_profile_picture">
                  <div class="user-profile-image" align="center" style="">
                    <img id="myImage" src="<?=domain;?>/<?=$auth->profilepic;?>" alt="your-image" class="full_pro_pix" />
                    <input type='file' name="profile_pix" onchange="form.submit();" id="uploadImage" style="display:none ;" />
                    <h4><?=ucfirst($auth->username);?></h4>
                    <h4><?=ucfirst($auth->fullname);?></h4>
                    <?=$auth->activeStatus;?>  <?=$auth->VerifiedBagde;?>
                    <!-- <label for="uploadImage" class="btn btn-secondary " style=""> Change Picture</label> -->
                    
                    <br>
                    <!-- <span class="text-danger">*click update profile to apply change</span> -->
                  </div>
                </form>
                <hr>


                <?php $user = $auth; $this->view('composed/user_documents', compact('user'));?>


              </div>
            </div>
          </div>



          <div class=" card col-md-8">
            <div class="card-header">
              <h4 class="card-title">
                <a data-toggle="collapse" href="#detail">Profile</a>
              </h4>
            </div>
            <div id="detail" class=" collapse show">
              <div class="card-body">
                <?php $user = $auth; $this->view('composed/user_detail', compact('user'));?>

              </div>
            </div>
          </div>



        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?php include 'includes/footer.php';?>
