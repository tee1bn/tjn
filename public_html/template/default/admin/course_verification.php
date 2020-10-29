<?php
$page_title = "Course Verification";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Course Verification</h3>
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

                    
              <?php include_once 'template/default/composed/filters/market_filter.php';?>
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
                      <th>Author(Username)</th>
                      <th>Title</th>
                      <th>Date / Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>                    

                   <?php  $i=1; foreach ($posts as $market) :
                   $course = $market->good();
                   ?>
                    <tr>
                      <td><?=$market->id;?> </td>
                      <td style="text-transform:;">
                        <?=$course->instructor->dropSelfLink;?><br>
                       
                       </td>
                      <td><span class="badge badge-secondary"><?=$course->category->category ?? '';?></span><br> <?=$course->title;?></td>
                      <td><span class="badge badge-secondary"><?=date('M j, Y h:iA', strtotime($course->created_at));?></span>
                        <br/><?=$course->ApprovalStatus;?> </td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                          </button>
                          <div class="dropdown-menu">
                              <!-- <a href="<?=domain;?>/admin/courses/<?=$course->id;?>/goal" class="dropdown-item">Edit</a> -->
                              <a href="<?=$course->AdminPreviewLink;?>" class="dropdown-item" target="_blank" >Preview</a>
             
                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                  new ConfirmationDialog('<?=domain;?>/admin/toggle_course/<?=$course->id;?>')">
                                          <span type='span' class='label label-xs label-primary'>Toggle Approval</span>
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
              <?= $this->pagination_links($data, $per_page);?>
          </ul>

        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
