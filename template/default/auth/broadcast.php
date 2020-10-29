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

      <section id="video-gallery" class="card">
        <div class="card-header">
          <p class="card-text">List of News - <?=$news->count();?> of  <?=$data;?> </p>

        
        </div>
         <div class="card-content">
      <div class="card-body">
          <table id="myTable" class="table table-hover">
              <tbody>
                  <?php $i=1; foreach ($news as $broadcast) :?>


                  <tr>

                    <div class="alert bg-dark text-white  alert-dismissible mb-2 " role="alert">             
                          <small class="badge badge-secondary"><?=$i;?></small>
                           <span class="badge badge-secondary">
                                  <?=date('M j, Y h:iA', strtotime($broadcast->created_at));?>
                              </span>
                          <p>
                             <small>
                              <?=$broadcast->broadcast_message;?>
                             </small>
                          </p>

                    </div>
                  </tr>
                  <?php $i++; endforeach ;?>
                  <?php if ($news->isEmpty()) :?>
                    <center>No records Found</center>
                  <?php endif  ;?>

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
