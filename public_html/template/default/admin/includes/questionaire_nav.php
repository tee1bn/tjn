
                             <div class="btn-group special" >
                               <div class="btn-group ">
                                  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                                  + Form Field <span class="caret"></span></button>
                                  <ul class="dropdown-menu" role="menu">
                                                                              <a
                                                ng-click="$questionaire.add_question($form_field)"
                                                title="Click to add {{$form_field}} form field"
                                                ng-repeat="($index, $form_field) in $questionaire.$data.form_fields"
                                                        class="text-muted dropdown-item">
                                            <b  style="text-transform: capitalize;">{{$form_field}}</b>
                                          </a>
                                  </ul>
                                </div>

                               <a target="_blank" href="<?=$questionaire->PreviewLink;?>" class="btn btn-secondary">Preview</a>
                               <a target="_blank" href="<?=$questionaire->viewResponses;?>" class="btn btn-secondary">Stats</a>
                                 <a  href="<?=$questionaire->viewResponsesTable;?>" class="btn btn-secondary" >Responses</a>
                                 <a  href="<?=$questionaire->editLink;?>" class="btn btn-secondary" >Edit</a>
                                 <a class="btn btn-secondary" href="<?=Questionaire::createLink();?>">+ Survey</a>
                                 <a  href="<?=domain;?>/admin/survey" class="btn btn-dark" >All Surveys</a>

                             </div>

                             <style type="text/css">
                               .btn-group.special {
                                 display: flex;
                               }

                               .special .btn {
                                 flex: 1
                               }
                             </style>
                             <hr/>