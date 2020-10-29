<?php
$page_title = "$page_title";
include 'includes/header.php';
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0"><?=$page_title;?></h3>
      </div>
              <div class="content-header-right col-6 ">
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
              </div>
              <!-- <a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a> -->
            </div>
          </div>

        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">
              <?php include_once 'template/default/composed/filters/wallet.php';?>
              <!-- <h4 class="card-title">Deposits</h4> -->
              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <?=$note;?>
              </div>
            </div>
            <div class="card-content">


              <div class="card-body table-responsive">

                <table id="myTabl" class="table table-striped">
                  <thead>
                    <tr>

                      <th>#ID</th>
                      <th> Date <br> Clearance</th>
                      <th>User</th>
                      <th>Upon</th>
                      <th>Amount(<?=$currency;?>)</th>
                      <th>Status</th>
                      <th>Comment</th>
                      <!-- <th>Action</th> -->
                    </tr>
                  </thead>
                  <tbody>
                   <?php foreach ($records as $record):?>
                    <tr>
                      <td><?=$record->id;?></td>
                      <td> 

                       <span class="badge badge-primary"><?=date("M j, Y h:ia" , strtotime($record->created_at));?></span>
                        <br><span class="badge badge-secondary"><?=($record->paid_at != null) ? date("M j, Y h:ia" , strtotime($record->paid_at) ): 'cleared';?></span>
                      </td>
                      <td><?=$record->user->DropSelfLink;?></td>
                      <td><?=$record->upon->DropSelfLink ?? 'N/A';?></td>
                      <td><?=MIS::money_format($record['amount']);?> <?=$record->displayedType;?></td>
                      <td><?=($record['displayedStatus']);?></td>
                      <td><?=$record->comment;?></td>
                      <td style="display: none;">

                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                          </button>
                          <div class="dropdown-menu">

                            <?php if ($record->getOrderId != false) :?>
                              <a  class="dropdown-item" target="_blank" href="<?=$record->order();?>" >
                                Go to Sale
                              </a>
                            <?php endif ;?>


                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=domain;?>/deposits/push/<?=$record->id;?>/pending/<?=$wallet;?>','This will be marked as pending?')">
                                          <span type='span' class='label label-xs label-primary'>Pend</span>
                              </a>

                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=domain;?>/deposits/push/<?=$record->id;?>/completed/<?=$wallet;?>','This will be marked as completed ?')">
                                          <span type='span' class='label label-xs label-primary'>Complete</span>
                              </a>
                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=domain;?>/deposits/push/<?=$record->id;?>/cancelled/<?=$wallet;?>','This will be marked as cancelled?')">
                                          <span type='span' class='label label-xs label-primary'>Cancel</span>
                              </a>


                          </div>
                        </div>


                        
                      </td>

                    </tr>
                  <?php endforeach ;?>

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

  <?php include 'includes/footer.php';?>
