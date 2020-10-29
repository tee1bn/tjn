<?php
$page_title = "Testimonial Points";
include 'includes/header.php';
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Testimonial Points</h3>
      </div>

          <div class="content-header-right col-6">

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
              <?php include_once 'template/default/composed/filters/course_sales.php';?>
              <!-- <h4 class="card-title">Your sales</h4> -->
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
                      <th>*</th>
                      <th>#ID</th>
                      <th>User</th>
                      <!-- <th>Amount(<?=$currency;?>)<br> Status</th> -->
                      <!-- <th>Course</th> -->
                      <!-- <th>Level</th> -->
                      <th>Points</th>
                      <!-- <th>Comm Status</th> -->
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php foreach ($sales as $sale):
                    ?>
                    <tr>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                          </button>
                          <div class="dropdown-menu">
                              <a  class="dropdown-item" href="<?=domain;?>/testing/test_basic_bonus/<?=$sale->id;?>">
                                    Split Commission
                              </a>
                          </div>
                        </div>


                      </td>
                      <td><?=$sale->id;?></td>
                      <td><?=$sale->user->DropSelfLink;?></td>
                      <!-- <td><?=$sale->amount;?> <?=$sale->PaymentStatus;?></td> -->
                      <!-- <td><?=$sale->maturity;?></td> -->
                      <!-- <td><?=$sale->level;?></td> -->
                      <td><?=$sale->points;?></td>
                      <!-- <td><?=$sale->displayedStatus;?></td> -->
                      
                      <td>

                        <span class="badge badge-dark"><?=date("M j, Y h:ia" , strtotime($sale->created_at));?></span><br>                      
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
