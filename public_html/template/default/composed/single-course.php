<?php

$person =  explode("/", MIS::current_url())[0];

if ($person == 'admin') {

  $base = "$domain/admin";
    // $action = explode('/', $_GET['url'])[3];
}else{

    // $action = explode('/', $_GET['url'])[2];
  $base = "$domain/courses";
}


;?>
<div class="content-body">


  <div class="" ng-controller="ShopController">
    <div class="content" style="margin: 0px;">
      <div class="content-header row">
        <div class="content-header-left  col-6 mb-2">
          <h3 class="content-header-title mb-0"><?=$course->title;?></h3>
          <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
            </div>
          </div>
        </div>
        <div class="content-header-right text-right col-6">
          <div class="form-group"> 
            <?php if ($access == 'granted'):?>
             <a href="<?=$base;?>/read/<?=$course->id;?>"> <button class="btn-icon btn btn-success btn-round" type="button"><i class="ft-unlock"></i>Start Course</button></a>
           <?php endif;?>

         </div>
       </div>
     </div>

     <div class="content-detached content-left">
      <div class="content-body"><section class="row">
        <div class="col-sm-12">

         <div id="what-is" class="card">
          <div class="card-header">
            <h4 class="card-title">What will I Achieve ?</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
              <ul class="list-inline mb-0">
                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
              </ul>
            </div>
          </div>
          <div class="card-content collapse show">
            <div class="card-body">
              <div class="card-text">
               <!--                <p>Starter kit is a set of pages with different layouts, useful for your next project to start development process from scratch with no time. </p> -->
               <ul>
                <?php foreach ( $course->GoalJson['aims'] as $aim):?>
                  <li><?=$aim;?>
                </li>
              <?php endforeach ;?>
            </ul>
          </div>
        </div>
      </div>
    </div>


    <div id="kick-start" class="card">
      <div class="card-header">
        <h4 class="card-title">Course Curriculum</h4>
        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
        <div class="heading-elements">
          <ul class="list-inline mb-0">
            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="card-content collapse show">
        <div class="card-body">
          <div class="card-text">

            <div id="accordionWrap2" role="tablist" aria-multiselectable="true">

              <?php
              $i=1;


              foreach (($course->CurriculumJson) as $section_key => $section):
                $section = (array) $section;
                ?>
                <div class="card collapse-icon accordion-icon-rotate left" style="border:1px solid #00000021; margin: 2px;">
                                                          <!--  <div id="heading21" class="card-header">
                                                               <a data-toggle="collapse" data-parent="#accordionWrap2" href="#accordion<?=$i;?>" aria-expanded="true" aria-controls="accordion<?=$i;?>" class="card-title lead collapsed">
                                                                   <?=$section['$title'];?></a>

                                                           <a  class="card-title lead collapsed show pull-right">
                                                               <b><?=count((array)$section['$lectures']);?> Lecture(s)</b>
                                                           </a>

                                                         </div> -->
                                                         <div id="accordion<?=$i;?>" role="tabpanel" aria-labelledby="heading21" class="collapse show" style="">
                                                           <div class="card-content">
                                                             <div class="card-body" style="padding: 0px;">
                                                               
                                                               <?php

                                                               foreach ($section['$lectures'] as $lecture_key => $lecture):
                                                                 $lecture = (array) $lecture;
                                                                 $data = $lecture['$data'];
                                                                 $data = (array) $data;                                       
                                                                 ?>
                                                                 <div class="card-header" style="border:1px solid #00000021; padding: 10px;">
                                                                   <i class="ft-check-circle"></i> <?=($section_key+1);?>
                                                                   <a href="<?=$base;?>/read/<?=$course->id;?>/<?=($section_key+1);?>" 
                                                                     class="card- collapsed" style="text-transform: capitalize; font-weight: 0px !important;"><b><?=$data['$title'];?></b></a>
                                                                     
                                                                   </div>
                                                                 <?php endforeach ;?>

                                                               </div>
                                                             </div>
                                                           </div>
                                                           
                                                         </div>
                                                         <?php $i++; endforeach ;?>

                                                       </div>
                                                     </div>
                                                   </div>
                                                 </div>
                                               </div>


                                               <div id="kick-start" class="card">
                                                <div class="card-header">
                                                  <h4 class="card-title">Course Requirements</h4>
                                                  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                  <div class="heading-elements">
                                                    <ul class="list-inline mb-0">
                                                      <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                    </ul>
                                                  </div>
                                                </div>
                                                <div class="card-content collapse show">
                                                  <div class="card-body">
                                                    <div class="card-text">

                                                     <!--  <p>Getting start with your project custom requirements using a ready template which is quite difficult and time taking process, Stack Admin provides useful features to kick start your project development with no efforts !</p> -->
                                                     <ul>
                                                      <?php foreach ( $course->GoalJson['requirements'] as $requirement):?>
                                                        <li><?=$requirement;?>
                                                      </li>
                                                    <?php endforeach ;?>


                                                  </ul>
                                                </div>
                                              </div>
                                            </div>
                                          </div>



                                          <div id="what-is" class="card">
                                            <div class="card-header">
                                              <h4 class="card-title">Who this Course is for</h4>
                                              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                              <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                </ul>
                                              </div>
                                            </div>
                                            <div class="card-content collapse show">
                                              <div class="card-body">
                                                <div class="card-text">
                                                 <!--                <p>Starter kit is a set of pages with different layouts, useful for your next project to start development process from scratch with no time. </p> -->
                                                 <ul>
                                                  <?php foreach ( $course->GoalJson['target_students'] as $target_student):?>
                                                    <li><?=$target_student;?>
                                                  </li>
                                                <?php endforeach ;?>
                                              </ul>
                                            </div>
                                          </div>
                                        </div>
                                      </div>


                                      <!-- How to-->
                                      <div id="how-to" class="card">
                                        <div class="card-header">
                                          <h4 class="card-title">Description</h4>
                                          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                          <div class="heading-elements">
                                            <ul class="list-inline mb-0">
                                              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            </ul>
                                          </div>
                                        </div>
                                        <div class="card-content collapse show">
                                          <div class="card-body">
                                            <div class="card-text">
                                              <p><?=$course->description;?></p>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </section>

                              </div>
                            </div>
                            <div id="sticky-wrapper" class="sticky-wrapper" style="float: right; height: 1133.75px;">
                              <div class="sidebar-detached sidebar-right sidebar-sticky" ,="," style="float: none;">
                                <div class="sidebar">
                                  <div class="sidebar-content card d-none d-lg-block">
                                    <div class="card-body">
                                      <div class="category-title pb-1">
                                        <h6>By <?=$course->instructor->lastname;?>  <?=$course->instructor->firstname;?> </h6>
                                        <small>Updated <?=date("M j Y" , strtotime($course->updated_at));?></small>
                                      </div>
                                      <!-- Card sample -->
                                      <div class="text-center">
                                        <img style="width: 260px; height: 170px; object-fit: cover;" class="card-img-top mb-1 img-fluid" data-src="holder.js/100px180/" src="<?=domain;?>/<?=$course->imageJson;?>" alt="Card image cap">
                                      </div>
                                      <h4 class="card-title"><?=$currency;?><?=$this->money_format($course->price);?></h4>
                                      <!-- <p class="card-text">content.</p> -->


                                      <!-- /Card sample -->
                                      <hr>

                                      <span id="to_find_scope"></span>

                                      <script>
                                        add_item = function ($course_id) {

                                          $form = new FormData();
                                          $.ajax({
                                            type: "POST",
                                            url: $base_url+"/course_api/find/"+$course_id,
                                            cache: false,
                                            contentType: false,
                                            processData: false,
                                            data: $form,
                                            success: function(data) {

                                            // show_notification(data);
                                            console.log(data);
                                            $scope = angular.element($('#to_find_scope')).scope();
                                            $scope.$shop.$cart.add_item(data);
                                            $scope.$apply();
                                            
                                          // $scope.fetch_page_content();
                                        },
                                        error: function (data) {
                                             //alert("fail"+data);
                                           }

                                         });


                                        }



                                      </script>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>





                      </div>
