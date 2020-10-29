<?php
$page_title = "Profile";
include 'includes/header.php';?>

<script src="<?=general_asset;?>/js/angulars/registration.js"></script>

<!-- BEGIN: Content-->
<div class="app-content content" ng-controller="RegisterationController">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Profile</h3>
      </div>

    </div>
    <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Profile</h4>
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

          <div class="card-body row">
            <div class="col-md-4" style="
            margin-bottom: 20px;
            border: 1px solid #14181f42;
            padding: 19px;">
            <form class="form-horizontal ajax_form" 
            id="registration_form" method="post" enctype="multipart/form-data" action="<?=domain;?>/user-profile/update_profile_picture">
            <div class="user-profile-image" align="center" style="">
              <img id="myImage" src="<?=domain;?>/<?=$user->profilepic;?>" alt="your-image" class="full_pro_pix" />
              <input type='file' name="profile_pix" onchange="form.submit();" id="uploadImage" style="display:none ;" />
              <h4><?=ucfirst($user->username);?></h4>
              <h4><?=ucfirst($user->fullname);?></h4>
              <?=$user->activeStatus;?>
              <!-- <label for="uploadImage" class="btn btn-secondary " style=""> Change Picture</label> -->

              <br>
              <!-- <span class="text-danger">*click update profile to apply change</span> -->
            </div>
          </form>
          <hr>

          <?php  $this->view('composed/user_documents', compact('user'));?>



        </div>

        <div class="col-md-8" style="
        margin-bottom: 20px;
        border: 1px solid #14181f42;
        padding: 19px;">

        <div class=" card">
          <div class="card-header">
            <h4 class="card-title">
              <a data-toggle="collapse" href="#collapse1">Profile</a>
            </h4>
          </div>
          <div id="collapse1" class=" collapse show">
            <div class="card-body table-bordered">
              <form id="profile_form"
              class="ajax_form" 
              action="<?=domain;?>/user-profile/update_profile" method="post">

              <div class=" row">



                <div class="form-group col-md-6">
                  <label>Title</label>
                  <select class="form-control" name="title" >
                    <option value="">Select</option>
                    <?php foreach (User::$titles as $key => $value) :?>
                      <option value="<?=$key;?>" <?=($user->title == $key)? "selected":'';?> ><?=$value;?></option>
                    <?php endforeach ;?>
                  </select>

                  <span class="text-danger"><?=@$this->inputError('title');?></span>

                </div>


                <div class="form-group col-md-6">
                  <label for="username" class="pull-left">Username *</label>
                  <input type="text"  name="username" disabled="" value="<?=$user->username;?>" id="username" class="form-control" value="">
                </div>

                <div class="form-group col-md-6">
                  <label for="firstName" class="pull-left">First Name *</label>
                  <input type="text" name="firstname"  value="<?=$user->firstname;?>" id="firstName" class="form-control">
                </div>

                <div class="form-group col-md-6">
                  <label for="lastName" class="pull-left">Last Name <sup>*</sup></label>
                  <input type="text" name="lastname" id="lastName" class="form-control"  value="<?=$user->lastname;?>">
                </div>

                <div class="form-group col-md-6">
                  <label for="middlename" class="pull-left">Middle Name <sup>*</sup></label>
                  <input type="text" name="middlename" id="middlename" class="form-control"  value="<?=$user->middlename;?>">
                </div>


                <div class="form-group col-md-6">
                  <label>Gender</label>
                  <select class=" form-control" name="gender" >
                    <option value="">Select</option>
                    <?php foreach (User::$genders as $key => $value) :?>
                      <option value="<?=$key;?>" <?=($user->gender == $key)? "selected":'';?> ><?=$value;?></option>
                    <?php endforeach ;?>
                  </select>


                </div>



                <div class="form-group col-md-6">
                  <label>Birth Date</label>
                  <input type="date"  class="form-control " value="<?=$user->birthdate;?>" name="birthdate" placeholder="">
                </div>






                <div class="form-group col-md-6">
                  <label for="email" class="pull-left">Email Address<sup>*</sup></label>
                  <input id="tch3" name="email"   value="<?=$user->email;?>"
                  class="form-control">
                </div>


                <div class="form-group col-md-6">
                  <label for="phone" class="pull-left">Phone<sup>*</sup></label>
                  <input id="tch3" minlength="11" maxlength="11"  placeholder="08123546574" name="phone"   value="<?=$user->phone;?>"
                  class="form-control">
                </div>                                        

                <div class="form-group col-md-6">
                  <label for="country" class="pull-left">Country<sup>*</sup></label>
                  <select class="form-control" name="country" required="">
                   <option value=""></option>
                   <?php foreach (World\Country::all() as $key => $country) :?>
                     <option <?=($user->country == $country->id)?'selected' : '';?> value="<?=$country->id;?>"><?=$country->name;?></option>
                   <?php endforeach ;?>
                 </select>
               </div>



               <input type="hidden" name="user_id"  value="<?=MIS::dec_enc('encrypt', $user->id);?>">

               <fieldset class="form-group col-md-6">
                <label>State</label>  


                <select required="" class="form-control" name="state">
                   <option value=""></option>
                   <?php foreach (World\Country::find(160)->states as $key => $state) :?>
                     <option <?=($user->state == $state->id)?'selected' : '';?> value="<?=$state->id;?>"><?=$state->name;?></option>
                   <?php endforeach ;?>
                <option value="">Select State</option>
                <option ng-repeat="($index, $state) in $world.$states" ng-select="2647 == {{$state.id}}"  value="{{$state.id}}">{{$state.name}}</option>
              </select>



              <span class="text-danger"><?=@$this->inputError('state');?></span>
            </fieldset>

            <div class="form-group col-md-6">
             <label for="" class="pull-left">Address <sup>*</sup></label>
             <input type="text" name="address" class="form-control"  value="<?=$user->address;?>">
           </div>

         </div>

         <div class="form-group col-md-6">

          <button type="submit" class="btn btn-secondary btn-block btn-flat">Update Profile</button>

        </div>
      </form>


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
