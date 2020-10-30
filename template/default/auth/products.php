<?php
$page_title = "Products";
include 'includes/header.php';
?>

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-6 ">
                <?php include 'includes/breadcrumb.php';?>

                <h3 class="content-header-title mb-0">Products</h3>
            </div>

            <div class="content-header-right col-6 mb-2">
                <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">

                    <a class="btn btn-outline-dark" href="<?=Products::userCreateLink();?>">New Product +</a>
                    <!-- <a class="btn btn-outline-primary" href="timeline-center.html"><i class="feather icon-pie-chart"></i></a> -->
                </div>
            </div>

        </div>
        <div class="content-body">



            <div class="card">
                <!-- <div class="card-header"></div> -->
                <div class="card-body">
                    <?php foreach ($products as $key => $product) :?>
                        <div class="list-group">
                            <div class="list-group-item  ">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="text-bold-600"><a href="<?=$product->UserEditLink;?>" title="Edit <?=$product->name;?>">
                                       <?=$product->name;?></a> 
                                       <small><?=$product->ApprovalStatus;?></small>
                                   </h5>
                                   <small>
                                      <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown">
                                          Action
                                      </button>
                                      <div class="dropdown-menu">
                                          <a class="dropdown-item" 
                                          onclick="copy_text(`<?=$product->getPromotionLink($auth->id);?>`)" href="javascript:void(0);">Promotional Link</a>
                                          <!-- <a class="dropdown-item" href="#">Delete</a> -->
                                          <!-- <a class="dropdown-item" href="#">Link 3</a> -->
                                      </div>
                                  </div>
                              </small> </div>
                              <p><?=$product->ShortDescription;?></p>
                              <small><?=$product->currency;?><?=$product->price;?></small>
                          </div>
                      </div>
                  <?php endforeach;?>
              </div>
          </div>


      </div>
  </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>