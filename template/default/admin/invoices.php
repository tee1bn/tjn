<?php
$page_title = "Invoices";
include 'includes/header.php';
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Invoices</h3>
      </div>

          <div class="content-header-right col-6">
            <small class="float-right">Showing <?=$packs->count();?> of <?=$data;?> </small>
<!--            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
              </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a>
            </div>
        -->
          </div> 
        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">
              <?php include_once 'template/default/composed/filters/invoices.php';?>
              <!-- <h4 class="card-title">Invoices</h4> -->
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
                      <th>#ID</th>
                      <th>User</th>
                      <th>Item Name</th>
                      <th>Description</th>
                      <th>Amount (<?=$currency;?>)</th>
                      <th>Paid Date </th>
                      <th>Download</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php foreach ($packs as $pack):
                    $detail = $pack->ExtraDetailArray;
                    ?>
                    <tr>
                      <td><?=$pack->id;?></td>
                      <td><?=$pack->user->DropSelfLink;?></td>
                      <td><?=$detail['investment']['name'];?></td>
                      <td><?=$pack['comment'];?></td>
                      <td><?=$this->money_format($detail['capital']);?></td>
                      <td><span class="badge badge-primary"><?=date("M j, Y h:ia" , strtotime($pack->created_at));?></span></td>
                      <td>
                        <div class="dropdown">
                          <a href="javascript:void;" class="dropdown-toggle btn btn-sm btn-outline-primary" data-toggle="dropdown">
                            Action
                          </a>
                          <div class="dropdown-menu">

                          <a class="dropdown-item" target="_blank" href="<?=domain;?>/user/download_invoice/<?=$pack->id;?>">Invoice</a>
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
