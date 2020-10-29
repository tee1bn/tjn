<?php
$page_title = "Edit Item";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Edit Item</h3>
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
              <h4 class="card-title">Edit Item</h4>
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


                                 <form method="post" enctype="multipart/form-data" class="col-md-12 ajax_form " 
                                  id="item_form"
                                  action="<?=domain;?>/admin-products/update_item">


                                  <div class="col-md-5 float-right" >
                                    <div class="property-image">
                                      <img src="<?=$item->mainimage;?>" style="width: 100%;    border: 1px solid beige; height: 210px; 
                                      object-fit: cover;">
                                      <div class="property-image-content">
                                        <i class="fa fa-times-circle delete-image" onclick="select_this_for_delete(this)"></i>
                                        <input type="checkbox" name="images_to_be_deleted[]" value="<?=$key;?>" style="display: none;" >
                                      </div>
                                    </div>


                                <!--     <hr />
                                    <div class="dropdown">
                                        <a class="btn btn-primary btn-sm" href="<?=domain;?>/admin/download_request/<?=$item->id;?>"> File Download link </a>
                                    
                                    </div>
 -->

                                  </div>
                      



                                  <div class="form-group col-md-6">
                                    <?=$this->csrf_field('update_products');?>
                                    Name
                                   <input type="" name="name" class="form-control" required="required" value="<?=$item->name;?>" placeholder="Item name" >
                                  </div>

                                   <input type="hidden" name="item_id" value="<?=$item->id;?>" >

                                <div class="form-group col-md-6">
                                  Price:
                                   <input type="" name="price" class="form-control" required="required" value="<?=$item->price;?>" placeholder="Item price">
                                 </div>

                                <div class="form-group col-md-6">
                                  Commission Price:
                                   <input type="" name="commission_price" class="form-control" required="required" value="<?=$item->commission_price;?>" placeholder="Item commission price">
                                 </div>


                <!-- 
                                <div class="form-group">
                                 Regular Price:
                                   <input type="" name="old_price" class="form-control"  value="<?=$item->old_price;?>" placeholder="Item old/regular price">
                                 </div> -->

                              <!--   <div class="form-group">
                                  Category:
                                  <select name="category" class="form-control" required="required">
                                    <option value="">select category</option>
                                    <?php foreach (ProductsCategory::all() as $category):?>
                                      <option value="<?=$category->id;?>"  <?=($item->category->id == $category->id)?'selected':'';?>>
                                        <?=$category->category;?></option>
                                    <?php endforeach ;?>
                                  </select> -->

                <!-- 
                                <div class="form-group col-md-6">
                                  Scheme:
                                  <select name="scheme" class="form-control" required="required">
                                    <option value="">Select Scheme</option>
                                    <?php foreach (SubscriptionPlan::all() as $scheme):?>
                                      <option value="<?=$scheme->id;?>"  <?=($item->scheme == $scheme->id)?'selected':'';?>>
                                        <?=$scheme->package_type;?></option>
                                    <?php endforeach ;?>
                                  </select>


                                 </div>

                 -->

                                <div class="form-group col-md-6">
                                  Cover Image:
                                   <input type="file" multiple="" name="front_image[]" class="form-control"  placeholder="Item price">
                                  </div>

                             <!--    <div class="form-group col-md-6">
                                  Downloadable File: <small class="text-danger float-right">* Preferebly .Zip</small>
                                   <input type="file"  name="downloadable_files" class="form-control"  placeholder="Item price">
                                  </div>
                 -->




                          <small  style="margin-left: 15px;color: red;"> 
                            Mark pictures and click Update to delete marked images
                          </small>
                                    <br>
                                    <br>

                          <style type="text/css">
                              .delete-image:hover{
                              color: red;
                              cursor: pointer;
                              }
                              .delete-image{
                                  position: absolute;
                                  top: 3px;
                                  right: 18px;
                                  font-size: 20px;
                                } 
                          </style>


                          <script>
                            select_this_for_delete= function ($element) {
                                $checkbox = $element.nextSibling.nextSibling;

                              if ($checkbox.checked == false) {
                                $checkbox.checked = true;
                                $element.style.color = 'red';
                              }else{
                                $checkbox.checked = false;
                                $element.style.color = 'black';

                              }

                            }
                          </script>


                                     <div class="form-group">
                                      Description
                                       <textarea id="editor1" class="form-control" name="description" rows="4" required="required"  placeholder="Item description"><?=$item->description;?></textarea>
                                      </div>


<!-- 
                                     <div class="form-group">
                                      Instruction <small class="text-danger">This will be included in the pdf download during pruchase
                                      </small><br>

                                      <small class="text-danger">
                                          
                                          [FIRSTNAME],
                                          [LASTNAME],
                                          [FULLNAME],
                                          [USERNAME]
                                          <br>

                                          use any of this place holder to personalize this instructions.
                                      </small>
                                       <textarea id="editor2" class="form-control" name="instruction" rows="6" required="required"  placeholder="Item Instruction"><?=$item->instruction;?></textarea>
                                      </div> -->


                                  <div class="form-group row">
                                   <button type="submit" class="form-control btn-primary col-md-4">
                                     Update Item
                                   </button> 



                                   <a onclick="$confirm_dialog = new ConfirmationDialog('<?= domain; ?>/shop/submit_for_review/<?= $item->id; ?>')"
                                      href="javascript:void(0);" class='col-md-4 '>
                                       <button class="form-control btn btn-secondary text-white" type="button">
                                           Put on sale
                                           <i class="fa fa-check-circle"></i>
                                       </button>
                                   </a>

                               


                                 </form>





 <script>
      CKEDITOR.replace( 'editor1' );
      CKEDITOR.replace( 'editor2' );
</script>



              </div>
            </div>
          </section>

    </div>
  </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
