<?php 
$page_title = 'Frequently asked questions about Forex Fx and Profit trading ';
$page_description = "Questions on trading forex markets from nigeria using services provided by $project_name";

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
            <div class="card">
                    <div class="card-content">
                      <div class="card-body">
                        <h4 class="card-title">Frequently Asked Questions</h4>
                        <p class="card-text">Some commonly asked questions and their responses.</p>
                      </div>
                      <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                        <div class="card collapse-icon panel mb-0 box-shadow-0 border-0">


                          <?php 

                          $faqs = SiteSettings::where('criteria','faqs')->first()->settingsArray;


                          foreach ($faqs as $key => $faq) :?>


                          <div id="heading11" role="tab" class="card-header border-bottom-blue-grey border-bottom-lighten-2">
                            <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion1<?=$key;?>" aria-expanded="true" aria-controls="accordion1<?=$key;?>" class="h6 blue">
                             #<?=$key + 1;?> &nbsp; &nbsp; <?=$faq['question'];?> </a>
                          </div>
                          <div id="accordion1<?=$key;?>" role="tabpanel" aria-labelledby="heading11" class="collapse " aria-expanded="true">
                            <div class="card-body">
                              <p class="card-text"> <?=$faq['answer'];?></p>
                            </div>
                          </div>
                        <?php endforeach;?>


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