<?php
$page_title = "All Bonuses";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">All Bonuses</h3>
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
                    <?php include_once 'template/default/composed/filters/user.php';?>
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
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#Ref</th>
                      <th>Name (Username)</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Joined / Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>                    

                   <?php  $i=1; foreach ($users as $user) :?>
                    <tr>
                      <td><?=$user->id;?> </td>
                      <td style="text-transform: capitalize;">
                        <?=$user->fullname;?><br>
                       (<?=$user->username;?>)
                       </td>
                      <td><a href="mailto://<?=$user->email;?>"><?=$user->email;?></a></td>
                      <td><a href="tel://<?=$user->phone;?>"><?=$user->phone;?></a></td>
                      <td><span class="badge badge-secondary"><?=$user->created_at->format('M j, Y H:i:A');?></span>
                        <br/><?=$user->activeStatus;?> </td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-xs dropdown-toggle" data-toggle="dropdown">
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
              <?php
              $query_string = $_SERVER['QUERY_STRING'];
              $url = "$domain/admin/users/?$query_string";
              echo $this->pagination_links(20, 2, $url);?>
          </ul>

        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
