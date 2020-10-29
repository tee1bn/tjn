<?php
$page_title = "Connection";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Connection</h3>
      </div>

    </div>
    <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Connection</h4>
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
            <div class="card-text">

              <div class="row">

                <div class="col-md-6">

                  <small>This is a one time step. Kindly enter the email attached to your student account at <a href="<?=Config::main_domain();?>"><?=project_name;?></a><br>
                    This will enable us link your affiliate account to your student account.
                  </small>

                  <form action="<?=domain;?>/connect/connect" method="post" class='ajax_form' data-function="confirm_connection">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" name="email" required="">
                    </div>
                    <div class="form-group">

                      <button class="btn btn-outline-dark" type="submit">Connect</button>
                    </div>
                  </form>

                </div>
                <div class="col-md-6">
                    <span id="preview"></span>
                  
                </div>

              </div>

              <script>


                finish_connection = function($data){

                  if ($data.response==true) {
                    window.location.href = $base_url+"/user";
                  }

                }

                
                confirm_connection = function($data){
                  $("#preview").html($data.view);
                }
              </script>


            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
