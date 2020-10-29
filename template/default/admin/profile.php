<?php
$page_title = "Profile";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Profile</h3>
          </div>
          
         <!--  <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
              </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a>
            </div>
          </div> -->
        </div>
        <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Profile</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
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


         <div class="card-content">

                                    <div class="card-body row">
                                <div class="col-md-4" style="
    margin-bottom: 20px;
    border: 1px solid #14181f42;
    padding: 19px;">
                                   <form class="form-horizontal" id="p_form" method="post" enctype="multipart/form-data" action="<?=domain;?>/user-profile/update_profile_picture">
                                      <div class="user-profile-image" align="center" style="">
                                        <img id="myImage" src="<?=domain;?>/<?=$admin->profilepic;?>" alt="your-image" class="full_pro_pix" />
                                        <input type='file' name="profile_pix" onchange="form.submit();" id="uploadImage" style="display:none ;" />
                                        <h4><?=ucfirst($admin->username);?></h4>
                                        <h4><?=ucfirst($admin->fullname);?></h4>
                                        <?=$admin->activeStatus;?>
                                        <!-- <label for="uploadImage" class="btn btn-secondary " style=""> Change Picture</label> -->
                                        <br>
                                        <!-- <span class="text-danger">*click update profile to apply change</span> -->
                                      </div>
                                    </form>
                                </div>

                                <div class="col-md-8" style="
    margin-bottom: 20px;
    border: 1px solid #14181f42;
    padding: 19px;">


                                        <div class="card-body card-body-bordered collapse show" id="demo1" >
                                          
                                            <form class="ajax_form" action="<?=domain;?>/admin-profile/updateAdminProfile/<?=$admin->id;?>" method="post">
                                              <input type="hidden" name="admin_id" value="">
                                              <div class="form-group">
                                                <label for="username" class="pull-left">Username *</label>
                                                  <input type="text" name="username"  value="<?=$admin->username;?>" id="username" class="form-control" value="">
                                              </div>

                                              <div class="form-group">
                                                    <label for="firstName" class="pull-left">First Name *</label>
                                                    <input type="text" name="firstname"  value="<?=$admin->firstname;?>" id="firstName" class="form-control">
                                              </div>

                                              <div class="form-group">
                                                    <label for="lastName" class="pull-left">Last Name <sup>*</sup></label>
                                                    <input type="text" name="lastname" id="lastName" class="form-control"  value="<?=$admin->lastname;?>">
                                              </div>

                                            <div class="form-group">
                                                <label for="email" class="pull-left">Email Address<sup>*</sup></label>
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-btn input-group-prepend"></span>
                                                    <input id="tch3" name="email"   value="<?=$admin->email;?>"
                                                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                                                    <span class="input-group-btn input-group-append">
                                                        <button class="btn btn-secondary btn-outline bootstrap-touchspin-up" type="button">Require Verification</button>
                                                    </span>
                                                </div> 
                                            </div>

                                        


                                            <div class="form-group">
                                                <label for="phone" class="pull-left">Phone<sup>*</sup></label>
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span class="input-group-btn input-group-prepend"></span>
                                                    <input id="tch3" name="phone"   value="<?=$admin->phone;?>"
                                                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                                                    <span class="input-group-btn input-group-append">
                                                        <button class="btn btn-secondary btn-outline bootstrap-touchspin-up" type="button">Require Verification</button>
                                                    </span>
                                                </div> 
                                            </div>                                        
                                        
                                           
                                              <div class="form-group">

                                                    <button type="submit" class="btn btn-secondary btn-block btn-flat">Save</button>

                                              </div>
                                            </form>



                                        </div>


                                </div>


          
      </div>
    </div>
      </section>


    <!--   <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Profile</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
      </section> -->


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
