<?php 
$page_title = 'Forex Signals and Profit trading ';
$page_description = "Trade the markets by following the best free trading signals! provided by $project_name analyst desk";

use v2\Models\Signals;

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
            <div class="card">
                    <div class="card-content">
                      <div class="card-body">
                        <h4 class="card-title">FX Signals</h4>
                        <p class="card-text">Trade the forex markets by following reliable trading signals.</p>
                      </div>
                      <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                        <div class="card collapse-icon panel mb-0 box-shadow-0 border-0">


                          <?php 
                          $today = date("Y-m-d");
                          $signals = Signals::Published()->whereDate('published_at', $today)->get();

                        foreach ($signals as $key => $signal) :
                              $this->view("composed/signal", compact('signal'), true);

                            ?>

                          <?php endforeach;?>
                          <?php if($signals->isEmpty()) :?>
                            <div class="card-body text-center">
                              There is no signal at the moment. 
                              <a href="<?=domain;?>/register">Register to subscribe and receive alerts for Signals</a>
                            </div>
                          <?php endif ;?>


                  

                          <br>
                          <hr>
                          <div class="card-body">
                            <div class="signal-terms">
                              <small class="text-muted">
                                <p>
                                These signals are provided "as is" by 9gforex.com (www.9gforex.com.com) and by using it, you agree to idemnify us from any liability which may arise directly or indirectly from using it. While our signals provide about 83% accuracy, we implore that you try it on your demo account before you use them on your live account.
                              </p>
                              <p>

                                Forex Trading has high level of risk. So do not use money you cannot afford to lose to trade Forex. Do not trade with more than 10% of your account size, trading the Forex Markets may not be suitable for you.
                              </p>
                              </small>
                            
                            </div>
                          </div>
                  


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