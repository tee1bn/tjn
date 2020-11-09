<?php
$page_title = "Products";
include 'includes/header.php';

$allowed_file_for_cover = ['image/*','video/*'];
;?>

<script src="<?=asset;?>/angulars/product.js" type="module"></script>


<!-- BEGIN: Content-->
<div class="app-content content" id="content" ng-controller="ProductController">
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

      .thumbnail-div{
          padding: 0;
          padding-right: 2px;
          height: 40px;
      }

      .thumbnail{
        background-size: cover;
        background-repeat: no-repeat;
      }

      .centralize{

        height: 100px;
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

      .cover-upload{

        text-align: center;
        padding: 20px;
      }

      .file-upload{

        text-align: center;
        padding: 20px;
      }

      .files-details{

        background: #d7d7d7;
        padding: 10px;
      }

      .file-size{

        position: absolute;
        left: 63px;
        top: 39px;
      }

      .textarea{

        min-height: 150px;
        border: 1px solid #0000002b;
        position: relative;
        padding: 5px;
      }

      .image-thumbnail{
        object-fit: cover;
      }

      .cancel-thumbnail{

        position: absolute;
        right: 5px;
        background: white;
        border-radius: 66%;
        padding: 2px;
        cursor: pointer;
      }
    </style>

    <div class="content-body row">
      <div class="col-md-7">
        <form action="<?=domain;?>/product/update_item" method="post" enctype="multipart/form-data">

          {{$product_form}}
          <w3-test-directive></w3-test-directive>

<!--           <div class="form-group">
            <label>Name </label>
            <input class="form-control" placeholder="Name" ng-model="$product_form.$product.name">
          </div>
          <div class="form-group">
            <label>Description </label>
            <div class="textarea" contenteditable="true" ng-model="$product_form.$product.description" ck-editor  name="description"></div>
          </div>

          <input type="hidden" name="item_id" value="<?=$product->id;?>">
 -->


          <div class="form-group">
            <div class="file-preview-div" style="height: 300px;padding: 2px; display: none;">

                      <!-- <div class="media-holder" style="height: 100%; width: 100%;">
                        <img style="width: 100%; height: 100%;" 
                        src="https://image.shutterstock.com/image-photo/view-lagos-lagoon-victoria-island-260nw-1066980758.jpg" >
                      </div> -->


                      <div class="media-holder" style="height: 100%; width: 100%;">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/zmOGBvjQtl0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                      </div>



                    </div>



                    <div class="loaded-file">
                      <div class="row" style="margin-left: 0px;">
                        <div class="col-md-2 thumbnail-div" ng-repeat="(key, $thumbnail) in $product_form.$product.cover">
                          <span class="fa fa-times text-danger cancel-thumbnail"></span>

                          <div ng-if="$thumbnail.type=='video'"  width="100%" height="100%" class="image-thumbnail" src="{{$thumbnail.file_path}}">
                            <center>Video</center>
                          </div>
                          <img ng-if="$thumbnail.type=='image'" src="{{$thumbnail.file_path}}" width="100%" height="100%" class="image-thumbnail">
                        </div> 

                      <div class="btn-group btn-group-lg">

                      <div class="dropup {{$product_form.cover_pad.show}}">
                        <button ng-click="$product_form.toggleCoverPad()" type="button" class="btn btn-light text-white " data-toggle="">
                          <i class="fa fa-plus" ng-show="$product_form.cover_pad.show==''"></i>
                          <i class="fa fa-times" ng-hide="$product_form.cover_pad.show==''"></i>
                        </button>
                        <div class="dropdown-menu">
                         <div class="cover-upload" style="width: 30em;">

                          <span ng-show="$product_form.cover_pad.src=='local'" >
                            <button type="button" onclick="$('#cover_upload_element').click();"
                             class="btn btn-outline-dark">Upload File (Images or videos)</button>
                            <input type="file" onchange="angular.element(this).scope().$product_form.processCoverPad(this);" 
                            ng-model="$product_form.cover_pad.file"
                             id="cover_upload_element" style="display: none;">


                             <p>
                              <small ng-click="$product_form.setCoverPadSrc('external')">
                                <a href="javascript:void(0);">Embed from exterenal website instead</a>
                              </small>
                            </p>
                          </span>


                          <span ng-show="$product_form.cover_pad.src=='external'" >
                           <div class="input-group">
                             <input type="url" class="form-control" ng-model="$product_form.cover_pad.embed_link" 
                             placeholder="http://" aria-describedby="button-addon2">
                             <div class="input-group-append">
                               <button class="btn btn-dark" ng-click="$product_form.loadEmbedLink()"
                                type="button" id="button-addon2"><i class="fa fa-check"></i></button>
                             </div>
                           </div>
                            <p>
                             <small ng-click="$product_form.setCoverPadSrc('local')">
                               <a href="javascript:void(0);">Choose Files (Images or video)</a>
                             </small>
                           </p>
                         </span>
                       </div>
                     </div>
                   </div>


                 </div>
                      </div>

               </div>

             </div>


             <div class="form-group">
              <label>Files <small>Image or Video</small> </label>
              <div class="list-group">
                <span ng-repeat="(key, $content) in $product_form.$product.content">
                  
                <div  class="list-group-item" >
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class=""><span class="badge badge-light">PDF</span> List group item heading</h5>
                    <small>
                      <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-light text-white"><i class="fa fa-check"></i></button>
                        <button type="button" class="btn btn-light text-white"><i class="fa fa-pencil"></i></button>
                        <button type="button" class="btn btn-light text-white"><i class="fa fa-trash"></i></button>
                      </div>
                    </small>
                  </div>
                  <small class="file-size">800kb.</small>
                </div>
                <div class="files-details">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="" class="form-control" name="">
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="" class="form-control" name="">
                  </div>
                </div>
                </span>

              </div>

            </div>


            <div class="form-group">
              <label>Cover <small>Image or Video</small> </label>


              <div class="file-upload" style="width: 30em;">
                <span ng-show="$product_form.file_pad.src=='local'" >
                <button type="button" class="btn btn-light">Upload your Files</button>
                 <p>
                  <small ng-click="$product_form.setFilePadSrc('external')">
                    <a href="javascript:void(0);">Redirect to a URL after purchase</a>
                  </small>
                </p>
                </span>

                <span ng-show="$product_form.file_pad.src=='external'" >
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
                  </div>
                </div>                
                 <p>
                  <small ng-click="$product_form.setFilePadSrc('local')">
                    <a href="javascript:void(0);">Deliver content through <?=project_name;?></a>
                  </small>
                </p>
              </span>

              </div>


            </div>

            <div class="form-group">
              <label>Price </label>
              <input class="form-control" type="number" min="5000" ng-model="$product_form.$product.price"  placeholder="Amount">
            </div>



            <div class="form-group">
             <label>Thank you note</label>
             <textarea class="form-control" rows="4" ng-model="$product_form.$product.thank_you_note"></textarea>
           </div>



           <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">

            <button class="btn btn-outline-dark" >Save Changes</button>
            <a class="btn btn-outline-dark"
            onclick="$confirm_dialog = new ConfirmationDialog('<?= domain; ?>/shop/submit_for_review/<?= $product->id; ?>')" >Publish</a>
            <a class="btn btn-outline-dark" href="<?=$product->PreviewLink;?>">Preview</a>
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