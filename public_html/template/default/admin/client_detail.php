<?php
$page_title = "Client Detail";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Client Detail</h3>
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



              <h4 class="card-title" style="display: inline;">Client Detail</h4>


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
                <div class="row collapse show"  id="demo" >
                  <div class="col-md-4">
                    <a href="javascript:void(0);"  class="card-title"><h5>Bio Data</h5></a>
                    <?php  echo $this->view('composed/user_detail', compact('user'), true);?>
                  </div>

                  <div class="col-md-4">
                    <a href="javascript:void(0);"  class="card-title"><h5>Documents</h5></a>
                    <?php $this->view('composed/user_documents', compact('user'), true);?>
                  </div>

                  <div class="col-md-4">
                  <a href="javascript:void(0);"  class="card-title"><h5>Bank Accounts</h5></a>
                  <div style="overflow-y: scroll; max-height: 350px;">
                    <?php $this->view('composed/user_bank', compact('user'), true);?>
                  </div>
                  </div>

                  <div class="col-md-4">


                  
                  </div>



                <div class="col-md-12">
                <a href="javascript:void(0);"  class="card-title"><h5>Trading Accounts</h5></a>
                <?php $this->view('composed/user_trading_accounts', compact('user'), true);?>

                </div>

                <div class="col-md-12">
                <a href="javascript:void(0);"  class="card-title"><h5>FX-academy</h5></a>
                <?php $this->view('composed/user_courses', compact('user'), true);?>

                </div>

                </div>

                <?php $this->view('composed/user_transaction_history', compact('user'), true);?>
                <hr />





          </div>
        </div>
      </section>


    </div>
  </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
