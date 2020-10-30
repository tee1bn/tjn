<?php
$page_title = "Products";
include 'includes/header.php';

$allowed_file_for_cover = ['image/*','video/*'];
;?>

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-6 ">
                    <?php include 'includes/breadcrumb.php';?>

                    <h6 class="content-header-title mb-0">What are you creating?</h6>
                </div>

                <div class="content-header-right col-6 mb-2">
                    <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">

                        <a class="" ><?=$product->ApprovalStatus;?></a>
                    </div>
                </div>

            </div>
            <style type="text/css">
              textarea {
                resize: vertical;
              }

              .centralize{

                height: 100px;
                /* text-align: center; */
                display: flex;
                justify-content: center;
                align-items: center;
                border: dashed 2px #00000042;
              }

              .preview-card{
                border:none;
                height: 700px;
                width: 100%;
              }
            </style>
            <div class="content-body row">
              <div class="col-md-7">
                <form action="<?=domain;?>/product/update_item" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Name </label>
                    <input class="form-control" placeholder="Name" name="name" value="<?=$product->name;?>">
                  </div>
                  <div class="form-group">
                    <label>Description </label>
                    <textarea class="form-control" contenteditable="true" onkeyup="textAreaAdjust(this)" name="description"><?=$product->description;?></textarea>
                  </div>

                  <input type="hidden" name="item_id" value="<?=$product->id;?>">

                  <div class="form-group">
                    <label>Cover <small>Image or Video</small> </label>
                    <div style="" class="centralize">
                      <input type="file" name="cover[]" accept="<?=implode($allowed_file_for_cover, ",");?>">
                     <!--  <br>
                      <small> Or add a link to cover image or video</small>
                      <input type="url" class="form-control" placeholder="http://" name="cover[]" >
                      -->
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Content </label>
                    <div style="" class="centralize">
                      <input type="file" name="content[]" >
                     <!--  <br>
                      <small>or Redirect to Url after purchase</small>
                      <input type="url" class="form-control" placeholder="http://" name="content[]" > -->
                    </div>
                    <div class="btn-group btn-group-sm">
                      <a href="<?=$product->DownloadLink;?>" target="_blank" class="btn btn-light text-white">Download File <i class="fa fa-cloud-download"></i></a>
                    </div>

                  </div>
                  
                  <!-- 
                  <pre>
                  <?php print_r($product->DownloadLink);?>
                  </pre> -->

                  <div class="form-group">
                    <label>Price </label>
                    <input class="form-control" type="number" min="5000" name="price" value="<?=$product->price;?>" placeholder="Amount">
                  </div>


                  <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">

                      <button class="btn btn-outline-dark" >Save Changes</button>
                      <a class="btn btn-outline-dark"
                       onclick="$confirm_dialog = new ConfirmationDialog('<?= domain; ?>/shop/submit_for_review/<?= $product->id; ?>')" >Publish</a>
                      <a class="btn btn-outline-dark" href="<?=$product->PreviewLink;?>">Preview</a>
                      <!-- <a class="btn btn-outline-primary" href="timeline-center.html"><i class="feather icon-pie-chart"></i></a> -->
                  </div>

                </form>

              </div>
              <div class="col-md-5">
                <div class="card">
                  <div class="card-body">
                    <iframe id="preview-iframe" src="<?=$product->PreviewLink;?>" class="preview-card"></iframe>
                  </div>
                  
                </div>
              </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <script>
        
      function publish(form) {
        form.action = "<?=domain;?>/product/update_item/1";
        form.submit();
      }
      function textAreaAdjust(element) {
        element.style.height = "1px";
        element.style.height = (25+element.scrollHeight)+"px";
      }


      function refreshIframe() {
          var ifr = $('#preview-iframe')[0];
          ifr.src = "<?=$product->PreviewLink;?>";

          console.log(ifr);
      }

    </script>

    <?php include 'includes/footer.php';?>