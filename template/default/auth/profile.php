<?php
$page_title = "Profile";
include 'includes/header.php';?>
<style>
    .content-wrapper{
    height:auto !important;
  }

</style>

<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <!-- <h3 class="content-header-title mb-0">Profile</h3> -->
      </div>

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

          <section id="video-gallery" class="card">
            <div class="card-header">
              <h4 class="card-title">Profile <!-- <?=$auth->VerifiedBagde;?> --></h4>
              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                  <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
              </div>
            </div>

            <style>
              .full_pro_pix{
                width: 120px;
                height: 120px;
                object-fit: cover;
                border-radius: 100%;
                border: 1px solid #cc444433;
              }
            </style>


            <div class="card-content">

              <div class="card-body">
                <div class="row">
                  <div class="col-md-4" style="
                  margin-bottom: 20px;
                  border: 1px solid #14181f42;
                  padding: 19px;">
                <form class="form-horizontal" id="p_form" method="post" enctype="multipart/form-data" action="<?=domain;?>/user-profile/update_profile_picture">
                    <div class="user-profile-image" align="center" style="">
                      <img id="myImage" src="<?=domain;?>/<?=$auth->profilepic;?>" alt="your-image" class="full_pro_pix" />
                      <input type='file' name="profile_pix" onchange="form.submit();" id="uploadImage" style="display:none ;" />
                      <h4><?=ucfirst($auth->DisplayTradeName);?></h4>
                      <h4><?=ucfirst($auth->fullname);?></h4>
                      <?=$auth->activeStatus;?>
