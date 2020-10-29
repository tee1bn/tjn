<?php
$page_title = "Testimonial";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Testimonial</h3>
      </div>

      <div class="content-header-right col-6">
        <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
          <div class="btn-group" role="group">
          </div>
          <a class="btn btn-outline-dark" href="<?=domain;?>/admin/create_testimonial"><i class="ft-plus"></i> Add</a>
           <a href="javascript:void;" class="btn btn-outline-dark"  onclick="document.getElementById('payment_proof_input<?= $testimony->id;?>').click()" >
              Upload Pic
          </a>

          <a class="btn btn-outline-dark" href="<?=domain;?>/admin/testimonials"> All Testimonials</a>
        </div>
      </div>
    </div>
    <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Testimonial <?=$testimony->DisplayStatus;?></h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
              <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
          </div>
        </div>


        <style>
          .full_pro_pix{
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 100%;
            border: 1px solid #cc444433;
          }
        </style>

        <div class="card-content">
          <div class="card-body">
            <div class="row">

            <div class="col-md-3">
                <div class="user-profile-image" align="center" style="">
                  <img id="myImage" src="<?=domain;?>/<?=$testimony->attester_pic;?>" alt="your-image" class="full_pro_pix" />
                  <h4><?=ucfirst($testimony->attester);?></h4>
                </div>

            </div>

            <div class="col-md-9">
            <form
            id="testimony_edit"
            class="ajax_form"
            action="<?=domain;?>/admin/update_testimonial" method="post" >
            <input type="hidden" name="testimony_id" value="<?=$testimony->id;?>">



            <div class="form-group">
              <input required="" class="form-control textarea" value="<?=$testimony->attester;?>" name="attester" placeholder="Enter Attester Name">
            </div>


            <div class="form-group">
              <input required="" maxlength="250" class="form-control textarea" value="<?=$testimony->bio;?>" name="bio" placeholder="Enter Bio">
            </div>


            <div class="form-group">

              <select name="type" class="form-control">
                <option value="">Select Type</option>
                <?php foreach (['written','video'] as $key => $value):?>
                    <option <?=(($testimony['type']==$value)) ?'selected':'';?> value="<?=$value;?>"> 
                        <?=$value;?>
                    </option>
                <?php endforeach ;?>

              </select>

            </div>



            <div class="form-group">
              <input type="url" class="form-control" name="video_link" placeholder="Enter video Link e.g https://www.youtube.com/watch?v=xxxx" value="<?=$testimony->video_link;?>">
            </div>



            <div class="form-group">
              <div class="">
                <textarea placeholder="Write your tesimonial" class="form-control textarea" name="testimony" placeholder="" style="height: 150px"><?=$testimony->content;?></textarea>
              </div>
            </div>

            <div class="">
              <button type="submit" class="btn btn-success">Save</button>
            </div>
          </form>

          <form id="payment_proof_form<?=$testimony->id;?>" action="<?=domain;?>/admin/upload_testimonial_pic/<?=$testimony->id;?>/product" method="post" enctype="multipart/form-data">
              <input 
              style="display: none" 
              type="file" 
              onchange="document.getElementById('payment_proof_form<?=$testimony->id;?>').submit();" id="payment_proof_input<?=$testimony->id;?>"  
              name="payment_proof">

              <input type="hidden" name="order_id" value="<?=$testimony->id;?>">
          </form>

        </div>

        </div>
      </div>
    </section>




  </div>
</div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
