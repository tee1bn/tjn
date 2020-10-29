<?php
$page_title = "Account Settings";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Account Settings</h3>
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
          <h4 class="card-title">Change Password</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
         <div class="card-content">
      <div class="card-body">
        

                                                           
         <form  method="post" action="<?=domain;?>/admin-profile/updatePassword" style="padding: 10px;">
              <?=@$this->csrf_field('change_password');?>
                <div class="form-group">
               <input type="password" name="current_password" class="form-control" placeholder="Current Password">
                  <span class="text-danger"><?=@$this->inputError('current_password');?></span>
                </div>

                <div class="form-group">
                  <input type="password"  name="new_password" class="form-control" placeholder="New Password">
                <span class="text-danger"><?=@$this->inputError('new_password');?></span>
                </div>

                <div class="form-group">
                  <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password">
                  <span class="text-danger"><?=@$this->inputError('confirm_password');?></span>
               </div>

                <div class="row">
                  <div class="col-sm-6">
                    <button type="submit" class="btn btn-success btn-block btn-flat">Submit</button>
                  </div>
                  <!-- /.col -->
                </div>
            </form>






      </div>
    </div>
      </section>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