<!--                       <span class="badge badge-secondary">
                        <?=$auth->subscription->payment_plan->name;?>
                      </span>
 -->                      
                                         <label for="uploadImage" class="btn btn-secondary " style=""> Change Picture</label>

 <br>
                      <!-- <span class="text-danger">*click update profile to apply change</span> -->
                    </div>
                  </form>



                  <div class="col-md-12">

                    <br>

                    <?php

                     foreach (v2\Models\UserDocument::$document_types as $key => $type) :?>
                   
                      <!-- <div class=" card"> -->
                          <div class="card-header">
                            <!-- <h4 class="card-title" style="display: inline;"> -->
                              <a data-toggle="collapse" title="click to see uploaded documents" href="#collapse1<?=$key;?>"><i class="ft-caret"></i> <?=$type['name'];?></a>

                              <form class="ajax_for float-right" method="post"  action="<?=domain;?>/user_doc_crud/upload_document" 
                                enctype="multipart/form-data">
                                <input style="display:none; " type="file" name="document" onchange="form.submit();">
                                <?php 
                                  $document = $auth->documents->where('document_type', $key)->first();
                                if ((($document != null) && (! $document->is_status(2))) || ($document == null) ):?>
                                  <button class="btn btn-dark btn-sm" type="button" onclick="form.document.click();">+ Upload</button> 
                                <?php endif;?>
                                <input type="hidden" name="type" value="<?=$key;?>">
                              </form>                                

                            <!-- </h4> -->
                          </div>
                          <div id="collapse1<?=$key;?>" class=" collapse show" >
                            <div class="card-body">
                              <ul class="list-group list-group-flush">
                                <?php $i=1; foreach ($auth->documents->where('document_type', $key) as $key => $doc) :?>
                                <!-- The Modal -->
                                <div class="modal" id="myModal<?=$doc->id;?>">
                                  <div class="modal-dialog modal-lg  bg-dark">
                                    <div class="modal-content"style="background: black;">

                                      <!-- Modal Header -->
                                      <div class="modal-header"  style="background: black; border-color: black; ">
                                        <h4 class="modal-title"> <?=$type['name'];?> - <?=$doc->DisplayStatus;?>  </h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <!-- Modal body -->
                                      <div class="modal-body text-center" style="background: black;">
                                        <img src="<?=domain;?>/<?=$doc->path;?>" style="width: 100%;object-fit: contain;">
                                      </div>

                                    
                                    </div>
                                  </div>
                                </div>






                                  <li class="list-group-item card-header"><?=$i;?>) <?=$doc->DisplayStatus;?>  
                                  <a href="<?=domain;?>/<?=$doc->path;?>" data-toggle="modal" data-target="#myModal<?=$doc->id;?>"  class="float-right custom-warning btn btn-sm">Open</a><br>
                                    <!-- <small>hyuu uho i</small> -->
                                  </li>
                                <?php break; $i++; endforeach ;?>
                              </ul>
                                
                            </div>
                          </div>
                    <?php endforeach ;?>

                                                  

                    </div>

                </div>

                <div class="col-md-8" style="margin-bottom: 20px;border: 1px solid #14181f42;padding: 19px;">

                  <?php
                    if ($auth->has_verified_profile()) {
                        $disabled = '';
                    }else{
                        $disabled = "";
                    }

                  ;?>


                <div class="card-body card-body-bordered collapse show" id="demo1" >
                  <form id="profile_form"
                  class="ajax_form" 
                  action="<?=domain;?>/user-profile/update_profile" method="post">
                  <div class="form-group">
                    <label for="username" class="pull-left">Username *</label>
                    <input type="text"  name="username" disabled="" value="<?=$auth->username;?>" id="username" class="form-control" >
                  </div>

                  <div class="form-group">
                    <label for="tradename" class="pull-left">Tradename </label>
                    <input type="text"  name="tradename"  value="<?=$auth->tradename;?>" id="tradename" class="form-control">
                  </div>

            <!--       <div class="form-group">
                    <label>Gender</label>
                    <select <?=$disabled;?> class="form-control form-control" name="gender" required="" >
                      <option value="">Select</option>
                      <?php foreach (User::$genders as $key => $value) :?>
                        <option value="<?=$key;?>" <?=($auth->gender==$key)? 'selected' : '';?>><?=$value;?></option>
                      <?php endforeach ;?>
                    </select>
                  </div> -->


                  <div class="form-group">
                    <label for="firstName" class="pull-left">First Name *</label>
                    <input <?=$disabled;?> type="text" name="firstname"  value="<?=$auth->firstname;?>" id="firstName" class="form-control">
                  </div>

                  <div class="form-group">
                    <label for="lastName" class="pull-left">Last Name <sup>*</sup></label>
                    <input  <?=$disabled;?> type="text" name="lastname" id="lastName" class="form-control"  value="<?=$auth->lastname;?>">
                  </div>

                <!--   <div class="form-group">
                    <label for="birthdate" class="pull-left">Birth Date <sup>*</sup></label>
                    <input  type="date" name="birthdate" id="birthdate" class="form-control"  value="<?=$auth->birthdate;?>">
                  </div>
 -->
                  <div class="form-group">
                    <label for="email" class="pull-left">Email Address<sup>*</sup></label>
                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                      <span class="input-group-btn input-group-prepend"></span>
                      <input <?=$disabled;?> id="tch3" name="email"   value="<?=$auth->email;?>"
                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                      <span class="input-group-btn input-group-append">
                        <button class="btn btn-sm btn-outline bootstrap-touchspin-up" type="button">Require Verification</button>
                      </span>
                    </div> 
                  </div>


                  <div class="form-group">
                    <label for="phone" class="pull-left">Phone<sup>*</sup></label>
                    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                      <span class="input-group-btn input-group-prepend"></span>
                      <input id="tch3" name="phone"   value="<?=$auth->phone;?>"
                      data-bts-button-down-class="btn btn-secondary btn-outline" data-bts-button-up-class="btn btn-secondary btn-outline" class="form-control">
                      <span class="input-group-btn input-group-append">
                        <button class="btn btn-sm btn-outline bootstrap-touchspin-up" type="button">Require Verification</button>
                      </span>
                    </div> 
                  </div>                                        
<!-- 

                  <div class="form-group">
                    <label for="address" class="pull-left">Address <sup>*</sup></label>
                    <input type="text" name="address" id="address" class="form-control"  value="<?=$auth->address;?>">
                  </div>


                  <div class="form-group">
                    <label for="country" class="pull-left">Country<sup>*</sup></label>
                    <select class="form-control" name="country" required="">
                     <option value=""></option>
                     <?php foreach (World\Country::all() as $key => $country) :?>
                       <option <?=($auth->country == $country->id)?'selected' : '';?> value="<?=$country->id;?>"><?=$country->name;?></option>
                     <?php endforeach ;?>
                   </select>
                 </div>

 -->
                        <div class="form-group">

                          <button type="submit" class="btn btn-secondary btn-block btn-flat">Update Profile</button>

                        </div>
                      </form>

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
