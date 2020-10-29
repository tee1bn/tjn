<?php
$page_title = "Investment Purchases";
include 'includes/header.php';
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Investment Purchases</h3>
      </div>

          <div class="content-header-right col-6">
            <small class="float-right">Showing <?=$packs->count();?> of <?=$data;?> </small>

<!--             <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
              </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a>
            </div>
 -->          </div>
        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">
              <?php include_once 'template/default/composed/filters/wallet.php';?>
              <!-- <h4 class="card-title">Your Packs</h4> -->
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

                <table id="myTabl" class="table table-striped">
                  <thead>
                    <tr>
                      <th>*</th>
                      <th>#ID</th>
                      <th>User</th>
                      <th>Name</th>
                      <th>Invested(<?=$currency;?>)</th>
                      <th>Returned(<?=$currency;?>)</th>
                      <th>Target (<?=$currency;?>)</th>
                      <th>Maturity</th>
                      <th>Status</th>
                      <th>Purchase Date <br>Last Paid Date</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php foreach ($packs as $pack):
                    $detail = $pack->ExtraDetailArray;
                    ?>
                    <tr>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                          </button>
                          <div class="dropdown-menu">
                          <?php if (! $pack->is_completed()) :?>
                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=$pack->PauseUrl;?>')">
                                    <span type='span' class='label label-xs label-primary'>Pause/Resume</span>
                              </a>
                          <?php endif ;?>
                          </div>
                        </div>


                      </td>
                      <td><?=$pack->id;?></td>
                      <td><?=$pack->user->DropSelfLink;?></td>
                      <td><?=$detail['investment']['name'];?></td>
                      <td><?=MIS::money_format($detail['capital']);?></td>
                      <td><?=MIS::money_format($pack['Returns']);?></td>
                      <td><?=MIS::money_format($detail['total_worth']);?></td>
                      <td><?=$pack->maturity;?>%</td>
                      <td>
                        <?=$pack->roiStatus;?>
                        <?=$pack->PlayStatus;?>
                      </td>
                      <td>

                        <span class="badge badge-dark"><?=date("M j, Y h:ia" , strtotime($pack->paid_at));?></span><br>


                        <span class="badge badge-primary"><?=date("M j, Y h:ia" , strtotime($pack->updated_at));?></span></td>
                      
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
