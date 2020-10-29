<?php

$user   =  User::find($user_id);
@$upline = $user->referred_members_uplines(1, $tree_key)[1];
$page_title = $tree['title'];
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0"><?=$tree['title'];?></h3>
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
              <h4 class="card-title"><?=$tree['title'];?></h4>
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
               <div class="row">
                <div class="referral col-md-6" align="center">
                  <?php
                  if ($upline['username'] == '') {
                    $upline_link = "#";
                  }else{
                    $upline_link = "$domain/genealogy/placement/$upline[username]/$tree_key";

                  }

                  ;?>


                  <a href="<?=$upline_link;?>">
                    <img src="<?=domain;?>/<?=$user->profilepic;?>" style="border-radius: 70%;height: 50px;"
                    data-toggle="tooltip" title="Upline: <?=ucfirst($upline['lastname']);?> <?=ucfirst($upline['firstname']);?>">
                    <?php if($user_id == $this->auth()->id):?>
                      <h4>Me</h4>
                      <?php else:?>
                        <h4><?=$user->lastname;?> <?=$user->firstname;?><br>
                         <!-- Level: <?=$user->rank;?> -->
                       </h4>
                     <?php endif;?>
                   </a>


                   <?=$ref_link =$this->auth()->referral_link();?>
                   <button onclick="copy_text('<?=$ref_link;?>');" class="btn btn-success">Copy Link</button>
                   <br>
                   <br>
                 </div>

               </div>

               <style>
                .tree-img{
                  
                  height: 50px;
                  border-radius: 100%;
                  width: 50px;
                }

              </style>

              <?php

              $downlines = $user->referred_members_downlines($levels,$tree_key);

              $ordinal = [
                1=> 'First Level - Direct Referrals',
                2=> 'Second Level - Referrals of Direct Referrals',
                3=> 'Third Level - Referrals of Second Level Referrals',
                4=> 'Fourth Level - Referrals of Third Level Referrals',
                5=> 'Fifth Level - Referrals of Fourth Level Referrals',
                6=> 'Sixth Level - Referrals of Fifth Level Referrals',
              ];

              for ($level=1; $level <=$levels; $level++) :

                $count = count($downlines[$level]);
                $message= '';
                if ( $count == 0) {
                  $message = '<div class="" align="center">
                  <b>No records found</b>
                  </div>';
                }

                $heading ="Level #$level";
                if($level ==1){
                  $heading = 'Direct referral (Level #'.$level.')';
                }


                ?>


                <div class="card-group" >
                  <div class="card card-default">
                    <div class="card-header">
                      <h4>
                        <a data-toggle="collapse" href="#collapse<?=$level;?>">
                          <?=$ordinal[$level];?> </a>
                          <span class="badge badge-danger pull-right"> <?=$count;?></span>
                        </h4>
                      </div>
                      <div id="collapse<?=$level;?>" class="card-collapse collapse  <?=($level==1)?'':'';?>">
                        <div class="card-body">
                         
                          <div class="row">


                           <?php
                           echo "$message";
                           foreach (@$downlines[$level] as $user){
                            echo  $this->showThisDownine($user['id'], $user_column);
                          }
                          ;?>


                        </div>



                      </div>
                    </div>
                  </div>

                  
                </div> 

              <?php endfor ;?>

              














              
            </div>
          </div>
        </section>



      </div>
    </div>
  </div>
  <!-- END: Content-->

  <?php include 'includes/footer.php';?>
