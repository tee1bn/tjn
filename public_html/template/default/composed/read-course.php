                 <?php
                   
                   $person =  explode("/", MIS::current_url())[0];

                   if ($person == 'admin') {

                     $base = "$domain/admin";
                     // $action = explode('/', $_GET['url'])[3];
                     $home = "$domain/admin/courses";
                   }else{

                     $home = "$domain/courses";
                     // $action = explode('/', $_GET['url'])[2];
                     $base = "$domain/courses";
                   }


                 ;?>                 
                <div class="content-body">
                  
                  <style type="text/css">
                    
                    #textcontent img{/*
                      height: 25% !important;
                      width: 75% !important;
                      object-fit: contain;
                      object-position: center;*/
                    }
                  </style>

                  <script>

                    $("body").on("click", "img", function (e) {


                      $('#current_image').attr('src', this.src);
                      $('#img_modal').modal('show');

                    });


                       $('#txtInput').on("cut copy paste",function(e) {
                          e.preventDefault();
                       });


                    go_to_next = function(data){

                      $('#quiz_correction').html(data.correction);
                      $(".nextbtn").css('display', 'block');
                    }
                  </script>

                  <!-- The Modal -->
                  <div class="modal" id="img_modal">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Document</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                          <img id="current_image" src="" style="width: 100%; height: 100%;">

                        </div>
                      </div>
                    </div>
                  </div>


                    
                    <div class="" ng-controller="ShopController">
                          <div class="" style="margin: 0px;">
                            <div class="content-header row">
                              <div class="content-header-left col-6 mb-2">
                                <h5 class="content-header-title mb-0"><?=$course->title;?></h5>
                              </div>
                              <div class="content-header-right text-right col-6">
                           
                                <div class="form-group"> 
                                  <a href="<?=$home;?>/<?=$course->id;?>/access">
                                    <button class="btn-icon btn btn-success btn-round" type="button">
                                        <i class="fa fa-list"></i>
                                        Course outline 
                                    </button></a>
                               </div>
                              </div>
                            </div>
                            <div class="content-detached">
                              <div class="content-body"><section class="row">
                        <div class="col-sm-12">
           
                               
                    <?php
                    $i=1;
                    $section = (array) $course->CurriculumJson[($chapter -1)];

                        ?>
                                    <div class="card collapse-icon accordion-icon-rotate left">
<!--                                         <div id="heading21" class="card-header">
                                            <a data-toggle="collapse" data-parent="#accordionWrap2" href="#accordion<?=$i;?>" aria-expanded="true" aria-controls="accordion<?=$i;?>" class="card-title lead collapsed">
                                            Chapter <?=$chapter;?>:    <?=$section['$title'];?></a>

                                        <a  class="card-title lead collapsed show pull-right">
                                            <b><?=count((array)$section['$lectures']);?> Topic(s)</b>
                                        </a>
        
                                        </div>
 -->                                        <div id="accordion<?=$i;?>" role="tabpanel" aria-labelledby="heading21" class="collapse show" style="">
                                            <div class="card-content">
                                                <div class="card-body" id="textcontent" style="text-align: ;">

                                                <?php
                                                  //only the last lecture quiz will be handled
                                                   $current_url =  (explode('/',MIS::current_url('full')));
                                                   $state = end($current_url);
                                                   ;?>


                                                  <?php


                                                   foreach ($section['$lectures'] as $lecture_key => $lecture):
                                                      $lecture = (array) $lecture;
                                                      $data = $lecture['$data'];
                                                      $data = (array) $data;      

                                                      if ($auth) {
                                                        $textcontent = str_replace("[FIRSTNAME]", $auth->firstname, $data['textcontent']);            
                                                      }else{

                                                        $textcontent = str_replace("[FIRSTNAME]", '', $data['textcontent']);            
                                                      }         

                                                      $domain =Config::domain();
                                                      if (strpos($domain, '.') == false) {//local


                                                      }else{ //live
                                                          $textcontent = str_replace("/nf", "/9gforex.com", $textcontent);            
                                                      }



                                                      ?>

                                                        <div id="heading21" class="card-">
                                                            <a data-toggle="collapse" data-parent="#accordionWrap2" href="#accordion<?=$i;?>" aria-expanded="true" aria-controls="accordion<?=$i;?>" class="card-title lead collapsed">
                                                              Chapter <?=$chapter;?>:    <?=$data['$title'];?></a>
                                                              <hr/>

                                                        </div>
                                                        <div id="txtInput">
                                                          <?=$textcontent;?>
                                                        </div>

                                                         <br><hr><br>


                                                  <?php endforeach ;?>




                                                       <?php 

                                                        $questionaire = Questionaire::Published()->where('id', $data['quiz_id'])->first();
                                                           $quiz_response =  QuestionaireResponse::where('responder_id', $auth->id)
                                                           ->where('questionaire_id',$data['quiz_id'] )
                                                           ->first();
                                                            ;?>

                                                    <?php if(($questionaire != null) && ($auth)):?>


                                                    <?php if( ($quiz_response == null)):?>

                                                      <div id="quiz_div">
                                                        <?=$questionaire->html_form()->form;?>
                                                      </div>
                                                      
                                                      <hr/>
                                                      <div id="quiz_correction">

                                                      </div>

                                                    <?php else:?>
                                                      <div class="text-center">
                                                        
                                                      <h3 class="card-title">Your Quiz report</h3>
                                                      <div id="quiz_div">
                                                        <?=$quiz_response->Corrections;?>
                                                        <hr>
                                                      </div>
                                                      </div>

                                                      <script>
                                                        $(function() {

                                                          $(".nextbtn").css('display', 'block');
                                                        });
                                                      </script>
                                                  <?php endif;?>

                                                  <?php endif;?>

                                                </div>
                                            </div>
                                        </div>




                                       
                                    </div>  

                                  <?php

                                    $next_index = min(($chapter+1), count($course->CurriculumJson));
                                    $prev_index = max(($chapter-1), 1);
                                    $section_nav = (array) $course->CurriculumJson;
                                  
                                  ;?>



                                  <div class="row">
                                    <div class="col-6 " style="display: inline;">
                                      <a href="<?=$base;?>/read/<?=$course->id;?>/<?=$prev_index;?>" class="btn btn-outline-dark float-left"><< Prev</a>
                                      <br>
                                      <br>
                                      <span  class="float-left"> <?=$section_nav[($prev_index -1)]['$lectures'][0]['$data']['$title'];?></span>
                                    </div>

                                    <div class="col-6 " style="display: inline;">
                                      <a href="<?=$base;?>/read/<?=$course->id;?>/<?=$next_index;?>" class="btn btn-outline-dark float-right">Next >></a>
                                      <br>
                                      <br>
                                      <span class="float-right"> <?=$section_nav[($next_index -1)]['$lectures'][0]['$data']['$title'];?></span>
                                    </div>                                    
                                  </div>


                        </div>


                    </section>

                              </div>
                            </div>

                   
                          </div>
                        </div>
                       



                        <br>
                        <br>
                        <br>
                        <br>


                </div>

                <script>
                  
                  $images =  $('#txtInput img,#txtInput table');
                               $images.each(function(){
                                  $o =  $(this).css('max-width', '100%');
                                  $(this)[0].parentNode.href =  '#';
                                  
                               });
                </script>