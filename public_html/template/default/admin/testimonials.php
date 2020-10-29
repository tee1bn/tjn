<?php
$page_title = "Testimonial";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Testimonials</h3>
      </div>

      <div class="content-header-right col-6">
        <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
          <div class="btn-group" role="group">
          </div><a class="btn btn-outline-dark" href="<?=domain;?>/admin/create_testimonial"><i class="ft-plus"></i> Write</a>
          <!-- <a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a> -->
        </div>
      </div>
    </div>
    <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">
<!--           <h4 class="card-title">Testimonials</h4>
 -->
              <?php include_once 'template/default/composed/filters/testimonials.php';?>

          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
           <?=$note;?>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              
            <table id="myTabe" class="table table-hover">
              <thead>
                <th>Sn</th>
                <th>User <br> Attester</th>
                <th style="width: 60%;">Letter</th>
                <th>Video Link</th>
                <th>Type<br>Status <br> Date</th>
                <th></th>
              </thead>
              <tbody>
                <?php $i=1; foreach ($testimonials as $testimony) :?>
                <tr>
                  <td><?=$i;?></td>
                  <td>
                    <img id="myImage" style="width: 100px; height: 100px; object-fit: cover;"
                     src="<?=domain;?>/<?=$testimony->attester_pic;?>" alt="your-image" class="full_pro_pix" />
                    <br><?=$testimony->user->DropSelfLink ??'';?><hr><?=$testimony->attester;?></td>
                  <td><?=$testimony->content;?></td>
                  <td>
                    <!-- <iframe width="560" height="315" src="<?=$testimony->video_link;?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br> -->
                    <?=$testimony->video_link;?>
                  </td>

                  <td><?=$testimony->type;?><br><?=$testimony->DisplayStatus;?><br><?=$testimony->DisplayPublishedStatus;?>
                  <span class="badge badge-primary"><?=$testimony->created_at;?></span>
                      <div class="dropdown">
                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">Action
                        </button>
                        <div class="dropdown-menu">

                          <a  class="dropdown-item" href="<?=domain;?>/admin/edit-testimony/<?=$testimony->id;?>" >Edit
                          </a>
                          

                          <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                          new ConfirmationDialog('<?=domain;?>/admin/approve_testimonial/<?=$testimony->id;?>','Are you sure?')">
                          Toogle Approval
                        </a>

                          <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                          new ConfirmationDialog('<?=domain;?>/admin/publish_testimonial/<?=$testimony->id;?>','Are you sure?')">
                          Toggle Publish
                        </a>

                          <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                          new ConfirmationDialog('<?=domain;?>/admin/delete_testimonial/<?=$testimony->id;?>','Are you sure?')">
                          Delete
                        </a>


                      </div>
                    </div>


                  </td>
                </tr>
                <?php $i++; endforeach ;?>
              </tbody>
            </table>

          </div>
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
