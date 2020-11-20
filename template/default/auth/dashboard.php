<?php
$page_title = "Dashboard";
include 'includes/header.php';

use v2\Models\Wallet;
use v2\Models\Withdrawal;


$user = $auth;



$balances = Withdrawal::payoutBalanceFor($user->id);

$today = date("Y-m-d");

$week = MIS::date_range($today, 'week', true);

$month = MIS::date_range($today, 'month', true);

/*

$daterange = SiteSettings::binary_daterange();

$already_paid = v2\Models\Commission::where('user_id', $user->id)->Completed()->Paid()->sum('binary_points');


$life_personal_volume =  ($user->total_volumes('all', 'enrolment', [], 'volume', 'personal'));
$life_group_volume =  ($user->total_volumes('all', 'enrolment', [], 'volume', 'group'));



$life_group_points =  ($user->total_volumes('all', 'enrolment', [], 'points', 'group'));
$life_personal_points =  ($user->total_volumes('all', 'enrolment', [], 'points', 'personal'));



$TheRank = $user->TheRank;

$team_qualifiers =  $user->total_member_qualifiers_by_path('all', 'enrolment');

$direct_qualifiers =  $user->total_member_qualifiers_by_path('all', 'enrolment', 'direct_line');

*/

;?>

<style>
  .card{
    border-radius: 10px;
  }
  .small-padding{

    padding-top: 2px !important;
    padding-bottom: 2px !important;
    /*background: #073f2d;  */

  }


