<?php
$page_title = "Stats";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Stats</h3>
          </div>


          <script src="<?=general_asset;?>/js/angulars/questionaire.js"></script>


          <script>
              $questionaire_id = <?=$questionaire->id;?>;
              $base_survey_url = '<?=domain;?>';
          </script>

          
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

      <section id="content" class="card" ng-controller="QuestionaireResponseController" ng-cloak>
        <div class="card-header">

          <h4 class="card-title" style="display: inline;"></h4>
          <?php include_once 'includes/questionaire_nav.php';?>


          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
        
        <div id="single_response" class="modal fade" role="dialog">
          <div class="modal-dialog modal-md">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Single Response
                </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">

                    <small class="pull-right">Submitted: {{$questionaire.$see_response.detail.updated_at}}</small>
                <table class="table table-striped table-condensed">
                    <tbody>
                        <tr  ng-repeat="($index, $response) in $questionaire.$see_response.response">
                            <td> {{$index + 1}})  <label>{{$response.question}}</label><br>
                        <small>Ans:</small>
                            <span ng-bind-html="$questionaire.show_response($response.response);"></span>
                            </td>
                        </tr>
                    </tbody>
                </table>


              </div>
        
            </div>

          </div>
        </div>

        
         <div class="card-content">
          <div class="card-body">

          <div class="row" id="bonus_content">

                <table class="table table-striped" datatable='ng'>
                    <thead>
                        <th>SN</th>
                        <th>Response</th>
                        <th>Date</th>
                        <!-- <th>*</th> -->
                    </thead>
                    <tbody>
                        <tr ng-repeat="($index, $answer) in $response">
                            <td>{{$index+1}}</td>
                            <td><a href="Javascript:void(0);" ng-click="$questionaire.see_response($answer);">See Response</a></td>
                            <td>{{$answer.created_at}}</td>
                        </tr>
                    </tbody>
                </table>






              </div>



              
          </div>
        </div>
      </section>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
