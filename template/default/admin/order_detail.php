<?php
$page_title = "Order Detail";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Order Detail</h3>
          </div>
          
          <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">

                      <div class="dropdown float-right ">
                        <button type="button" class="btn btn-outline-dark dropdown-toggle" data-toggle="dropdown">
                          Actions
                        </button>

                        <div class="dropdown-menu">
                      <!--   <a href="<?=domain;?>/admin/order_download_request/<?=$order->id;?>" class="dropdown-item"> 
                             Download <i class="fa fa-download"></i>
                        </a> -->
     
                        <a  href="javascript:void(0);" onclick="$confirm_dialog = new ConfirmationDialog('<?=domain;?>/admin-products/mark_as_complete/<?=$order->id;?>')" 
                           class="dropdown-item"> 
                             Mark as Paid 
                          <i class="fa fa-check"></i>
                        </a>
     
                      
                        </div>
                      </div>

            </div>
          </div>
        </div>
        <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Order Detail</h4>
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
         <?php 
           $remove_mle_detail = true;
           echo $this->buildView('composed/invoice', compact('order','remove_mle_detail'));?>



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
