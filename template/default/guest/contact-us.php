<?php 
$page_title = 'Contact us now for any enquiries about our services';
$page_description = "";

$site_setting = SiteSettings::find_criteria('site_settings')->settingsArray;
include 'includes/header.php';?>



    <!-- BEGIN: Content-->
    <div class="app-content container center-layout mt-2">
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
          <div class="col-md-12">             
            <div class="row">
              <div class="card col-md-6" style="">
                <div class="card-content">
                  <div class="card-body">
                    <h4 class="card-title">Contact us</h4>
                    <h6 class="card-subtitle text-muted">Support</h6>
                  </div>

                 
                  <div class="card-body">
                        <div class="col-sm-12">
                          <div class="card bg-">
                            <div class="card-content">
                              <div class="card-body">
                                <h4 class="card-title">Phone Number</h4>
                                <p class="card-text"><a href="tel://<?=$site_setting['contact_phone'];?>"><?=$site_setting['contact_phone'];?></a></p>
                              </div>
                            </div>
                          </div>
                        </div>
                     
                        <div class="col-sm-12">
                          <div class="card bg-">
                            <div class="card-content">
                              <div class="card-body">
                                <h4 class="card-title">Email Address</h4>
                                <p class="card-text"><a href="mailto://<?=$site_setting['support_email'];?>"><?=$site_setting['support_email'];?></a></p>
                              </div>
                            </div>
                          </div>
                        </div>
                     
                    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                  </div>
                </div>
              </div>


              <div class="card col-md-6">
                      <div class="card-content">
                        <div class="card-body">
                          <h4 class="card-title">Contact Form</h4>
                          <h6 class="card-subtitle text-muted">Kindly fill the form below to contact us</h6>
                        </div>
                        <div class="card-body">
          <!-- Contact FORM -->
          <form class="form ajax_form" id="contact" method="post" action="<?=domain;?>/home/contact_us">
              <div class="row">
                  <div class="col-md-12 col-lg-12">

                      <div class="form-group">
                          <input class="form-control" id="name" type="text" required="" name="full_name" placeholder="Your Name">
                      </div>
                      <div class="form-group">
                          <input class="form-control" id="email" type="text" required="" name="email" placeholder="Email">
                      </div>
                      <div class="form-group">
                          <input class="form-control" id="sub" type="text" required="" name="phone" placeholder="Phone">

                      </div>
                  </div>
                  <div class="col-md-12 col-lg-12">
                      <div class="form-group">

                          <textarea class="form-control" id="message" rows="4" name="comment" required=""
                           placeholder="Your Message"></textarea>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <br>
                      <?=MIS::use_google_recaptcha();?>
                  </div>


                  <div class="col-md-12 col-lg-12 mt-30">
                      <button class="btn-dark btn" type="submit" id="submit" name="button">
                          Send Message
                      </button>
                  </div>
              </div>
          </form>                     

<!-- 
                          <form class="form">
                            <div class="form-body">
                              <div class="form-group">
                                <label for="donationinput1" class="sr-only">Name</label>
                                <input type="text" id="donationinput1" class="form-control" placeholder="name" name="name">
                              </div>

                              <div class="form-group">
                                <label for="donationinput2" class="sr-only">Email</label>
                                <input type="email" id="donationinput2" class="form-control" placeholder="email" name="email">
                              </div>

                              <div class="form-group">
                                <label for="donationinput7" class="sr-only">Message</label>
                                <textarea id="donationinput7" rows="5" class="form-control square" name="message" placeholder="message"></textarea>
                              </div>
                            </div>

                            <div class="form-actions center">
                              <button type="submit" class="btn btn-outline-primary">Send</button>
                            </div>
                          </form> -->
                        </div>
                      </div>
              </div>

            </div>
          </div>



        </div>


        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?php //include 'includes/cutomiser.php';?>


<?php include 'includes/footer.php';?>