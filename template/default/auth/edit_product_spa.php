<?php
$page_title = "Products";
include 'includes/header.php';

$allowed_file_for_cover = ['image/*','video/*'];
;?>

<script src="<?=asset;?>/angulars/product.js" type="module"></script>


    <!-- BEGIN: Content-->
    <div class="app-content content" ng-controller="ProductController">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-6 ">
                    <?php include 'includes/breadcrumb.php';?>
                    <h6 class="content-header-title mb-0">What are you creating? {{ui}}</h6>
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
              .middle{

                height: 100px;
                /* text-align: center; */
                justify-content: center;
                align-items: center;
                border: dashed 2px #00000042;
              }

              .preview-card{
                border:none;
                height: 700px;
                width: 100%;
              }


              .file-preview-div, .file-upload, .loaded-file, .short-list {
                border: 1px solid black;
              }

              .short-list-btn{
                width: 100px !important;
                background-position: center;
              }

              .file-upload{

                text-align: center;
                padding: 20px;
              }
            </style>
            <div class="content-body row">
              <div class="col-md-7">
                <form action="<?=domain;?>/product/update_item" method="post" enctype="multipart/form-data">

                  <greet-user></greet-user>d

                  <w3-test-directive></w3-test-directive>

                  <div class="form-group">
                    <label>Name </label>
                    <input class="form-control" placeholder="Name" >
                  </div>
                  <div class="form-group">
                    <label>Description </label>
                    <div contenteditable="true" ng-model="i"  name="description"></div>
                  </div>

                  <input type="hidden" name="item_id" value="<?=$product->id;?>">



                  <div class="form-group">
                    <div class="file-preview-div" style="height: 300px;padding: 2px;">


                        <!-- <div class="media-holder" style="height: 100%; width: 100%;">
                          <img style="width: 100%; height: 100%;" 
                          src="https://image.shutterstock.com/image-photo/view-lagos-lagoon-victoria-island-260nw-1066980758.jpg" >
                        </div> -->


                        <div class="media-holder" style="height: 100%; width: 100%;">
                          <iframe width="100%" height="100%" src="https://www.youtube.com/embed/zmOGBvjQtl0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>

                        

                    </div>

                

                    <div class="loaded-file">
                      <div class="btn-group btn-group-lg">
                        <button type="button" class="btn btn-light text-white short-list-btn " 
                        style="background-image: url(https://images.unsplash.com/photo-1527342726932-1d392fcdd316?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max);"> 
                        </button>

                        <button type="button" class="btn btn-light text-white short-list-btn " 
                        style="background-image: url(https://images.unsplash.com/photo-1527342726932-1d392fcdd316?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max);"> 
                        </button>
                        
                        <button type="button" class="btn btn-light text-white short-list-btn " 
                        style="background-image: url(https://images.unsplash.com/photo-1527342726932-1d392fcdd316?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max);"> 
                        </button>

                        <div class="dropup show">
                            <button type="button" class="btn btn-primary " data-toggle="">
                              +
                            </button>
                            <div class="dropdown-menu">

                             <div class="file-upload" style="width: 30em;">
                                 <button type="button" class="btn btn-light">Upload File (Images or videos)</button>
                                 <p><small>Embed from exterenal website instead</small></p>


                                 <div class="input-group">
                                   <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                                   <div class="input-group-append">
                                     <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
                                   </div>
                                 </div>
                                   <p><small>Choose Files (Images or video)</small></p>
                             </div>
                            </div>
                          </div>

                       
                      </div>
                    
                    </div>

                  </div>




                  <div class="form-group">
                    <label>Cover <small>Image or Video</small> </label>
                    <div style="" class="centralize">
                      <input type="file" name="cover[]" accept="<?=implode($allowed_file_for_cover, ",");?>">
                      <br>

                     
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








             <!--  <div class="col-md-5">
                <div class="card">
                  <div class="card-body">
                    <iframe id="preview-iframe" src="<?=$product->PreviewLink;?>" class="preview-card"></iframe>
                  </div>
                  
                </div>
              </div> -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <script>
        

      $('li.dropdown.mega-dropdown a').on('click', function (event) {
          $(this).parent().toggleClass('open');
      });

      $('body').on('click', function (e) {
          if (!$('li.dropdown.mega-dropdown').is(e.target) 
              && $('li.dropdown.mega-dropdown').has(e.target).length === 0 
              && $('.open').has(e.target).length === 0
          ) {
              $('li.dropdown.mega-dropdown').removeClass('open');
          }
      });

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