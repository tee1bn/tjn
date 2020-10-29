<?php
$page_title = "Access Control";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Access Control</h3>
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

          <div class="dropdown" style="display: inline;">
            <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-filter"></i>
            </button>
              <div class="dropdown-menu">

            </div>
          </div>

          <h4 class="card-title" style="display: inline;"></h4>


          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>

            <div class="col-md-3">
                <table class="table table-striped table-sm">
                    <tr>
                      <td>Name  (L M F)</td>
                      <td><?=$admn->DisplayTitle;?> <?=$admn->fullname;?></td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td><?=$admn->email;?></td>
                    </tr>
                    <tr>
                      <td>Phone</td>
                      <td><?=$admn->phone;?></td>
                    </tr>
                    <tr>
                      <td>Registration date</td>
                      <td><?=date("M j, Y", strtotime($admn->created_at));?>
                        <?=$admn->activeStatus;?>
                      </td>
                    </tr>
                </table>
              </div>



         <div class="card-content">
          <div class="card-body">       

              <div class="col-md-12">
                <?php $sidebar_menus =  Access::where('url', '!=', null)->orderBy('category')->orderBy('name')->get()->groupBy('category')->toArray();?>

                <form method="post" class="ajax_form" action="<?=domain;?>/access_crud/update_admin_access" class="col-md-12">
                    <input type="hidden" name="admin_id" value="<?=$admn->id;?>">

                    <?php foreach ($sidebar_menus as $category => $menu) :?>
                      <h5 style="font-weight: bold; text-transform: capitalize;"><?=$category;?></h5> <hr>
                      <div class="form-group row">
                        <?php foreach ($menu as $key => $submenu) :?>
                          <div class="col-md-3">
                              <label style="cursor: pointer; text-transform: capitalize;"><?=$submenu['name'];?> 
                                <input type="checkbox" name="access[<?=$submenu['id'];?>]" 
                                  <?=(in_array($submenu['id'], $admn->admin_access->AccessesArray))? 'checked' : '';?>
                                > 
                              </label>  
                          </div>
                        <?php endforeach;?>
                    </div>                        
                    <?php endforeach;?>




                      
                        

                    <div class="form-group">
                      <button class="btn btn-success">Update</button>
                    </div>
                </form>
                
              </div>

          


              
          </div>
        </div>
      </section>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
