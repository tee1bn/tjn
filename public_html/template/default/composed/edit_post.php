 <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Edit</h4>
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

              <form method="post" action="<?=domain;?>/blog/update_post" enctype="multipart/form-data" class="ajax_form">
                <div class="form-group">
                  <input class="form-control " value="<?=$post->title;?>" name="title" placeholder="Post title" type="text" required="">
                </div>


                <div class="form-group">
                  <select class="select2_single form-control select2-hidden-accessible" name="category_id" tabindex="-1" aria-hidden="true">
                    <option>Category</option>
                      <?php foreach (Category::all() as $key): ?>
                          <option value="<?=$key->id;?>" <?=($post->category_id == $key->id) ? 'selected': '';?>>
                            <?=$key->category;?>
                          </option>
                      <?php endforeach ;?>

                  </select>
                </div>



                <div class="form-group">
                  <input type="file"  class="form-control" multiple=""  name="image_path[]" placeholder="Featured image" >
                </div>

                  <div class="row">
                  <small  style="margin-left: 15px;color: red;"> Mark pictures and click Update to delete marked images</small>
                  <?php
                  $i=0;
                    $images = $post->image_path['images'] ?? [];
                   foreach ($images as $key => $image):?> 
                                <div class="col-sm-3">
                                  <div class="property-image">
                                    <img src="<?=domain;?>/<?=$image['main_image'];?>" style="width: 100%;    border: 1px solid beige; height: 210px;" >
                                    <div class="property-image-content">
                                      <i class="fa fa-times-circle delete-image" onclick="select_this_for_delete(this)"></i>
                                      <input type="checkbox" name="images_to_be_deleted[]" value="<?=$key;?>" style="display: none;" >
                                    </div>
                                  </div>
                                </div>
                    
                  <?php $i++;  endforeach;?>
                            </div><br>

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
                  <textarea class="form-control" id="editor1" name="content" style="height: 200px;" placeholder="Content of post" required=""><?=$post->content;?></textarea>
                </div>
                <input type="hidden"  name="id" value="<?=$post->id;?>">

                <div class="col-md-4">

                  <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a onclick="$confirm_dialog=new ConfirmationDialog('<?=domain;?>/shop/submit_for_review/<?=$post->id;?>/post')" href="javascript:void(0);" class="btn btn-secondary">Submit for Review</a>
                  </div>

                </div>
                <div class="col-md-4">
                </div>
              </form>

            
          </div>
        </div>
      </section>


      <script>    

          var editor1 = CKEDITOR.replace( 'editor1', {
                height: 250,
                // Configure your file manager integration. This example uses CKFinder 3 for PHP.
                filebrowserBrowseUrl: '/uploads/media',
                filebrowserImageBrowseUrl: '/uploads/media?type=Images',
                filebrowserUploadUrl: '/media/upload/files',
                filebrowserImageUploadUrl: '/media/upload/images'
              } );

           /* tinymce.init({
              selector: '#editor1' ,
              height : "580",
              theme: "silver",
              relative_urls: false,
              remove_script_host: false,
              convert_urls: true,
              statusbar: false,
              plugins: [
                  "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                  "searchreplace wordcount visualblocks visualchars code fullscreen",
                  "insertdatetime media nonbreaking save table contextmenu directionality",
                  "emoticons template paste textcolor colorpicker textpattern responsivefilemanager"
              ],
              toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
              toolbar2: "| responsivefilemanager print preview media | forecolor backcolor emoticons",
              setup: function (editor) {
                  editor.on('change', function (e) {
                      editor.save();
                  });
              }

            });
*/
      </script>
