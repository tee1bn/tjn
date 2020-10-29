<?php
$page_title = "Edit Questionaire";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">



          </div>

          <script src="<?=general_asset;?>/js/angulars/questionaire.js"></script>


          <script>
              $questionaire_id = <?=$questionaire->id;?>;
              $base_survey_url = '<?=domain;?>';
          </script>


          
          <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
                <a class="btn btn-secondary  float-right" href="<?=Questionaire::createLink();?>">+ Survey</a>
            </div>
          </div>
        </div>
        <div class="content-body">

      <section id="content" class="card" ng-controller="QuestionaireController" ng-cloak>
        <div class="card-header">
            <?php include_once 'includes/questionaire_nav.php';?>


          <h5><?=$questionaire->title;?></h5>
            
        </div>
         <div class="card-content">
          <div class="card-body">


            <form class="ajax_form" action="<?=domain;?>/survey_crud/update_questions" method="post">
                <div class="row">

                    <div class="col-4">

                         <div class="card-group">
                          <div class="card">
                            <div class="card-header">
                              <h6 class="card-title">
                                <a data-toggle="collapse" href="#collapse1">Questionaire</a>
                              </h6>
                            </div>
                            <div id="collapse1" class="card-collapse collapse show">
                              <div class="card-body">

                                   <div class="row">
                                        <div class="form-group col-md-12">
                                            <label>Title</label>
                                            <input type="" required="" name="title" class="form-control" value="<?=$questionaire->title;?>">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Questions Served</label>
                                            <input type=""  name="questions_served" class="form-control" value="<?=$questionaire->questions_served;?>">
                                            <small>*Filling this implies survey is a quiz</small>
                                        </div>
                                        
                                        <div class="form-group col-md-6">
                                            <label>Alotted Time (Secs)</label>
                                            <input min="0" type="number"  name="alotted_time" class="form-control" value="<?=$questionaire->alotted_time;?>">
                                        </div>
                                        
                                        <input type="hidden" required=""  name="id" value="<?=$questionaire->id;?>">
                                        <div class="form-group col-md-12">
                                            <label>Published Status</label>
                                            <select required="" class="form-control" name="is_published">
                                                <option value="">Select </option>
                                                <?php
                                                    $is_published = [1=>"Published", 0=>"Draft"];
                                                 foreach ($is_published as $key => $status) :?>
                                                    <option <?=($key==$questionaire->is_published)? 'selected': '';?> value="<?=$key;?>"><?=$status;?></option>
                                                <?php endforeach  ;?>

                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Success Response Note</label>
                                        <textarea name="success_response_note" class="form-control"><?=$questionaire->success_response_note;?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control"><?=$questionaire->description;?></textarea>
                                    </div>
                                  
                              </div>
                              <!-- <div class="card-footer">card Footer</div> -->
                            </div>
                          </div>
                        </div>
                    </div>


                    <div class="col-8">

                        <div class="card-group">
                          <div class="card">
                            <div class="card-header">
                              <h6 class="card-title">
                                <a data-toggle="collapse" href="#questions">Questions</a>
                              </h6>
                            </div>
                            <div id="questions" class="card-collapse collapse show">
                              <div class="card-body">

                                <div class="card-group" ng-repeat="($index, $question) in  $questionaire.$questions">
                                  <div class="card card-default">
                                    <div class="card-header">
                                      <h6 class="card-title">
                                        <a data-toggle="collapse" href="#qa{{$index}}">
                                            <span class="badge badge-danger"> 
                                            {{$index + 1}}</span>
                                             
                                            <b style="text-transform: capitalize;">{{$question.$form_field}}</b>
                                            - <small style="text-transform: lowercase;">{{$question.$attributes.question}}</small>
                                          </a>

                                            <span ng-click="$questionaire.remove_question($question)"
                                             class="fa fa-times float-right text-danger"></span>
                                      </h6>
                                    </div>
                                    <div id="qa{{$index}}" class="card-collapse collapse">
                                      <div class="card-body">

                                        <button type="button" class="btn btn-secondary btn-xs float-right" 
                                        ng-click="$question.add_option();"
                                        ng-if="$question.is_shown('options_button');">+ Option</button>
                                        

                                            <div class="">
                                                <div class="form-group col-xs-12" ng-if="$question.is_shown('question');">
                                                  <label> Question </label>
                                                   <input type="text" class="form-control" name="" ng-model="$question.$attributes.question"> 
                                                </div>


                                                <div class="form-group col-xs-12"  ng-if="$question.is_shown('options_button');">
                                                   <label> Options </label>
                                                   <div class="input-group col-md-12" ng-repeat="($index , $option) in $question.$options">
                                                         <span class="input-group-btn">
                                                           <button  class="btn btn-default" type="button">
                                                              {{$index + 1}}
                                                           </button>
                                                         </span>
                                                         <input name="" ng-model="$question.$options[$index].value"
                                                         type="text" class="form-control">
                                                         <span class="input-group-btn">
                                                           <button class="btn btn-default" ng-click="$question.delete_option($option);" type="button">
                                                               <span class="fa fa-times text-danger"></span>
                                                           </button>
                                                         </span>
                                                   </div>  

                                                </div>


                                                <div class="form-group col-xs-3" ng-if="$question.is_shown('answers');" >
                                                  <label> Answers </label>

                                                   <input placeholder="e.g 1, 2, 3.." class="form-control"
                                                       ng-model="$question.$attributes.answers">
                                                </div>


                                                <div class="form-group col-xs-3" ng-if="$question.is_shown('type');" >
                                                  <label > Type </label>
                                                   <select class="form-control"
                                                       ng-model="$question.$attributes.type">
                                                        <option value="">Select Type</option>
                                                       <option 
                                                        ng-repeat="($index, $type) in $question.$types"
                                                           value="{{$type}}" >
                                                           {{$type}}
                                                       </option>
                                                   </select>
                                                </div>


                                                <div class="form-group col-xs-3" ng-if="$question.is_shown('unique');" >
                                                  <label> Unique </label>
                                                   <select class="form-control"
                                                       ng-model="$question.$attributes.unique">
                                                        <option value="">Select </option>
                                                       <option 
                                                        ng-repeat="($index, $type) in $question.$unique_options"
                                                           value="{{$type}}" >
                                                           {{$type}}
                                                       </option>
                                                   </select>
                                                </div>



                                                <div class="form-group col-xs-3" ng-if="$question.is_shown('required');" >
                                                  <label> Required  </label>
                                                   <select class="form-control"
                                                       ng-model="$question.$attributes.required">
                                                        <option value="">Select </option>
                                                       <option 
                                                        ng-repeat="($index, $required) in $questionaire.$booleans"
                                                           value="{{$required}}" >
                                                           {{$required}}
                                                       </option>
                                                   </select>
                                                </div>


                                                <div class="form-group col-xs-3" ng-if="$question.is_shown('multiple');" >
                                                  <label> Select Multiple  </label>
                                                   <select class="form-control"
                                                       ng-model="$question.$attributes.multiple">
                                                        <option value="">Select </option>
                                                       <option 
                                                        ng-repeat="($index, $multiple) in $questionaire.$booleans"
                                                           value="{{$multiple}}" >
                                                           {{$multiple}}
                                                       </option>
                                                   </select>
                                                </div>



                                                <div class="form-group col-xs-3" ng-if="$question.is_shown('placeholder');">
                                                  <label> Placeholder </label>
                                                   <input type="text" class="form-control" name="" ng-model="$question.$attributes.placeholder">
                                                </div>


                                                <div class="form-group col-xs-3" ng-if="$question.is_shown('min');">
                                                  <label> Min </label>
                                                   <input type="number" class="form-control" name="" ng-model="$question.$attributes.min">
                                                </div>


                                                <div class="form-group col-xs-3" ng-if="$question.is_shown('max');">
                                                  <label> Max </label>
                                                   <input type="number" class="form-control" name="" ng-model="$question.$attributes.max">
                                                </div>
                                                



                                                <div class="form-group col-xs-3" ng-if="$question.is_shown('minlength');">
                                                  <label> MinLength </label>
                                                   <input type="number" class="form-control" name="" ng-model="$question.$attributes.minlength">
                                                </div>



                                                <div class="form-group col-xs-3" ng-if="$question.is_shown('minlength');">
                                                  <label> MaxLength </label>
                                                   <input type="number" class="form-control" name="" ng-model="$question.$attributes.maxlength">
                                                </div>
                                                


                                                <div class="form-group col-sm-3" ng-if="$question.is_shown('rows');">
                                                  <label> Rows </label>
                                                   <input type="number" class="form-control" name="" ng-model="$question.$attributes.rows">
                                                </div>
                                                



                                            </div>                                                               
                                          
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                    <input type="hidden" name="id" value="<?=$questionaire->id;?>">
                                    <textarea style="display: none;" name="questionaire" class="form-control">{{$questionaire}}</textarea>

                                    <hr/>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-secondary">Save</button>
                                    </div>                                                              
                              </div>
                            </div>
                          </div>
                        </div>

                    </div>
                </div>
            </form>




              
          </div>
        </div>
      </section>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
