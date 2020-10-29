<?php
$page_title = "FAQs";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <!-- <h3 class="content-header-title mb-0">FAQs</h3> -->
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
              <h4 class="card-title">FAQs</h4>
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

                <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                  <div class="card collapse-icon panel mb-0 box-shadow-0 border-0">


                    <?php 

                    $faqs = SiteSettings::where('criteria','faqs')->first()->settingsArray;

                      $i=1;
                      foreach ($faqs as $key => $faq) :
                      if ((@$faq['question'] == '') || ($faq['answer'] == '') ) {continue;}
                      ?>


                    <div id="heading11" role="tab" class="card-header border-bottom-blue-grey border-bottom-lighten-2">
                      <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion1<?=$key;?>" aria-expanded="true" aria-controls="accordion1<?=$key;?>" class="h6 "> #<?=$i++;?> &nbsp;&nbsp;&nbsp; <?=$faq['question'];?> </a>
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
          </section>

        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?php include 'includes/footer.php';?>
