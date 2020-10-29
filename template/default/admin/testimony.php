<?php
$page_title = "Testimonial";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Testimonial</h3>
          </div>
          
          <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
              </div><a class="btn btn-outline-primary" href="<?=domain;?>/admin/create_testimonial"><i class="ft-plus"></i> Write</a>
              <!-- <a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a> -->
            </div>
          </div>
        </div>
        <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Testimonial</h4>
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

                                    <table id="myTable" class="table table-hover">
                                        <thead>
                                            <th>Sn</th>
                                            <th>Attester</th>
                                            <th style="width: 60%;">Letter</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach (Testimonials::all() as $testimony) :?>
                                            <tr>
                                                <td><?=$i;?></td>
                                                <td><?=$testimony->attester;?></td>
                                                <td><?=$testimony->content;?></td>
                                                <td><?=$testimony->status();?></td>
                                                <td><span class="badge badge-primary">
                                                    <?=$testimony->created_at;?></span></td>
                                                <td>

                                                    <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">





                                                    <a href="<?=domain;?>/admin/edit-testimony/<?=$testimony->id;?>" class="btn btn-outline-primary btn-sm">Edit
                                                    </a>

                                                      <a href="<?=domain;?>/admin/approve_testimonial/<?=$testimony->id;?>" class="btn btn-secondary btn-sm">Toogle Approval
                                                    </a>

                                                    <a href="<?=domain;?>/admin/delete_testimonial/<?=$testimony->id;?>" class="btn btn-danger btn-sm">Delete
                                                    </a>
                                                                                                
                                                    </div>

                                            </td>
                                            </tr>
                                            <?php $i++; endforeach ;?>
                                        </tbody>
                                    </table>

      </div>
    </div>
      </section>


    <!--   <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Testimonial</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
      </section> -->


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
