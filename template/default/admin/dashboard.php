<?php
$page_title = "Dashboard";
include 'includes/header.php';

use v2\Models\Wallet;
use v2\Models\Withdrawal;
use v2\Models\Commission;
use Illuminate\Database\Capsule\Manager as DB;


$user = User::find(1);



$balances = Withdrawal::payoutBalanceFor($user->id);

$today = date("Y-m-d");

$week = MIS::date_range($today, 'week', true);

$month = MIS::date_range($today, 'month', true);


$life_personal_volume =  ($user->total_volumes('all', 'enrolment', [], 'volume', 'personal'));
$life_group_volume =  ($user->total_volumes('all', 'enrolment', [], 'volume', 'group'));



$life_group_points =  ($user->total_volumes('all', 'enrolment', [], 'points', 'group'));
$life_personal_points =  ($user->total_volumes('all', 'enrolment', [], 'points', 'personal'));



$qualifiers =  $user->total_member_qualifiers_by_path('all', 'enrolment');



$withdrawals = Withdrawal::select(DB::raw("COUNT(*) as count"), 
                                    DB::raw("sum(amount) as amount"), 
                                    DB::raw("sum(fee) as fee"), 
                                    DB::raw("sum(amount) - sum(fee) as payable"), 
                                    'status' )->groupBy('status')->get()->keyBy('status');




$commissions = Commission::select(DB::raw("COUNT(*) as count"), 
                                    DB::raw("sum(amount) as amount"), 
                                    'type' )->groupBy('type')->get()->keyBy('type');




$generated_commissions = ($commissions['credit']['amount'] ?? 0) 
            - ($commissions['debit']['amount'] ?? 0);



$payout = $generated_commissions
            - ($withdrawals['completed']['payable'] ?? 0);




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




        <div class="col-md-4">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <div class="media">
                  <div class="media-body text-left w-100">
                    <h3 class="secondary"><?=User::count();?> | <?=User::where('rank','>', -1)->count();?></h3>
                    <span>Users | Ranked</span>
                  </div>
                  <div class="media-right media-middle">
                    <i class="icon-users secondary font-large-2 float-right"></i>
                  </div>                        
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <div class="media">
                  <div class="media-body text-left w-100">
                    <h3 class="secondary"><?=Withdrawal::count();?> | <?=Withdrawal::Pending()->count();?> |
                     <?=Withdrawal::Completed()->count();?> | <?=Withdrawal::Declined()->count();?> </h3>
                    <span>Withdrawals | pending | completed | declined</span>
                  </div>
                  <div class="media-right media-middle">
                    <i class="icon-graph secondary font-large-2 float-right"></i>
                  </div>                        
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-md-4">
          <div class="card">
            <div class="card-content">
              <div class="card-body">
                <div class="media">
                  <div class="media-body text-left w-100">
                    <h3 class="secondary">
                        <?=SupportTicket::count();?> |
                        <?=SupportTicket::Open()->count();?> |
                        <?=SupportTicket::Close()->count();?> 
                     </h3>
                      <span>Support Tickets | Open | Closed</span>
                    </div>
                    <div class="media-right media-middle">
                      <i class="fa fa-bookmark-o secondary font-large-2 float-right"></i>
                    </div>                        
                  </div>
                </div>
              </div>
            </div>
          </div>




        </div>



      <div class="row">
        




        <div class="col-md-6">

          <div class="col-md-12">
            <h4>FINANCIAL STATS</h4>


              <div class="card">
                <div class="card-content">
                  <div class="media align-items-stretch">
                    <div class="p-2 media-middle">
                      <h1 class="secondary"><?=$currency;?><?=MIS::money_format($generated_commissions);?></h1>
                    </div>
                    <div class="media-body p-2">
                      <h4>Generated Commissions</h4>
                    </div>
                    <div class="media-right p-2 media-middle">
                      <i class="ft-award font-large-2"></i>
                    </div>
                  </div>
                </div>
              </div>


            <?php


              $completed_fees = Withdrawal::Completed()->sum('amount');



            ;?>

            <div class="card">
              <div class="card-content">
                <div class="media align-items-stretch">
                  <div class="p-2 media-middle">
                    <h1 class="secondary"><?=$currency;?><?=MIS::money_format($withdrawals['completed']['amount'] ?? 0);?></h1>
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
                    <h1 class="secondary"><?=$currency;?><?=MIS::money_format($payout);?></h1>
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

        <div class="col-md-6">
          <h4>CAREER INFORMATION</h4>
          <div class="match-height">
            <div class="card" style="padding: 2px;">
              <div class="card-content">
              <!--   <div class="card-body">
                    <h4 class="card-title">enrolment Information</h4>
                </div>
              -->
              <div class="row">
              
                <div class="col-6">
                  <ul class="list-group list-group-flush">
                   <!--  <li class="list-group-item use-bg">
                      <span class="badge  badge-dark float-right" title="Weekly Personal Volume "><?=MIS::money_format($life_personal_volume);?></span>Personal Volume (PV)
                    </li> -->
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
                     Member Qualifiers<br>
                     <?=$qualifiers['qualifiers_text'];?>
                   </li>
                 </ul>


               </div>
               <div class="col-6">
                <ul class="list-group list-group-flush">
                 <!--  <li class="list-group-item use-bg">
                      <span class="badge  badge-dark float-right" title="Weekly Group Volume "><?=MIS::money_format($life_group_volume);?></span>Group Volume (GV)
                  </li> -->
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
                    Total Direct Referrals
                    <span class="badge  badge-dark">
                      <?php 
                        $downlines = $user->referred_members_downlines(1,'enrolment');
                        $direct_lines = $downlines[1] ?? [];
                        echo count($direct_lines);
                        ;?>
                    </span> 
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

