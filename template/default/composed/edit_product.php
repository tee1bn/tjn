
<script>
  var $product_id = <?=$product->id;?>;
</script>
<script src="<?=asset;?>/angulars/product.js" type="module"></script>


<!-- BEGIN: Content-->
<div class="app-content content" id="content" ng-controller="ProductController" ng-cloak>
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 ">
        <h6 class="content-header-title mb-0">What are you creating? {{ui}}</h6>
      </div>

      <div class="content-header-right col-6 mb-2">
        <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">

          <a class="" ><?=$product->ApprovalStatus;?></a>
        </div>
      </div>

    </div>
    <style type="text/css">
      .truncate {
        width: 450px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }

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
        /*border: 1px solid black;*/
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

        border: 2px dashed #0000002e;
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
      <div class="col-md-8">
        <form action="<?=domain;?>/product/update_product" id="nform" method="post" enctype="multipart/form-data">

          <div class="form-group">
            <label>Name </label>
            <input class="form-control" placeholder="Name" ng-model="$product_form.$product.name">
          </div>
          <div class="form-group">
            <label>Description </label>
            <textarea class="textarea" contenteditable="true" ng-model="$product_form.$product.description" rows="4" ck-editor></textarea>
          </div>

          <input type="hidden" name="item_id" value="<?=$product->id;?>">



          <div class="form-group">
            <label>Cover</label>
            <div class="file-preview-div" style="height: 300px;padding: 2px; display: none;">

                      <!-- <div class="media-holder" style="height: 100%; width: 100%;">
                        <img style="width: 100%; height: 100%;" 
                        src="https://image.shutterstock.com/image-photo/view-lagos-lagoon-victoria-island-260nw-1066980758.jpg" >
                      </div> -->


                    <!--   <div class="media-holder" style="height: 100%; width: 100%;">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/zmOGBvjQtl0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                      </div>
                    -->


                    </div>



                    <div class="loaded-file">
                      <div class="row" style="margin-left: 0px;">
                        <div class="col-md-2 thumbnail-div" ng-repeat="(key, $thumbnail) in $product_form.$product.cover">
                          <span ng-click="$product_form.deleteCover($thumbnail)" class="fa fa-times text-danger cancel-thumbnail"></span>

                          <div ng-if="$thumbnail.file_type=='video'"  width="100%" height="100%" class="image-thumbnail" src="{{$thumbnail.file_path}}">
                            <center>Video</center>
                          </div>
                          <img ng-if="$thumbnail.file_type=='image'" src="{{$thumbnail.file_path}}" width="100%" height="100%" class="image-thumbnail">
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
                            ng-model="$product_form.cover_pad.file" accept="image/*,video/*" 
                             id="cover_upload_element" style="display: none;">


                             <p>
                              <small ng-click="$product_form.setCoverPadSrc('external')">
                                <a href="javascript:void(0);">Embed from exterenal website instead</a>
                              </small>
                            </p>
                          </span>

                          <span ng-show="$product_form.cover_pad.src=='external'" >
                           <div class="input-group">
                             <input type="text" class="form-control" ng-model="$product_form.cover_pad.embed_link" 
                             placeholder="http://" aria-describedby="button-addon3">
                             <div class="input-group-append">
                               <button class="btn btn-dark" ng-click="$product_form.loadEmbedLink()"
                                type="button" id="button-addon3"><i class="fa fa-check"></i></button>
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

              <div ng-hide="$product_form.file_pad.src=='external'" >
                
              <label ng-hide="$product_form.$product.content.length>0"><small>Files</small> 
                <a target="_blank" 
                  href="{{$product_form.$product.extra_details.after_purchase_link}}">{{$product_form.$product.extra_details.after_purchase_link}}</a>
              </label>

              <label ng-show="$product_form.$product.content.length"><small>Files</small> </label>
              <div class="list-group">
                <span ng-repeat="(key, $content) in $product_form.$product.content">
                <div  class="list-group-item" >
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="truncate"><span class="badge badge-light">{{$content.extension}}</span> {{$content.name}}</h5>
                    <small>
                      <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                        <a href="{{$content.file_path}}" target="_blank" type="button" class="btn btn-light text-white">
                          Open <i class="fa fa-link"></i>
                        </a>

                        <!-- <button ng-show="$content.detail_pad" ng-click="$content.toggleDetailPad()" type="button" class="btn btn-light text-white">
                          <i class="fa fa-check"></i>
                        </button>
                        <button ng-hide="$content.detail_pad" ng-click="$content.toggleDetailPad()" type="button" class="btn btn-light text-white">
                          <i class="fa fa-pencil"></i>
                        </button>
              -->

                        <button ng-click="$product_form.deleteFile($content)" type="button" class="btn btn-light text-white"><i class="fa fa-trash"></i></button>
                      </div>
                    </small>
                  </div>
                  <small class="file-size">{{$content.filesize}}</small>
                </div>
                <div class="files-details" ng-show="$content.detail_pad">
                  <div class="form-group">
                    <label>Name</label>
                    <input type="" class="form-control" ng-model="$content.name" >
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="" class="form-control" ng-model="$content.file.description" >
                  </div>
                </div>
                </span>

              </div>
              </div>

            </div>


            <div class="form-group" ng-hide="$product_form.hideContentPad();">
              <label>Content <small></small> </label>
              <div class="file-upload">
                <span ng-show="$product_form.file_pad.src=='local'" >

                <button type="button" onclick="$('#file_upload_element').click();"
                 class="btn btn-outline-dark">Upload Files </button>
                <input type="file" onchange="angular.element(this).scope().$product_form.processFilePad(this);" 
                ng-model="$product_form.cover_pad.file"
                 id="file_upload_element" style="display: none;">





                 <p>
                  <small ng-click="$product_form.setFilePadSrc('external')">
                    <a href="javascript:void(0);">Redirect to a URL after purchase</a>
                  </small>
                </p>
                </span>

                <span ng-show="$product_form.file_pad.src=='external'" >
                <div class="input-group">
                  <input type="text" class="form-control" ng-change="$product_form.afterPurchaseLink();" 
                  ng-model="$product_form.$product.extra_details.after_purchase_link" placeholder="http://" aria-describedby="button-addon2">
                  <div class="input-group-append">
                    </button>
                    <button ng-click="$product_form.loadDeliveryLink()" class="btn btn-outline-secondary" type="button" id="button-addon2">
                      <span ng-hide="$product_form.$product.extra_details.after_purchase_link_validity">Test</span>
                      <i ng-show="$product_form.$product.extra_details.after_purchase_link_validity" class="fa fa-check"></i>
                    </button>
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

           <!--  <label>Allow Customers pay what they want 
              <input type="checkbox" ng-model="$product_form.$product.extra_details.customer_sets_price">
            </label> -->
            <div class="row">
              <div class="form-group col-6" ng-hide="$product_form.$product.extra_details.customer_sets_price">
                <label>Price </label>
                <input class="form-control" type="number" min="0" max="100000" ng-model="$product_form.$product.price"  placeholder="Amount">
              </div>

              <div class="form-group col-6" >
                <label>Affililate Commission (%) </label>
                <input class="form-control" step="5" type="number" min="0" max="90" ng-model="$product_form.$product.extra_details.affiliate_commission" 
                 placeholder="% commission">
              </div>
            </div>

            <!-- <div class="form-group">
              <label>Category </label>
              <select  class="form-control custom-select" 
              ng-init="$product_form.$product.category_id"
              ng-model="$product_form.$product.category_id"
               ng-options="$category.id as $category.category for $category in categories">
              </select>
            </div> -->

            <div class="form-group">
              <label>Category </label>
              <select  class="form-control custom-select" ng-model="$product_form.$product.category_id">
               <option ng-selected="$product_form.$product.category_id == $category.id" ng-repeat="(key, $category) in categories" value="{{$category.id}}"> {{$category.category}}</option>
              </select>
            </div>


            <div class="col-md-12 row" ng-show="$product_form.$product.extra_details.customer_sets_price">
              <div class="form-group col-6">
                  <label>Minimum amount</label>
                  <input class="form-control" type="number" min="0" ng-model="$product_form.$product.extra_details.pricing.minimum"  placeholder="Min ">
              </div>
              <div class="form-group col-6">
                  <label>Suggested amount</label>
                  <input class="form-control" type="number" min="1" ng-model="$product_form.$product.extra_details.pricing.suggested"  placeholder="Max">
              </div>
            </div>



            <div class="form-group">
             <label>Thank you note</label>
             <textarea class="form-control" rows="4" placeholder="Optional" ng-model="$product_form.$product.extra_details.thank_you_note"></textarea>
           </div>



           <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">

            <a class="btn btn-outline-dark" type="a" ng-click="$product_form.save();" >Save Changes</a>
            <?php if ($product->allow_edit()) :?>
            <a class="btn btn-outline-dark"
            onclick="$confirm_dialog = new ConfirmationDialog('<?= domain; ?>/shop/submit_for_review/<?= $product->id; ?>')" >Publish</a>

            <?php else:?>


            <?php endif ;?>

            <?php if (isset($user_type)&& ($user_type=='admin')) :?>

                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                  Review
                </button>

            

            <?php endif ;?>
            <a class="btn btn-outline-dark" target="_blank" href="<?=$product->PreviewLink;?>">Preview</a>
          </div>

        </form>

      </div>






      <!-- The Modal -->
      <div class="modal" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Review</h4>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

              <form class="ajax_form" action="<?=domain;?>/review/push_to_state/product" method="post">

                <div class="form-group">
                  <textarea rows="5" class="form-control" placeholder="Admin Comment" required="" name="comment"></textarea>
                  <input type="hidden" name="product_id" value="<?=$product->id;?>">
                </div>

                <div class="form-group">
                  <select class="form-control" name="status" required="">
                    <option value="">Select</option>
                    <?php foreach(Products::$statuses as $key => $value) :?>
                      <option value="<?=$key;?>"> <?=$value;?></option>
                    <?php endforeach ; ?>
                  </select>                                   

                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-dark">Submit</button>
                </div>

              </form>

            </div>

            <!-- Modal footer -->
           <!--  <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div> -->

          </div>
        </div>
      </div>




              <div class="col-md-4">
                <div class="card">

                        <div class="admin_comment col-md-12" style="height: 182px;overflow-y: scroll;">

                          <table class="table table-striped table-sm">


                            <?php
                            foreach ($product->adminComments() as $key => $comment):?>
                              <tr>
                                <td><?=$comment->comment;?>
                                <br>
                                <small><i>
                                  <?=$comment->admin->fullname;?> 
                                  <?=Products::get_status($comment->status);?>
                                  <?=date("M j, Y h:iA", strtotime($comment->created_at));?> 
                                </i>
                              </small> 
                            </td>
                          </tr>
                        <?php endforeach;?>
                      </table>


                    </div>

                    <!-- <iframe id="preview-iframe" src="<?=$product->PreviewLink;?>" class="preview-card"></iframe> -->
                  
                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- END: Content-->

        <script>

          function publish(form) {
            form.action = "<?=domain;?>/product/update_product/1";
            form.submit();
          }
        

        </script>