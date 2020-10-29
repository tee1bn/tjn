<?php
$page_title = "Accesses";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Accesses</h3>
            <a href="<?=domain;?>/access_crud/create_access" class="btn btn-dark btn-sm" >Create Access</a>
          </div>
          
        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">

              <div class="dropdown" style="display: inline;">
                <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-filter"></i>
                </button>

                  <div class="dropdown-menu">
                    <?php include_once 'template/default/composed/filters/leads.php';?>
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
             <div class="card-content">
              <div class="card-body table-responsive">
                <table id="myTable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#Ref</th>
                      <th>Name</th>
                      <th>Category</th>
                      <th>Url</th>
                      <th>Admin</th>
                      <th>Created/Updated</th>
                      <th>Action</th>
                    </tr>
                  </thead>                    

                   <?php  $i=1; foreach ($accesses as $access) :?>
                    <tr>
                      <td><?=$access->id;?> </td>
                      <td><?=$access->name;?> <?=$access->activeStatus;?></td>
                      <td><?=$access->category;?></td>
                      <td><?=$access->url;?></td>
                      <td><?=$access->by_admin->fullname ?? '';?></td>
                      <td><span class="badge badge-dark"><?=date('M j, Y h:iA', strtotime($access->created_at));?></span>
                        <span  class="badge badge-secondary"> <br><?=date('M j, Y h:iA', strtotime($access->updated_at));?></td></span>
                      <td>
<!--                           <button type="button" class="btn btn-secondary btn-xs dropdown-toggle" data-toggle="dropdown">
                          </button>
 -->                              <a class="btn btn-sm btn-dark" target="_blank" href="<?=$access->ViewUrl;?>">
                                <span type='span' class='label label-sm label-primary'>Edit</span>
                              </a>
                              <a  class="btn btn-sm btn-danger"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=domain;?>/access_crud/delete_access/<?=$access->id;?>')">
                                          <span type='span' class='label label-sm label-primary'>Delete</span>
                              </a>
                        <div class="dropdown">
                          <div class="dropdown-menu">
                          </div>
                        </div>

                      </td>
                    </tr>
                
                    <?php $i++; endforeach ; ?>
                       
                
                      </tbody>
                    </table>                               

                  
              </div>
            </div>
          </section>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
