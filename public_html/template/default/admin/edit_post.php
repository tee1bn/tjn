<?php
$page_title = "Edit Post";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Edit Post  <?=$post->ApprovalStatus;?></h3>
          </div>
          <div class="content-header-right text-md-right col-md-6 col-12">
                    <div class="form-group"> 
                               <a href="<?=domain;?>/blog/create_post">
                                <button class="btn-icon btn btn-secondary btn-round" type="button">
                                  <i class="ft-plus"></i> Create Post
                                </button></a>

                      <a class="btn-icon btn btn-secondary btn-round" type="a" href="<?=$post->UserPreviewLink;?>"
                       title="Preview" target="_blank"><i class="fa-eye"></i>Preview</a>
                    </div>
                  </div>
        </div>
        <div class="content-body">

          <?php $this->view('composed/edit_post', compact('post'));?>



     
        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
