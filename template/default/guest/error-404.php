<?php 
$page_title = 'Page not found | Error 404 ';
$page_description = "Looks like the page you are looking for  does not exist.";

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

          <div class="col-md-12">
            <div class="card">
                    <div class="card-content">




                    <!--   <div class="card-body">
                        <h4 class="card-title">Page not found!</h4>
                        <p class="card-text">Looks like the page you are looking for  does not exist.</p>
                      </div> -->
                      <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                        <div class="card collapse-icon panel mb-0 box-shadow-0 border-0">


                          <section class="flexbox-container">
                              <div class="col-12 d-flex align-items-center justify-content-center">
                                  <div class="col-lg-4 col-md-8 col-10 p-0">
                                      <div class="card-header bg-transparent border-0">
                                          <h2 class="error-code text-center mb-2">404</h2>
                                          <h3 class="text-uppercase text-center">Page Not Found !</h3>
                                      </div>
                                      <div class="card-content">

                                          <p class="card-text">We could not find the page you are looking for on <a href="<?=domain;?>"><?=project_name;?></a></p>
                                          <p>May be that:</p>
                                          <ul>
                                            <li>The Url is not spelt correctly. Try to confirm that the url is correctly spelt</li>
                                            <li>The page does not exist</li>
                                            <li>The page has been moved</li>
                                          </ul>

                                          <p>You can use the browsers back button to go back to previous page. or click the button below to go home</p>

                                          <div class="row py-2">
                                              <div class="col-12 mb-1">
                                                  <a href="<?=domain;?>" class="btn btn-outline-light btn-block"><i class="feather icon-home"></i> Home</a>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="card-footer bg-transparent">
                                          <div class="row">
                                              <p class="text-muted text-center col-12 py-1">© <span class="year"><?=date("Y");?></span>
                                               <a href="<?=domain;?>"><?=project_name;?> 
                                              
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </section>

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