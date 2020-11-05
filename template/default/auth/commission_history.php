<?php
$page_title = "Wallet Histroy";
include 'includes/header.php';
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Wallet History</h3>
      </div>
      <div class="content-header-right col-6">
              <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
                <a class="btn btn-outline-dark" href="Javascript:void(0);">
                      Bal: <?=$currency;?><?=MIS::money_format($balance);?>
              </a>
                <a class="btn btn-outline-dark" href="Javascript:void(0);">
                      Sub Total: <?=$currency;?><?=MIS::money_format($records->sum('amount'));?>
              </a>
          </div>
      </div>

        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">
              <?php include_once 'template/default/composed/filters/auth_wallet.php';?>
              <!-- <h4 class="card-title">Commission Wallet</h4> -->
              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">


                <?=$note;?>

              </div>
            </div>
            <div class="card-content">


              <div class="card-body table-responsive">

                <table id="myTabl" class="table table-stripe">
                  <thead>
                    <tr>

                      <th>#ID</th>
                      <th>Date</th>
                      <th>Amount(<?=$currency;?>)</th>
                      <!-- <th>Upon</th> -->
                      <th>Remark</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php foreach ($records as $record):?>
                    <tr>
                      <td><?=$record->id;?></td>
                      <td><span class="badge badge-dark"><?=date("M j, Y h:ia" , strtotime($record->created_at));?></span></td>
                      <td><?=MIS::money_format($record['amount']);?><?=$record->displayedType;?></td>
                      <!-- <td><?=$record->upon->username ?? 'NA';?></td> -->
                      <td><?=$record->comment;?></td>
                    </tr>
                  <?php endforeach ;?>
                  <?php if ($records->isEmpty()) :?>
                    <center>Your wallet history will show here</center>
                  <?php endif ;?>
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
