<?php
$page_title = "$page_title";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0" style="display:inline;"><?=$page_title;?></h3>
            <small class="float-right">Showing <?=$users->count();?> of <?=$data;?> </small>
          </div>
          
          <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
              <!--   <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div> -->
              </div>
              <!-- <a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a> -->
              <?=MIS::generate_form(['model'=>'User','user_foreign_key' => 'id'], "$domain/category_crud/new_category_app", 'Save into Category ', 'open_new_category_modal');?>

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


                              <a class="dropdown-item" target="_blank" href="<?=$user->AdminEditUrl;?>">
                                <span type='span' class='label label-xs label-primary'>Edit</span>
                              </a>

                              <?php if (! $user->has_verified_phone()) :?>
                              <a class="dropdown-item" href="javascript:void(0)'">
                                <span type='span' class='label label-xs label-primary'> <?=MIS::generate_form(
                                  ['user_id'=> $user->id],
                                  "$domain/user_doc_crud/verify_phone",
                                  'Verify Phone'
                                  
                                  );?></span>
                              </a>
                              <?php endif;?>

                              <?php if (! $user->has_verified_email()) :?>
                              <a class="dropdown-item" href="javascript:void(0)'">
                                <span type='span' class='label label-xs label-primary'> <?=MIS::generate_form(
                                  ['user_id'=> $user->id],
                                  "$domain/user_doc_crud/verify_email",
                                  'Verify Email'
                                  
                                  );?></span>
                              </a>
                              <?php endif;?>



                              <a class="dropdown-item" target="_blank" href="<?=$user->CommentViewUrl;?>">
                                <span type='span' class='label label-xs label-primary'>Comment</span>
                              </a>

                              <a class="dropdown-item" target="_blank" href="<?=$user->AdminLoginUrl;?>">
                                <span type='span' class='label label-xs label-primary'>Dedicated Log</span>
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
              <?php
              $query_string = $_SERVER['QUERY_STRING'];
              $url = "$domain/admin/all_users/?$query_string";
              echo $this->pagination_links($data, $per_page, $url);?>
          </ul>

        </div>
      </div>
    </div>
    <!-- END: Content-->



<?php include 'includes/footer.php';?>
