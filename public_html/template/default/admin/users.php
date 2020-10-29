<?php
$page_title = "Users";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Users</h3>
            
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
          <h4 class="card-title">Users</h4>
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


                                          <table id="myTable" class="table table-bordered table-striped">
                      <thead>
                          <tr>
              <th>#Ref</th>
                          <th>Name (Username)</th>
                          <!-- <th>Membership</th> -->
                          <th>Email</th>
                          <th>Joined</th>
                          <th>Status</th>
                          <th>Action</th>
            </tr>
          </thead>

                      

         <?php  $i=1; foreach (User::get() as $user) :
         $date   = $user->created_at->toFormattedDateString();   

         ?>

                          <tr>
                          <td><?=$user->id;?> </td>
                          <td style="text-transform: capitalize;">
                            <?=$user->fullname;?><br>
                           (<?=$user->username;?>)
                           </td>
                          <!-- <td><? //=$user->subscription->package_type;?> </td> -->
                          <td><a href="mailto://<?=$user->email;?>"><?=$user->email;?></a></td>
                          <td><span class="badge badge-secondary"><?=$date;?></span></td>
                          <td><?=$user->activeStatus;?> </td>
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



        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
