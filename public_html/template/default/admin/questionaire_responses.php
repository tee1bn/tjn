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
         <div class="card-content">
          <div class="card-body">
            <div class="row" id="bonus_content">
             
                  <div class="card col-12">
                      <div class="card-header">
                        <h6 class="card-title">
                          <a data-toggle="collapse" href="#filters">Filters</a>
                          <span class="badge badge-danger float-right">{{$response.length}}</span>

                        </h6>
                      </div>
                      <div id="filters" class="card-collapse collapse show">
                        <div class="card-body">
                          <div class="row col-12">
                              <div class="col-6" ng-repeat="($index, $select) in $questionaire.get_question('select')">
                                  <div class="form-group">
                                      <label>{{$select.$attributes.question}}</label>
                                      <select multiple="" ng-model="$select.$filtered_option" class="form-control select2Multiple">
                                          <option ng-value={{$option}} ng-repeat="($index, $option) in $select.$options">{{$option.value}}</option>
                                          
                                      </select>
                                  </div>                                            
                              </div>

                          </div>
                        </div>
                      </div>
                  </div>

                  <div class="card col-12">
                      <div class="card-header">
                        <h6 class="card-title">
                          <a data-toggle="collapse" href="#responses">Responses</a>
                        </h6>
                      </div>
                      <div id="responses" class="card-collapse collapse show">
                        <div class="card-body">

                          <div class="row" id="respon">

                              <style>
                                    .dataTables_wrapper > .dataTables_filter,
                                    .dataTables_wrapper > .dataTables_paginate ,
                                    .dataTables_wrapper > .dataTables_length {
                                        display: none !important;
                                    }                                                      
                              </style>

                              <div class="card col-md-6"  
                              ng-repeat="(key, $select) in $questionaire.get_question('select')"
                              ng-init="$question_no = key"
                              >
                                <div class="card card-default">
                                  <div class="card-header">
                                    <h6 class="card-title">
                                      <a data-toggle="collapse" href="#responses_response{{$question_no}}">
                                           <b>{{$select.$attributes.question}}</b></a>
                                    </h6>
                                  </div>
                                  <div id="responses_response{{key}}" class="card-collapse collapse show">
                                    <div class="card-body">
                                      {{$select.$options_stat()}}

                                      <table  datatable="ng"  class="table table-condensed table-striped">
                                          <thead>
                                              <th></th>
                                              <th><!-- <i ng-click="" class="fa fa-sort"> --></th>
                                          </thead>
                                          <tbody>
                                              <tr  ng-repeat="($index, $option) in $select.options_stat()">
                                                  <td>
                                                      {{$option.value}}
                                                  </td> 
                                                   <td>
                                                      <span class="text-muted pull-right">{{$select.no_of_selections($option, $question_no)}}</span>
                                                  </td>
                                              </tr>
                                           </tbody>
                                      </table>

                                    </div>

                                  </div>
                                </div>
                              </div>



                              <div class="card col-md-6"  
                              ng-repeat="(key, $input) in $questionaire.get_question('input')"
                              ng-init="$question_no = key"
                              >
                                <div class="card card-default">
                                  <div class="card-header">
                                    <h6 class="card-title">
                                      <a data-toggle="collapse" href="#responses_response{{$question_no}}">
                                          
                                          <b>{{$input.$attributes.question}}</b></a>
                                    </h6>
                                  </div>
                                  <div id="responses_response{{key}}" class="card-collapse collapse show">
                                    <div class="card-body">

                                      <span ng-repeat="($index, $answer) in $input.get_stat($question_no)"
                                       class="text-muted"
                                       title="{{$answer.occurence}}" 
                                       style="font-size: {{$answer.font_size}}px; color: {{$answer.colour}}" 
                                       >{{$answer.input}} &nbsp;</span> 
                                    </div>

                                  </div>
                                </div>
                              </div>



                              
                          </div>

                        </div>



                      </div>
                  </div>

                  






                </div>



              
          </div>
        </div>
      </section>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
