<?php
$page_title = "Instructor";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
   
    <div class="content-body">

      <div class=" "  ng-controller="ShopController">

        <div class="">
          <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
              <h3 class="content-header-title mb-0">Instructor</h3>
              

            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">
              <div class="form-group"> 
               <a href="<?=domain;?>/courses/create"><button class="btn-icon btn btn-secondary btn-round" type="button"><i class="ft-plus"></i>Create Course</button></a>

           <!--    <button class="btn-icon btn btn-secondary btn-round" type="button"><i class="ft-life-buoy"></i></button>
              <button class="btn-icon btn btn-secondary btn-round" type="button"><i class="ft-settings"></i></button>
            -->  </div>
          </div>
        </div>
        <div class="content-body">

          <div class="card">
           <div  class="card-content collapse show">
                    <div class="card-body card-dashboard"><!-- 
                     <p class="card-text">DataTables has most features enabled by default, so all you need to do to use it with your own ables is to call the construction function: $().DataTable();.</p> -->
                     <table id="myTable" class="table table-striped table-bordered zero-configuration">
                      <thead>
                        <tr>
                          <th>Courses Created </th>
                          <th>Status</th>
                          <th>Created On</th>
                          <th>Last Updated</th> 
                          <th>Action</th>
                                    <!--
                                    <th>Payment Type</th>
                                  -->
                                </tr>
                              </thead>
                              <tbody>
                               <?php foreach ($this->auth()->created_courses as $course):?>
                                <tr>
                                  <td><b><?=$course->title;?></b></td>
                                  <td> <?=$course->ApprovalStatus;?></span></td>
                                </td>
                                <td><b><?=date("M j Y h:iA", strtotime($course->created_at));?></b></td>
                                <td><b><?=date("M j Y h:iA", strtotime($course->updated_at));?></b></td>
                                <td>
                                 <a href="<?=domain;?>/courses/<?=$course->id;?>/goal/<?=$this->encode_for_url($course->title);?>">
                                   <span class="badge badge-primary">
                                    <i class="ft ft-edit"></i> Edit
                                  </span></a>
                                </td>
                                
                              </tr>
                            <?php endforeach ;?>
                          </tbody>
                          
                        </table>
                      </div>
                    </div>
                  </div>
                  
                  <!--/ User Profile Cards -->


                </div>
              </div>
            </div>
            <!-- ////////////////////////////////////////////////////////////////////////////-->


          </div>
        </div>
      </div>
      <!-- END: Content-->

      <?php include 'includes/footer.php';?>
