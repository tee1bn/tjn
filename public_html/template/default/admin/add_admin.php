<?php
$page_title = "Add Admin";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Add Admin</h3>
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

          <h4 class="card-title" style="display: inline;">New Admin</h4>


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

            
            <form class="ajax_for" action="<?=domain;?>/admin-profile/add_admin" method="post">
              <input type="hidden" name="admin_id" value="">
          
              <div class="form-group">
                    <label for="firstName" class="pull-left">First Name *</label>
                    <input type="text" name="firstname"  required="" value="" id="firstName" class="form-control">
              </div>

              <div class="form-group">
                    <label for="lastName" class="pull-left">Last Name <sup>*</sup></label>
                    <input type="text" name="lastname" id="lastName" class="form-control"  required="" value="">
              </div>

            <div class="form-group">
                <label for="email" class="pull-left">Email Address<sup>*</sup></label>
                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                    <span class="input-group-btn input-group-prepend"></span>
                    <input id="tch3" name="email"   required="" value=""
                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                    
                </div> 
            </div>

            


            <div class="form-group">
                <label for="phone" class="pull-left">Phone<sup>*</sup></label>
                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                    <span class="input-group-btn input-group-prepend"></span>
                    <input id="tch3" name="phone"   required="" value=""
                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                </div> 
            </div>                                        
            
              <div class="form-group">

                    <button type="submit" class="btn btn-secondary btn-block btn-flat">Save</button>

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
