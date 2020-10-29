<?php
$page_title = "Faqs";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <script src="<?=asset;?>/angulars/faq.js"></script>
    <div class="app-content content" id="content" ng-controller="FaqController" ng-cloak>
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Faqs</h3>
          </div>


          
          <div class="content-header-right col-6">
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
              <button class="btn btn-dark  " ng-click="$faq.add_faq();">Add +</button>                        
              <button class="btn btn-success  " onclick="$('#save_btn').click();">Save</button>                        

                  <form style="display: inline;" action="<?=domain;?>/cms_crud/update_faq" class="ajax_form"  method="post">
                    <textarea name="faq" style="display: none;" class="form-control" rows="5">{{$faq.$data.faq}}</textarea>
                      <button id="save_btn" type="submit" style="display: none;" class="btn btn-success">Save</button>
                    </form>
            </div>
          </div>
        </div>
        <div id="faq_modal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Question</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                  <form action="<?=domain;?>/cms_crud/update_faq" class="ajax_form"  method="post">
                    <div class="form-group">
                      <label>Question</label>
                      <input type="" name="faq[question]" ng-model="$faq.$current.question" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Answer</label>
                      <textarea id="editor" class="form-control"  name="faq[answer]" ck-editor   ng-model="$faq.$current.answer" 
                       style="height: 300px;"></textarea>
                    </div>

                    <textarea name="faq" style="display:none ;" class="form-control" rows="5">{{$faq.$data.faq}}</textarea>
                    <div class="form-group">
                      <button class="btn btn-dark">Save</button>
                    </div>

                  </form>

                  <script>    
                      // CKEDITOR.replace('editor' );
                  </script>    

              </div>
                <!-- 
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div> -->
            </div>

          </div>
        </div>


        <div class="content-body">



      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title" style="display: inline;">Faqs</h4>


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

              <table class="table table-striped">
                <thead>
                  <th></th>
                  <th>Question</th>
                </thead>
                <tbody>
                  <tr ng-repeat="($index, $fq) in $faq.$data.faq">
                    <td>{{$index + 1}}</td>
                    <td> 
                      <div class="panel-group">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title" style="display: inline;">
                              <a data-toggle="collapse" href="#collapse{{$index}}">{{$fq.question}} </a>
                            </h4>
                            <div class="btn-group btn-justified pull-right">
                              <button type="" class="btn btn-sm btn-dark" ng-click="$faq.open_editor($fq)">
                                Edit
                              </button>
                              <button ng-hide="$index==0" type="" class="btn btn-sm btn-danger" ng-click="$faq.remove_faq($fq)">
                                Delete
                              </button>
                            </div>
                          </div>
                          <div id="collapse{{$index}}" class="panel-collapse collapse">
                            <div class="panel-body" ng-bind-html='$fq.answer'></div>
                          </div>
                        </div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
                    
          </div>
        </div>
      </section>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
