<?php
$page_title = "News";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">News</h3>
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

      <section id="create" class="card">
        <div class="card-header">
          <h4 class="card-title">News</h4>
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
    
           <form action="<?=domain;?>/admin/create_news" method="post" >
                                  <div class="form-group">
                                    
                                    <div class="">
                                      <textarea placeholder="Type your Message" class="form-control textarea" name="news" placeholder="" style="height: 150px"></textarea>
                                    </div>
                                  </div>

                                  <div class="">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                  </div>
                                </form>



     </div>
    </div>
      </section>

      <section id="create" class="card">
        <div class="card-header">
          <h4 class="card-title">News</h4>
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
                                            <th style="width: 60%;">Message</th>
                                            <th>Date</th>
                                            <th>*</th>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach (BroadCast::all() as $broadcast) :?>
                                            <tr>
                                                <td><?=$i;?></td>
                                                <td><?=$broadcast->broadcast_message;?></td>
                                                <td><a class="btn btn-sm btn-outline-primary">
                                                  <?=$broadcast->created_at->toFormattedDateString();?></a>
                                                </td>

                                                <td>

                                                  <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <a class="btn btn-sm btn-outline-primary" href="<?=domain;?>/admin/toggle_news/<?=$broadcast->id;?>">
              toggle Publish</a>

                    <a class="btn-sm btn btn-danger" href="<?=domain;?>/admin/delete_news/<?=$broadcast->id;?>">
                      <i class="fa fa-trash"></i></a>
                   <?=$broadcast->status();?>
            </div>
          </div>




                  </td>
                  


                                            </tr>
                                            <?php $i++; endforeach ;?>
                                        </tbody>
                                    </table>      </div>
    </div>
      </section>



      
      

        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
