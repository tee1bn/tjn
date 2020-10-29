<?php
$page_title = "CMS";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">CMS</h3>
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
          
          <div class="col-12">
            
            <?php foreach (CMS::Available()->get() as $key => $page):?>

                <div class="card">

                <div class="card-header collapsed" aria-expanded="false" data-toggle="collapse" data-target="#demo<?=$page->id;?>">
                  <a href="javascript:void(0);">Edit <?=$page->name;?> </a>
                </div>
                  <div class="card-body collapse" id="demo<?=$page->id;?>">
                  <form 
                    id="sub_form<?=$page->id;?>"
                    class="ajax_form"
                      action="<?=domain;?>/admin/update_cms" method="post" >
                      <div class="card-body">


                        <input type="" style="display: none;" name="criteria" value="<?=$page->criteria;?>">
                        
                          <div class="form-group">
                            <label><?=$page->name;?></label>
                            <p>
                              <small><?=$page->description;?></small>
                            </p>
                             <textarea id="editor1<?=$page->id;?>" required=""
                              name="settings" class="form-control"><?=$page->settings;?></textarea>
                          </div>

                        <button class="btn  btn-success pull-right">Save</button>


                      </div>                           



                      
                  </form>
                </div>
              </div>

<!-- 

              <script>    
                    tinymce.init({
                      selector: 'editor1<?=$page->id;?>' ,
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

              </script> -->

        <script>   
        
                  CKEDITOR.replace('editor1<?=$page->id;?>');

        </script>


        <?php endforeach;?>


          </div>

    

      
      

        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
