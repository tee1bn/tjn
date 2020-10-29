<?php
$page_title = "Edit Access";
 include 'includes/header.php';?>

 <datalist id="category_list">
   <?php foreach (array_unique(Access::all()->pluck('category')->toArray()) as  $category):?> 
     <option><?=$category;?></option>
   <?php endforeach;?> 
 </datalist>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Edit Access</h3>
            <a href="<?=domain;?>/access_crud/create_access" class="btn btn-dark btn-sm" >Create Access</a>
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

          <h4 class="card-title" style="display: inline;"></h4>


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

            
            <form class="ajax_for" action="<?=domain;?>/access_crud/update_access" method="post">
              <input type="hidden" name="access_id" value="<?=$db_access->id;?>">
          
              <div class="form-group">
                    <label for="firstName" class="pull-left">Name *</label>
                    <input type="text" name="name"  value="<?=$db_access->name;?>" required="" value=""  class="form-control">
              </div>
         
              <div class="form-group">
                    <label for="category" class="pull-left">Category <sup>*</sup></label>
                    <input type="text" name="category" id="category" list="category_list" class="form-control"  required="" value="<?=$db_access->category;?>">
              </div>

                  
              <div class="form-group">
                    <label for="url" class="pull-left">url <sup>*</sup></label>
                    <input type="text" name="url" id="url" class="form-control"  required="" value="<?=$db_access->url;?>">
              </div>

              
              <div class="row">
                  

                <div class="form-group col-md-6">
                      <label for="status" class="pull-left">status <sup>*</sup></label>
                      <input type="text" name="status" id="status" class="form-control"  required="" value="<?=$db_access->status;?>">
                </div>

                    
                         
                <div class="form-group col-md-6">
                      <label for="status" class="pull-left">Sidenav <sup>*</sup></label>
                      <input type="text" name="sidenav"  class="form-control"  required="" value="<?=$db_access->sidenav;?>">
                </div>
                    
              </div>
            
              <div class="form-group">

                    <button type="submit" class="btn btn-secondary btn-block btn-flat">Save</button>

              </div>
            </form>



              
          </div>
        </div>
      </section>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
