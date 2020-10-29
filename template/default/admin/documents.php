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

      <datalist id="category_list">
        <?php foreach ($documents_categories as $key => $category) :?>
        <option><?=$category;?></option>
        <?php endforeach ;?>
      </datalist>

      <!-- Modal body -->
        <form id="document_form" data-function="refresh_page"  class="col-md-12 ajax_for" enctype="multipart/form-data" 
        action="<?=domain;?>/admin/upload_supporting_document" method="post" >  
          <div class="modal-body">
            <style>
              .no_padding{padding:0px !important;}
            </style>



                              <button type="button" class="btn btn-secondary float-right btn-sm" 
                              ng-click="$list.add_component();">+Add Document</button>
                                <br>
                                <!-- <i class="card-text"> *All documents will be verified.</i> -->
                                <br>
                                   <table id="document_form_table" class="table table-hover table-condensed">

                                      <thead>
                                        <tr>
                                          <th>Label</th>
                                          <th>Category</th>
                                          <th>Files</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr ng-repeat="(key, $hospital) in $list.$active_list">
                                         <td class="no_padding">
                                            <input 
                                                placeholder="Name" required="" 
                                               class="form-control" type=""  
                                                name="label[]">
                                          </td>


                                         <td class="no_padding">
                                          <!--   <input 
                                                list="category_list" 
                                                placeholder="Category" required="" 
                                               class="form-control" type=""  
                                                name="category[]">
 -->
                                                <select class="form-control" required="" name="category[]">
                                                    <option value="">Select Category</option>
                                                    <?php foreach ($documents_categories as $key => $value) :?>
                                                    <option value="<?=$value;?>"><?=$value;?></option>
                                                    <?php endforeach;?>
                                                </select>

                                          </td>

                                          <td class="no_padding">

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
    <div class="card-content">
      <div class="card-body">
              <table id="myTable" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sn</th>
                  <th>Label</th>
                  <th>Category</th>
                  <th>Action</th>
                </tr>
              </thead>
              <?php $i=1; foreach ($all_documents as $key => $document) :?>
                <tr>
                 <td>
                  <?=$i++;?>
                  </td>

                 <td>
                    <a target="_blank" href="<?=domain;?>/<?=$document->path;?>"><b><?=$document->filename;?></b></a>
                  </td>

                 <td>
                    <b><?=$document->category;?></b>
                  </td>



                  <td>

                    <a href="javascript:void(0);" 
                    onclick="$confirm_dialog= new ConfirmationDialog('<?=domain;?>/admin/delete_doc/<?=$document->id;?>', 'Are you sure you want to delete <?=$document->filename;?>')" class="fa fa-trash text-danger" style="font-size: 20px;">

                    </td>
                </tr>
              <?php endforeach ;?>
            </table>



         <!--   <ul class="list-group list-group-flush">
             <li ng-repeat="(key, $doc) in $list.$lists" class="list-group-item" style="text-transform: capitalize;">
               <span class="label label-primary float-left">{{$index + 1}})</span> &nbsp;
                <a href="javascript:void(0);" ng-click="$list.attempt_delete($doc, key);"
               class="fa fa-trash text-danger float-right" style="font-size: 20px;">
               <i class=""></i></a>
               <a target="_blank" href="<?=domain;?>/{{$doc.files}}"><b>{{$doc.label}}</b></a>
             </li>
           
           </ul> -->
          <!--  <div class="card-body">
             <a href="javascript:void(0);" data-toggle="modal" data-target="#upload_company_supporting_document" 
                     title="Upload supporting company documents" class="card-link">Upload Documents</a>
           </div> -->
         </div>
       </div>

      </section>



        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
