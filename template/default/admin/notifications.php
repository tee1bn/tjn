<?php
$page_title = "Notifications";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Notifications</h3>
          </div>
          
          <div class="content-header-right col-6">
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
                <button class="btn btn-outline-dark dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-bell icon-left"></i><?=$total ??'';?> </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <a class="dropdown-item" href="<?=domain;?>/user/notifications">See All</a>
              </div>
              </div>
              <!-- <a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a> -->
            </div>
          </div>
        </div>
        <div class="content-body">
          <style>
              .notification{

                  border: 1px solid #00000073 !important;
                  padding: 10px;
                  margin: 5px;
                  text-align: justify;
              }
          </style>

      <section id="video-gallery" class="card">
       <!--  <div class="card-header">
          <h4 class="card-title">Notifications</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div> -->
         <div class="card-content">
      <div class="card-body">
      
      <?php if(is_iterable($notifications)):?>

          <?php foreach ($notifications as $notification):?>


              <div class="timeline-panel notification">
                  <div class="timeline-heading">
                      <h4 class="timeline-title">
                          <a href="<?=domain;?>/user/notifications/<?=$notification->id;?>">
                              <?=$notification->heading;?></a>
                              
                      </h4>
                      <p>
                          <small class="text-muted"><i class="far fa-clock"></i> 
                              <?=$notification->created_at->format("M j Y - H:i A");?>
                          </small>

                          <small class="text-muted float-right">
                              <?=$notification->seen_status();?>
                          </small>
                      </p>
                  </div>
                  <div class="timeline-body">
                      <p><?=$notification->Intro;?></p>
                  </div>
              </div>


          <?php endforeach;?>

          <?php if ($notifications->isEmpty()) :?>
            <center>  Your Notifications will appear here </center>
          <?php endif  ;?>

          
      <?php else:?>


          <div class="timeline-panel notification">
              <div class="timeline-heading">
                  <h4 class="timeline-title"><?=$notifications->heading;?></h4>
                  <p>
                      <small class="text-muted"><i class="far fa-clock"></i> 
                          <?=$notifications->created_at->format("M j Y - H:i A");?>
                      </small>
                  </p>
              </div>
              <div class="timeline-body" style="overflow-x: scroll;">
                  <p><?=$notifications->message;?></p>
              </div>
          </div>

      <?php endif;?>


      </div>
    </div>
      </section>


      <?php if (isset($total)) :?>
      <ul class="pagination">
       <?= $this->pagination_links($total, $per_page);?>
     </ul>
      <?php endif  ;?>



        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
