<?php
$page_title = "2FA Authentication";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <!-- <h3 class="content-header-title mb-0">2FA Authentication </h3> -->
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
              <h4 class="card-title">2FA Authentication  <?=$auth->TwofaDisplay;?></h4>
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
                <small class="card-text">
                  <p>
                    Google Authenticator is a free app for your smart phone that generates a new code every 30 seconds. It works like this:

                    When enabling 2FA, the application you’re securing generates a QR code that user’s scan with their phone camera to add the profile to their Google Authenticator app.

                    Your smart phone generates a new code every 30 seconds to use for the second part of Authentication to the application.
                    Please Open Google Authenticator and scan following QR Code:
                  </p>
                  <center>

                    <?php if (!$auth->has_2fa_enabled()) :?>
                      <p>
                        <?=$image;?>
                      </p>
                    <?php endif ;?>
                    <form action="<?=domain;?>/user/submit_2fa" method="POST" id="2fa_form">
                      <div class="">

                        <div class="col-md-4">

                          <div class="form-group">
                            <label class="float-left">Enter Code:</label>
                            <input type="" name="code" class="form-control" required="">
                          </div>


                          <?php
                            $submit_text = [0=>'Enable', 1=>'Disable'][intval($auth->has_2fa_enabled())];
                            
                            $dialog_text = [
                                          0=>'Are you sure you want to <b>ENABLE 2FA</b> ?', 
                                          1=>'Are you sure you want to <b>DISABLE 2FA</b> ? '
                                        ][intval($auth->has_2fa_enabled())];

                          ;?>

                          <div class="form-group text-left">
                            <button type="button" onclick="$confirm_dialog = new DialogJS(submit_2fa,[],'<?=$dialog_text;?>')" class="btn"><?=$submit_text;?></button>
                            <button id="btn" style="display: none;"></button>
                          </div>

                        </div>
                      </div>
                    </form>

                    <script>
                      submit_2fa = function(){
                        $('#btn').click();
                      }
                      
                    </script>
                  </center>

                </small>
              </div>
            </div>
          </section>


    <!--   <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">blank</h4>
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
