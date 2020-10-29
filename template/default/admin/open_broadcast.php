<?php
$page_title = "Broadcast";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Broadcast</h3>
          </div>
          
          <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                               
                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                              new ConfirmationDialog('<?=domain;?>/admin/toggle_news/<?=$broadcast->id;?>')">
                              <span type='span' class='label label-xs label-danger'>Toggle Publsh</span>
                            </a>
              </div>
              </div>
              <a class="btn btn-outline-primary" href="<?=domain;?>/admin/broadcast">Broadcasts</a>
            </div>
          </div>
        </div>
        <div class="content-body">


          <section id="create" class="card">
            <div class="card-header">
              <h4 class="card-title"><?=date("M j Y, h:ia", strtotime($broadcast->created_at));?><?=$broadcast->status();?></h4>
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
              <?php if (! $broadcast->is_live()) :?>
               <form action="<?=domain;?>/admin/create_news" method="post" >
                <div class="form-group">

                  <input type="hidden" name="id" value="<?=$broadcast->id;?>">
                  <div class="">
                    <textarea id="editor1" placeholder="Type your Message" class="form-control textarea" name="news" placeholder="" style="height: 450px"><?=$broadcast->broadcast_message;?></textarea>
                  </div>
                </div>

                <div class="">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>



              </form>
              <?php else:?>

                <?=$broadcast->broadcast_message;?>


              <?php endif;?>



            </div>
          </div>
        </section>

        <script>   


          var editor1 = CKEDITOR.replace( 'editor1', {
                // Configure your file manager integration. This example uses CKFinder 3 for PHP.
                filebrowserBrowseUrl: '<?=domain;?>/uploads/media',
                filebrowserImageBrowseUrl: '<?=domain;?>/uploads/media?type=Images',
                filebrowserUploadUrl: '<?=domain;?>/media/upload/files',
                filebrowserImageUploadUrl: '<?=domain;?>/media/upload/images'
              } );
        </script>





    <!--   <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">blank</h4>
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
