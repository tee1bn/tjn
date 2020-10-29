<?php
$page_title = "All Courses";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
       
        <div class="content-body">

              <div class="app-content "  ng-controller="ShopController">

                    <div class="content-wrapper">
                  <div class="content-header row">
                    <div class="content-header-left col-6 ">
                      <h3 class="content-header-title mb-0"> All Courses</h3>
                   
                    </div>
                   <div class="content-header-right text-right col-6 ">
                        Enrolment(s)
                        <button class="btn-icon btn btn-secondary btn-round" type="button">
                           <span class="badge badge-primary"> 
                          <?=($auth->enrolled_courses()->count());?>
                          </span>
                        </button>
                    </div>
                  </div>
                  <br>
                  <div class="content-body">

                  <div class="card">
                     <div  class="card-content collapse show">
                              <div class="card-body card-dashboard"><!-- 
                                 <p class="card-text">DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</p> -->


                                 <table id="payment-histor" class="table table-striped table-bordered zero-configuration">
                                     <tbody>

                                       <?php foreach ($auth->enrolled_courses() as $course):?>

                                       <tr>
                                         <td style="padding: 2px;">
                                           <div class="col-xl-12 col-lg-12" style="padding: 0px;">
                                             <div class="alert bg-dark  alert-dismissible mb-2" role="alert">
                                               <strong class="float-"><?=$course->title;?></strong><br>
                                               <small>Instructor: <?=$course->Instructor->lastname;?> <?=$course->Instructor->firstname;?>
                                                </small>
                                                <br>
                                               <span class="float-right">
                                                 <a href="<?=domain;?>/courses/<?=$course->id;?>/access/<?=$this->encode_for_url($course->title);?>"><span class="btn btn-sm btn-primary">
                                                  <i class="ft ft-unlock"></i> Open</span></a>
                                               </span>
                                               <br/>
                                             </div>
                                           </div>

                                         </td>
                                       </tr>
                                       <?php endforeach;?>
                                     </tbody>
                                   
                                 </table>
                              </div>
                          </div>
                  </div>
             


                  </div>
                </div>
              </div>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
