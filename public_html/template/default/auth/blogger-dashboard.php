<?php
$page_title = "Blogger";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
       
        <div class="content-body">

    <div class="app-content "  ng-controller="ShopController">

        <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6 mb-2">
            <h3 class="content-header-title mb-0">Blogger</h3>
         

          </div>
         <div class="content-header-right text-md-right col-6">
            <div class="form-group"> 
                       <a href="<?=domain;?>/blog/create_post">
                        <button class="btn-icon btn btn-secondary btn-round" type="button">
                          <i class="ft-plus"></i> Create Post
                        </button></a>

           <!--    <button class="btn-icon btn btn-secondary btn-round" type="button"><i class="ft-life-buoy"></i></button>
              <button class="btn-icon btn btn-secondary btn-round" type="button"><i class="ft-settings"></i></button>
           -->  </div>
          </div>
        </div>
        <div class="content-body">

        <div class="card">
           <div  class="card-content collapse show">
                    <div class="card-body card-dashboard"><!-- 
                       <p class="card-text">DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</p> -->
                        <table id="myTable" class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>Post </th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created /Updates</th>
                                    <th>Action</th>
                                    <!--
                                    <th>Payment Type</th>
                                   -->
                                </tr>
                            </thead>
                            <tbody>
                             <?php foreach ($this->auth()->created_blogs as $blog):?>
                                <tr>
                                    <td><b><?=$blog->title ?? '';?></b></td>
                                    <td><b><?=$blog->category->category ?? '';?></b></td>
                                    <td>
                                      <?=$blog->ApprovalStatus;?>
                                      </td>
                                    </td>
                                    <td>
                                      <span class="badge badge-secondary"><?=date("M j, Y h:iA" , strtotime($blog->created_at));?></span>/
                                      <span class="badge badge-warning"><?=date("M j, Y h:iA" , strtotime($blog->updated_at));?></span>
                                        
                                      </td>
                                    <td>


                                      <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-dark dropdown-toggle" data-toggle="dropdown">
                                          Action
                                        </button>
                                        <div class="dropdown-menu">
                        									<a href="<?=domain;?>/blog/edit_post/<?=$blog->id;?>" class="dropdown-item">Edit</a>
                                          <a href="<?=$blog->UserPreviewLink;?>" class="dropdown-item" target="_blank" >Preview</a>
                                          <a onclick="$confirm_dialog=new ConfirmationDialog('<?=domain;?>/shop/submit_for_review/<?=$blog->id;?>/post')" href="javascript:void(0);" class="dropdown-item">Submit </a>                                          
                                        </div>
                                      </div>


                                  </td>
                                    
                                </tr>
                              <?php endforeach ;?>
                            </tbody>
                          
                        </table>
                    </div>
                </div>
        </div>
   
<!--/ User Profile Cards -->


        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
