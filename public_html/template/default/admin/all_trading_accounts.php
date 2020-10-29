<?php
$page_title = "Trading Accounts";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Trading Accounts</h3>
          </div>

          
          <div class="content-header-right col-6 ">
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">

            <small class="float-right">Showing <?=$trading_accounts->count();?> of <?=$data;?> </small>

              <!-- div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
              </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a> -->
            </div>
          </div>
        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">

              <?php include_once 'template/default/composed/filters/trading_accounts.php';?>
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
              <div class="card-body table-responsive" >
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#sn</th>
                      <th>User</th>
                      <th>Broker/Account</th>
                      <th>LPR/Status<br>date</th>
                      <th>Action</th>
                    </tr>
                  </thead>                    

                   <?php  $i=1; foreach ($trading_accounts as $account) :?>
                    <tr>
                      <td><?=$i;?> </td>
                      <td style="text-transform: capitalize;">
                        <?=$account->user->DropSelfLink;?><br>
                       </td>
                      <td><?=$account->broker->name;?> <br> <?=$account->account_number;?> </td>
                      <td>
                        <?=$account->DisplayLPRStatus;?><?=$account->DisplayActiveStatus;?><br>
                      <span class="badge badge-secondary"><?=date('M j, Y h:iA',strtotime($account->created_at));?></span>
                      </td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                          </button>
                          <div class="dropdown-menu">
                              <a class="dropdown-item" target="_blank" href="<?=$account->AdminViewUrl;?>">
                                <span type='span' class='label label-sm label-primary'>View</span>
                              </a>
                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=domain;?>/admin/suspending_account/<?=$account->id;?>')">
                                          <span type='span' class='label label-sm label-primary'>Toggle Ban</span>
                              </a>


                              <a class="dropdown-item" href="javascript:void(0)'">
                                <span type='span' class='label label-xs label-primary'> <?=MIS::generate_form(
                                  ['account_id'=> $account->id],
                                  "$domain/user_doc_crud/toggle_lpr",
                                  'Toggle LPR'
                                  
                                  );?></span>
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
              $url = "$domain/admin/accounts/?$query_string";
              echo $this->pagination_links($data, $per_page, $url);?>
          </ul>

        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