</style>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Dashboard </h3>
      </div>

    </div>
    <div class="content-body">
      <br>
      <div class="row match-height">   




        <div class="col-md-3">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <div class="media">
                  <div class="media-body text-left w-100">
                    <h3 class="secondary"><?=$currency;?> <?=MIS::money_format($balances['total_earnings']);?></h3>
                    <span>EARNINGS</span>
                  </div>
                  <div class="media-right media-middle">
                    <i class="icon-bar-chart secondary font-large-2 float-right"></i>
                  </div>                        
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-3">
             <div class="card">
               <div class="card-content">
                 <div class="card-body">
                   <div class="media">
                     <div class="media-body text-left w-100">
                       <h3 class="secondary"><?=$currency;?> <?=MIS::money_format($balances['sales']);?></h3>
                       <span>SALES</span>
                     </div>
                     <div class="media-right media-middle">
                       <i class="icon-graph secondary font-large-2 float-right"></i>
                     </div>                        
                   </div>
                 </div>
               </div>
             </div>
           </div>


        <div class="col-md-3">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <div class="media">
                  <div class="media-body text-left w-100">
                    <h3 class="secondary"><?=$currency;?> <?=MIS::money_format($balances['commissions']);?></h3>
                    <span>COMMISSION</span>
                  </div>
                  <div class="media-right media-middle">
                    <i class="icon-graph secondary font-large-2 float-right"></i>
                  </div>                        
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-3">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <div class="media">
                  <div class="media-body text-left w-100">
                    <h3 class="secondary">
                      <?php $sponsor = $user->referred_members_uplines(1) ;
                          echo ($sponsor[1]['username']) ?? 'Nil';
                      ;?></h3>
                      <span>SPONSOR</span>
                    </div>
                    <div class="media-right media-middle">
                      <i class="icon-user secondary font-large-2 float-right"></i>
                    </div>                        
                  </div>
                </div>
              </div>
            </div>
          </div>




        </div>


        <div class="row match-height" style="display: none;">   

            <div class="col-md-12">


              <div class="card  text-center col-12">
                <div class="card-content">
                  <div class="card-body">
                    <div class="row">

                      <div class="col-md-6" style="border-right: 1px solid #d6ae56;">           
                      <div class="col-md-12 mb-2">           
                          <center class="card-body badge-" style="
                          border-radius: 5px !important;
                          padding-top: 5px;
                          padding-bottom: 5px; ">
                          <div class="media " >
                            <div class="media-body w-100">
                              <span>Referral Link</span>
                            </div>
                          </div>
                          <div onclick="copy_text('<?=$user->referral_link();?>')"
                           class="col-md-5 progress progress-sm mt-1 mb-0 " style="color: black ;display: inline; height: 17px;margin: 3px !important;"><?=$user->referral_link();?>
                          <!-- <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div> -->
                        </div><button onclick="copy_text('<?=$user->referral_link();?>')" class="btn btn-sm badge-dark float-eft">Copy</button>
                      </center>
                        </div>
                        
                        <div style="">

                        <h6 style="">Current rank</h6>
                        <h6 class="card-title" style="margin-bottom: 0px;text-shadow: 1px 1px black;font-weight: 700;">
                          <?=$TheRank['name'];?>
                        </h6>

                        </div>                  


                      </div>
                      <div class="col-md-6"> 
                          

                        <!-- <br class="badge-dark">
                        <small>Current rank</small>
                        <h6 class="card-title" style="margin-bottom: 0px;text-shadow: 2px 2px black;font-weight: 700;">
                          <?=$TheRank['name'];?>
                        </h6>
                        <br class="badge-dark"> -->
                        <ul class="list-group list-group-flush">
                          <li class="small-padding list-group-item"> Next: <span class="badge badge-dark"><?=$TheRank['next']['name'];?></span></li>


                          <?php 

                          $actions = $TheRank['next']['rank_qualifications']['rating']['activity']; 

                          if($actions != ''):?>
                            <?php 
                                foreach ($actions as $key => $action) :
                                  $no = $action['count'];
                                $act = [
                                  'buy_x_course_in_level' => "Buy atleast $no Course in this Level"
                                ];
                              ?>
                            <li class="small-padding list-group-item" style="text-transform: capitalize;">Action: <?=$act[$action['action']];?></li>
                          <?php endforeach?>

                          <?php endif;?>

                          <?php if($TheRank['next']['rank_qualifications']['points_volume']['life_personal_points'] != ''):?>
                            <li  class="small-padding list-group-item">
                              LPP: <?=$life_personal_points;?>/<?=$TheRank['next']['rank_qualifications']['points_volume']['life_personal_points'];?>
                            </li>
                          <?php endif;?>

                          <?php if($TheRank['next']['rank_qualifications']['points_volume']['life_group_points'] != ''):?>
                            <li  class="small-padding list-group-item">
                              LGP: <?=$life_group_points;?>/<?=$TheRank['next']['rank_qualifications']['points_volume']['life_group_points'];?>
                            </li>
                          <?php endif;?>


                          <?php
                          //inteam
                          $in_team_text = "";
                          foreach ($TheRank['next']['rank_qualifications']['rating']['in_team'] as $key => $team_requirement) {

                            if (($team_requirement['count'] =='') || ($team_requirement['member_rank'] =='') ) {continue;}
                            $member_rank = $team_requirement['member_rank'] ?? 0;
                            $in_team_rank =  $TheRank['all_ranks'][$member_rank]['name'];
                            $in_team_text .= "<br>$team_requirement[count] $in_team_rank";
                          }

                          ;?>
                          <?php if ($in_team_text != ''):?>
                            <li  class="small-padding list-group-item">In Team: 
                              <?=$in_team_text;?>
                            </li>
                          <?php endif;?>

                          <?php
                          //directlines
                          $direct_lines_text = "";
                          foreach ($TheRank['next']['rank_qualifications']['rating']['direct_line'] as $key => $team_requirement) {

                            if (($team_requirement['count'] =='') || ($team_requirement['member_rank'] =='') ) {continue;}
                            $member_rank = $team_requirement['member_rank'] ?? 0;
                            $in_team_rank =  $TheRank['all_ranks'][$member_rank]['name'];
                            $direct_lines_text .= "<br>$team_requirement[count] -$in_team_rank";
                          }

                          ;?>
                          <?php if ($direct_lines_text != ''):?>
                            <li  class="small-padding list-group-item">In Front Line: 
                              <?=$direct_lines_text;?>
                            </li>
                          <?php endif;?>

                        </ul>
                     
                  </div>


                </div>

              </div>
            </div>
          </div>


        </div>

      </div>

      <div class="row">
        




        <div class="col-md-12">

          <div class="col-md-12">
            <h4>FINANCIAL STATS</h4>
            <div class="card">
              <div class="card-content">
                <div class="media align-items-stretch">
                  <div class="p-2 media-middle">
                    <h1 class="secondary"><?=$currency;?><?=MIS::money_format($balances['completed_withdrawal']);?></h1>
                  </div>
                  <div class="media-body p-2">
                    <h4>Completed Withdrawals</h4>
                  </div>
                  <div class="media-right p-2 media-middle">
                    <i class="ft-trending-down font-large-2"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>



          <div class="col-md-12">
            <div class="card">
              <div class="card-content">
                <div class="media align-items-stretch">
                  <div class="p-2 media-middle">
                    <h1 class="secondary"><?=$currency;?><?=MIS::money_format($balances['available_payout_balance']);?></h1>
                  </div>
                  <div class="media-body p-2">
                    <h4>PAYOUT AVAILABLE</h4>
                  </div>
                  <div class="media-right p-2 media-middle">
                    <i class="icon-wallet font-large-2"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>



        </div>

        <div class="col-md-6"  style="display: none;">
          <h4>CAREER INFORMATION
            <small class="float-right">
              
              Direct Referrals
              <span class="badge  badge-dark">
                <?php 
                  $downlines = $user->referred_members_downlines(1,'enrolment');
                  $direct_lines = $downlines[1] ?? [];
                  echo count($direct_lines);
                  ;?>
              </span> 
            </small>
          </h4>


          <div class="match-height">
            <div class="card" style="padding: 2px;">
              <div class="card-content">
              <div class="row">
              
                <div class="col-6">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item use-bg">
                      <span class="badge  badge-dark float-right" title="Life Personal Volume ">
                        <?=$currency;?><?=MIS::money_format($life_personal_volume);?></span>Life Personal Volume (LPV)
                   </li>

                    <li class="list-group-item use-bg">
                      <span class="badge  badge-dark float-right" title="Life Personal Points ">
                        <?=MIS::money_format($life_personal_points);?></span>Life Personal Points (LPP)
                   </li>


                  </ul>
                    <ul class="list-group list-group-flush">
                     <li class="list-group-item use-bg">
                     Direct Member Qualifiers<br>
                      <?=$direct_qualifiers['qualifiers_text'];?>
                    </li>
                  </ul>

               </div>
               <div class="col-6">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item use-bg">
                    <span class="badge  badge-dark float-right" title="Life Group Volume ">
                      <?=$currency;?><?=MIS::money_format($life_group_volume);?></span>Life Group Volume (LGV)
                  </li>


                  <li class="list-group-item use-bg">
                    <span class="badge  badge-dark float-right" title="Life Group Points ">
                      <?=MIS::money_format($life_group_points);?></span>Life Group Points (LGP)
                  </li>


                </ul>



                 <ul class="list-group list-group-flush">
                   <li class="list-group-item use-bg">
                   Team Member Qualifiers<br>
                    <?=$team_qualifiers['qualifiers_text'];?>
                  </li>
                </ul>

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
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>

