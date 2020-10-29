<?php
$page_title = "Documents";
 include 'includes/header.php';?>
    <script src="<?=asset;?>/angulars/admin_documents.js"></script>

    <!-- BEGIN: Content-->
    <div ng-controller="CompanyController" class="app-content content" ng-cloak>
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Documents</h3>
          </div>
          
          <div class="content-header-right col-md-6 col-12">

            <?php if($show != false) :?>

            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <a class="btn btn-outline-primary" href="javascript:void(0);" 
              data-toggle="modal"
               data-target="#upload_company_supporting_document" >+<i class="ft-file"></i>Upload</a>
            
            </div>
            <?php endif ;?>


          </div>
        </div>
        <div class="content-body">


          <script>
              refresh_page = function(){
                  angular.element($('#document_form')).scope().fetch_page_content();
              }
          </script>


                                  <!-- The Modal -->
<div class="modal" id="upload_company_supporting_document">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Documents </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

      </div>



      <!-- Modal body -->
        <form id="document_form" data-function="refresh_page"  class="col-md-12 ajax_form" enctype="multipart/form-data" 
        action="<?=domain;?>/admin/upload_supporting_document" method="post" >  
          <div class="modal-body">
            <style>
              td{padding:0px !important;}
            </style>



                              <button type="button" class="btn btn-secondary float-right btn-sm" 
                              ng-click="$list.add_component();">+Add Document</button>
                                <br>
                                <!-- <i class="card-text"> *All documents will be verified.</i> -->
                                <br>
                                   <table class="table table-hover table-condensed">

                                      <thead>
                                        <tr>
                                          <th>Label</th>
                                          <th>Files</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr ng-repeat="(key, $hospital) in $list.$active_list">
                                         <td>
                                            <input 
                                                placeholder="Name" required="" 
                                               class="form-control" type=""  
                                                name="label[]"></td>

                                          <td>

                                                <div
                                                 class="input-group col-md-12">
                                                     
                                            <input 
                                                placeholder="Name" required="" 
                                               class="form-control" type="file" 
                                                name="files[]">                                        
                                                      <span class="input-group-btn">
                                                        <button ng-click="$list.delete_component($hospital);"
                                                         class="btn btn-default" type="button">
                                                            <span class="fa fa-times text-danger"></span>
                                                        </button>
                                                      </span>
                                                </div>  

                                            </td>
                                        </tr>
                                      </tbody>
                                    </table>

          <!-- Modal footer -->
          <div class="modal-footer">
                    <button ng-hide="$list.$active_list.length==0" type="submit" class="btn btn-success" >Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

          </div>
        </form>  

    </div>
  </div>
</div>
        

      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Documents</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
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

                                    <div class="card-body row">
                                <div class="col-md-12" style="
                                                        margin-bottom: 20px;
                                                        border: 1px solid #14181f42;
                                                        padding: 19px;">


                                    <div class="col-md-12">
                                      <div class="card" style="height: 508px;">
                                        <div class="card-content">
                                          <div class="card-body">
                                            <h4 cla5s="card-title">Documents 

                                           
                                            </h4>
                                          </div>                                          

                                          <ul class="list-group list-group-flush">
                                            <li ng-repeat="(key, $doc) in $list.$lists" class="list-group-item" style="text-transform: capitalize;">
                                              <span class="label label-primary float-left">{{$index + 1}})</span> &nbsp;

                                              <?php if($show != false) :?>
                                              <a href="javascript:void(0);" ng-click="$list.attempt_delete($doc, key);" class="fa fa-trash  
                                                text-danger float-right" style="font-size: 20px;">
                                                <i class=""></i>
                                              </a>
                                              <?php endif;?>

                                              <a target="_blank" href="<?=domain;?>/{{$doc.files}}"><b>{{$doc.label}}</b></a>
                                            </li>
                                          
                                          </ul>
                                         <!--  <div class="card-body">
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#upload_company_supporting_document" 
                                                    title="Upload supporting company documents" class="card-link">Upload Documents</a>
                                          </div> -->
                                        </div>
                                      </div>
                                    </div>
                                
                                        <hr>


                                </div>
          
      </div>
    </div>
      </section>



        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
