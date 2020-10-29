<?php
$page_title = "$page_title";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6  mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0" style="display:inline;"><?=$page_title;?></h3>
          </div>
          
          <div class="content-header-right col-6">
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
            <small class="float-right">Showing <?=$users->count();?> of <?=$data;?> </small>
            <!-- <small class="float-right"><?=$note;?> </small> -->
              <div class="btn-group" role="group">
              <!--   <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div> -->
              </div>
              <!-- <a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a> -->

              <!-- <a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a> -->
            </div>
          </div>
        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">

              <?php include_once 'template/default/composed/filters/users.php';?>
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
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#sn</th>
                      <th>#Id</th>
                      <th>Name (Username)</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Joined / Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>                    

                   <?php  $i=1; foreach ($users as $user) :?>
                    <tr>
                      <td><?=$i;?> </td>
                      <td><?=$user->id;?> </td>
                      <td>
                        <?=$user->DropSelfLink;?><br>
                       </td>
                      <td><a href="mailto://<?=$user->email;?>"><?=$user->email;?></a></td>
                      <td><a href="tel://<?=$user->phone;?>"><?=$user->phone;?></a></td>
                      <td><span class="badge badge-secondary"><?=$user->created_at->format('M j, Y H:i:A');?></span>
                        <br/><?=$user->activeStatus;?> </td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                          </button>
                          <div class="dropdown-menu">
                              <a class="dropdown-item" target="_blank" href="<?=$user->AdminViewUrl;?>">
                                <span type='span' class='label label-xs label-primary'>View</span>
                              </a>
                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=domain;?>/admin/suspending_user/<?=$user->id;?>')">
                                          <span type='span' class='label label-xs label-primary'>Toggle Ban</span>
                              </a>
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

          <ul class="pagination">
              <?= $this->pagination_links($data, $per_page);?>
          </ul>

        </div>
      </div>
    </div>
    <!-- END: Content-->


    <div id="new_category_app"></div>

<?php include 'includes/footer.php';?>
