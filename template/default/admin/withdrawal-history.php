<?php
$page_title = "Withdrawals";
include 'includes/header.php';
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Withdrawals</h3>
      </div>

          <div class="content-header-right col-6">
            <small class="float-right"><?=$note;?>  </small>
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
            </div>
          </div>
        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">

              <div class="col-6">
                
                    <?php include_once 'template/default/composed/filters/withdrawals.php';?>
          
              </div>

              <div class="heading-elements text-right">

                <div class="dropdown"  style="display: inline;">
                  <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                    Bulk Action
                  </button>
                  <div class="dropdown-menu">

                      <a  class="dropdown-item"  href="javascript:void;" 
                       onclick="$confirm_dialog = new DialogJS(process_bulk_action, ['pend'] ,'These will be marked as pending?')">
                               <span type='span' class='label label-xs label-primary'>Pend</span>
                      </a>

                      <a  class="dropdown-item"  href="javascript:void;" 
                       onclick="$confirm_dialog = new DialogJS(process_bulk_action, ['complete'] ,'These will be marked as completed?')">
                               <span type='span' class='label label-xs label-primary'>Complete</span>
                      </a>

                      <a  class="dropdown-item"  href="javascript:void;" 
                       onclick="$confirm_dialog = new DialogJS(process_bulk_action, ['decline'] ,'These will be marked as Declined?')">
                               <span type='span' class='label label-xs label-primary'>Decline</span>
                      </a>


                      <a  class="dropdown-item"  href="javascript:void;" 
                                 onclick="$confirm_dialog = new DialogJS(process_bulk_action, ['export_csv'] ,'Export to CSV ?')">
                               <span type='span' class='label label-xs label-primary'>Export to CSV</span>
                      </a>

                      


                  </div>
                </div>

                <input type="checkbox" name="" onclick="toggle_all_records(this)" id="all_records">

              </div>
            </div>
            <div class="card-content">


              <div class="card-body table-responsive">

                <table id="myTabl" class="table table-striped">
                  <thead>
                    <tr>
                      <th>Sn <br> #ID</th>
                      <th>User</th>
                      <th>Amount<br> - Fee(<?=$currency;?>) <hr> payable</th>
                      <th>Method</th>
                      <th>Status <br> Date</th>
                      <th>Action</th>
                      <th>Select</th>
                    </tr>
                  </thead>

                  <form action="<?=domain;?>/withrawals/process_bulk_action" method="POST" id="bulk_action_form">
                  <tbody>

                    <?php if ($withdrawals->isEmpty()) :?>
                    <tr>
                      <td colspan="6">No Records Found</td>
                    </tr>
                    <?php endif  ;?>

                   <?php $i=1; foreach ($withdrawals as $withdrawal):
                    $detail = $withdrawal->MethodDetailsArray;
                    $method = $withdrawal->withdrawal_method;
                    ?>
                    <tr>
                      <td><?=$i++;?><br>#<?=$withdrawal->id;?></td>
                      <td><?=$withdrawal->user->DropSelfLink;?></td>
                      <td class="text-right"><?=MIS::money_format($withdrawal['amount']);?><br> - <?=MIS::money_format($withdrawal['fee']);?><hr> 
                      <?=MIS::money_format($withdrawal['AmountToPay']);?>
                      </td>
                      <td>
                        <?=$withdrawal->withdrawal_method->method;?>
                        <?=$withdrawal->withdrawal_method->MethodDetails['display'];?>
                      </td>
                      <td><?=$withdrawal->DisplayStatus;?>
                      <br>
                        <span class="badge badge-primary"><?=date("M j, Y h:ia" , strtotime($withdrawal->created_at));?></span></td>
                      <td>

                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                          </button>
                          <div class="dropdown-menu">

                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=domain;?>/withrawals/push/<?=$withdrawal->id;?>/pending','This will be marked as pending?')">
                                          <span type='span' class='label label-xs label-primary'>Pend</span>
                              </a>

                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=domain;?>/withrawals/push/<?=$withdrawal->id;?>/completed','This will be marked as completed ?')">
                                          <span type='span' class='label label-xs label-primary'>Complete</span>
                              </a>
                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=domain;?>/withrawals/push/<?=$withdrawal->id;?>/declined','This will be marked as declined?')">
                                          <span type='span' class='label label-xs label-primary'>Decline</span>
                              </a>


                           <!--    <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=domain;?>/withrawals/process/<?=$withdrawal->id;?>/livepay','This will automatically  process with Livepay.io ?')">
                                          <span type='span' class='label label-xs label-primary'>Process with LivePay</span>
                              </a> -->



                          </div>
                        </div>


                        
                      </td>
                        <td><input type="checkbox" name="records[]" class="record_selector" value="<?=$withdrawal->id;?>"></td>
                    </tr>
                  <?php endforeach ;?>

                  </tbody>
                  <input type="hidden" name="model" value="withdrawal">
                  <input type="hidden" name="action" value="" id="bulk_action">
                </form>
              </table>

            </div>

          </div>
        </section>

        <script type="text/javascript">
          process_bulk_action = function($action){
            $('#bulk_action').val($action);
            $('#bulk_action_form').submit();


          }
          

          toggle_all_records = function($all_records){
              $selectors = $('.record_selector');
              for (var i = 0; i < $selectors.length; i++) {
                  $selector = $selectors[i];
                  $selector.checked = $('#all_records')[0].checked;
              }
          }
        </script>

       
        <ul class="pagination">
            <?= $this->pagination_links($data, $per_page);?>
        </ul>

      </div>
    </div>
  </div>
  <!-- END: Content-->

  <?php include 'includes/footer.php';?>
