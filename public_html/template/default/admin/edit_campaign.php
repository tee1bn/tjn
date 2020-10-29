<?php
$page_title = "Edit Campaign";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Edit Campaign -Email <?=$campaign->DisplayStatus;?></h3>
          </div>
          
         
         <div class="content-header-right col-md-6 col-12">
           <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
             <div class="btn-group" role="group">
             <!--   <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
               <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div> -->
             </div>
             <!-- <a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a> -->
             <a class="btn btn-outline-primary" href="<?=domain;?>/admin/all_campaigns">+ All Campaigns</a>
           </div>
         </div>
        </div>
        <div class="content-body">

      <section id="video-gallery" class="card">
        
        <div class="card-content">
          <div class="card-body">
            <form class="ajax_form" action="<?=domain;?>/campaign_crud/update_campaign" method="POST" id="campaign_form">
              <div class="row">
                <input type="hidden" name="type" required="" value="email" >
                <input type="hidden" name="id" required="" value="<?=$campaign->id;?>" >

                <div class="form-group col-md-2">
                  <label>Type</label>
                  <select class="form-control" name="category_id">
                    <option value="">Select</option>
                    <?php foreach (v2\Models\Campaign::$types as $key => $type) :?>
                      <option value="<?=$type;?>" <?=($type==$campaign->type)?'selected' :'';?>>
                        <?=$type;?>
                      </option>
                    <?php endforeach ;?>
                  </select>
                </div>
   
                <div class="form-group col-md-10">
                  <label>Category</label>
                  <select class="form-control" name="category_id">
                    <option value="">Select Type</option>
                    <?php foreach (CampaignCategory::Active()->get() as $key => $category) :?>
                      <option value="<?=$category->id;?>" <?=($category->id==$campaign->category_id)?'selected' :'';?>>
                        <?=$category->title;?> -<?=$category->rows();?>
                      </option>
                    <?php endforeach ;?>
                  </select>
                </div>

                <div class="form-group col-md-6">
                  <label>Recipients</label>
                  <textarea class="form-control" name="recipients" rows=""><?=$campaign->recipients;?></textarea>
                </div>

                <div class="form-group col-md-6">
                  <label>Test Recipients</label>
                  <textarea class="form-control" name="test_recipients" rows=""><?=$campaign->test_recipients;?></textarea>
                </div>

                <div class="form-group col-md-12">
                  <label>Subject</label>
                  <input class="form-control" id="subject" name="subject" required="" value="<?=$campaign->subject;?>">
                </div>



                <div class="form-group col-md-12">
                  <label>Message</label>
                  <textarea  id="content" class="form-control editor1" name="message" required="" rows=""><?=$campaign->message;?></textarea>
                </div>

                <?php

                  $publish = Config::domain()."/campaign_crud/update_campaign/publish";
                  $send_test = Config::domain()."/campaign_crud/update_campaign/send_test";

                ;?>
                <div class="form-group col-md-12">
                  <div class="btn-group">
                    <button type="submit" id="submit_btn" class="btn btn-outline-primary">Save</button>
                    <button type="button" 
                      onclick="$confirm_dialog= new DialogJS(submit_campaign, ['<?=$publish;?>'],'Are you sure you want to publish?');" 
                      class="btn btn-outline-primary">Publish</button>

                    <button type="button" 
                      onclick="$confirm_dialog= new DialogJS(submit_campaign, ['<?=$send_test;?>'],'Are you sure you want to send test?');" 
                      class="btn btn-outline-primary">Send test</button>
                      
                  </div>

                </div>

              </div>
              
            </form>
  
            <script>
                

                    tinymce.init({
                      selector: '.editor1' ,
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


              submit_campaign =  function($data){
                $form = $('#campaign_form');
                $form.attr('action', $data); 
                $('#submit_btn').click();
              }
              
            </script>
              
          </div>
        </div>
      </section>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
