<?php
$page_title = "Dashboard";
include 'includes/header.php';

use v2\Models\Wallet;
use v2\Models\Withdrawal;
use v2\Models\InvestmentPackage;


$user = $auth;


$pack = InvestmentPackage::for($user->id)->latest()->first();

$balances = Withdrawal::payoutBalanceFor($user->id);
$left_volume = ($user->total_volumes(0, 'binary', false, 'investment'));
$right_volume = ($user->total_volumes(1, 'binary', false, 'investment'));
$total_volumes = $left_volume + $right_volume;
$TheRank = $user->TheRank;


$action = str_replace('_', ' ',  $TheRank['next']['rank_qualifications']['rating']['activity']['action']);

$qualifiers_left =  $user->total_member_qualifiers_by_path(0, 'binary');
$qualifiers_right =  $user->total_member_qualifiers_by_path(1, 'binary');



;?>



<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Dashboard</h3>
    </div>

    <div class="content-header-right col-6">
        <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
          <a class="btn btn-outline-primary" href="Javascript:void(0);">
            <span class="badge badge-secondary">
                <?=$user->subscription->payment_plan->name;?>
            </span>
        </a>
    </div>
</div>
</div>
<div class="content-body">
    <br>
    <div class="row">

        <div class="col-md-6">

          <?php if ($pack != null) :?>

            <div class="card text-white bg-primary text-center" style="background: #101010 !important;">
                <div class="card-content">
                    <div class="card-body">
                        <!-- <img src="<?=asset;?>/images/logo/two-coins.jpg" alt="element 01" width="190" class="float-left img-fluid"> -->
                        <h4 class="card-title mt-1">YOUR FINANCE PACK <br>
                         <span class="badge badge-secondary"> <?=$pack->ExtraDetailArray['investment']['name'];?> </span> - 
                         <?=$currency;?><?=$pack->ExtraDetailArray['capital'];?>
                       </h4>
                         <div class="progress progress-sm mt-1 mb-0">
                           <div class="progress-bar bg-secondary" role="progressbar" style="width: <?=$pack->maturity;?>%" 
                            aria-valuenow="<?=$pack->maturity;?>" aria-valuemin="0" aria-valuemax="100"></div>
                       </div>
                        <p class="card-text">Your Pack Expires when it reaches <?=$pack->ExtraDetailArray['annual_roi'];?>% return.</p>
                        <a href="<?=domain;?>/user/purchase-investment" class="btn btn-primary btn-darken-3">Upgrade Your Package</a>
                    </div>
                </div>
            </div>
          <?php else :?>

            <div class="card text-white bg-primary text-center" style="background: #101010 !important;">
                <div class="card-content">
                    <div class="card-body">
                        <!-- <img src="<?=asset;?>/images/logo/two-coins.jpg" alt="element 01" width="190" class="float-left img-fluid"> -->
                        <h4 class="card-title mt-1">YOUR FINANCE PACK <br>

                       </h4>
                        <p class="card-text">Your latest will show here when you make a purchase .</p>
                        <a href="<?=domain;?>/user/purchase-investment" class="btn btn-primary btn-darken-3">Buy a Package</a>
                    </div>
                </div>
            </div>


          <?php endif ;?>


            <div class="card text-white bg-primary text-center" style="background: #101010 !important;">
                <div class="card-content">
                    <div class="card-body">
                      <div class="row">
                      <div class="col-md-6">
                        
                        <h6 class="card-title">CURRENT RANK</h6>
                      
                          <!-- <button class="btn btn-primary btn-darken-3">Buy Now</button> -->
                         <small>
                           
                          <?=$TheRank['name'];?>
                         </small><br><br>
                           <div class="media-right media-middle">
                            <i class="icon-star secondary font-large-2 float-lft"></i>
                        </div>   
<!--                      <h6 class="card-title"><span class="badge-success badge">
                        </span>
                       </h6>
 -->                      

                      </div>
                      <div class="col-md-6">
                        <span class="badge badge-secondary"> NEXT: <?=$TheRank['next']['name'];?></span>
                        <ul>
                          <?php if($action != ''):?>
                          <li style="text-transform: capitalize;">Action: <?=$action;?></li>
                          <?php endif;?>

                          <?php if($TheRank['next']['rank_qualifications']['points_volume']['points'] != ''):?>
                            <li>Points Volume: <?=$total_volumes;?>/<?=$TheRank['next']['rank_qualifications']['points_volume']['points'];?></li>
                          <?php endif;?>

                          <?php

                            //inteam
                          $in_team_text = "";
                          foreach ($TheRank['next']['rank_qualifications']['rating']['in_team'] as $key => $team_requirement) {
                            if ($team_requirement[count] =='') {continue;}
                            $in_team_rank =  $TheRank['all_ranks'][$team_requirement['member_rank']]['name'];
                            $in_team_text .= "<br>$team_requirement[count] $in_team_rank";
                          }

                            //binary gain
                          $binary_gains_text = "";
                          foreach ($TheRank['next']['rank_qualifications']['binary_gains'] as $key => $binary_gains) {
                            if (($binary_gains[count] =='') ||($binary_gains[level] =='')) {continue;}
                            $binary_gains_text .= "<br>$binary_gains[count] Level $binary_gains[level]";
                          }




                            $direct_lines = $TheRank['next']['rank_qualifications']['rating']['direct_line'];

                              //direct_line
                              $direct_line_text = '';
                             foreach ($direct_lines as $key => $direct_line){

                                $direct_line_text .= "$direct_line[count] $direct_line[position] ";
                             }
                            

                           if ( strlen(trim($direct_line_text)) != 0):?>

                          <li>Direct Line: 

                              <?=$direct_line_text;?>
                          
                          </li>
                          <?php endif;?>

                          <?php if ($in_team_text != ''):?>
                          <li>In Team: 
                            <?=$in_team_text;?>
                          </li>
                          <?php endif;?>

                          <?php if ($binary_gains_text != ''):?>
                          <li>Binary Gain: 
                            <?=$binary_gains_text;?>
                          </li>
                          <?php endif;?>
                          
                        </ul>
                      </div>
                      </div>

                    </div>
                </div>
            </div>



            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left w-100">
                                    <h3 class="danger" onclick="copy_text('<?=$user->referral_link();?>')">Copy link</h3>
                                    <span>REFERRAL LINK</span>
                                </div>
                                <div class="media-right media-middle"  onclick="copy_text('<?=$user->referral_link();?>')">
                                    <i class="ft-link danger font-large-2 float-right btn btn-secondary btn-sm"></i>
                                </div>                        
                            </div>
                            <div class="progress progress-sm mt-1 mb-0" style="height: 17px;"><?=$user->referral_link();?>
                            <!-- <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div> -->
                        </div>
                    </div>
                </div>
            </div>
            </div>


        </div>

        <div class="col-md-6 row">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body text-left w-100">
                                    <h3 class="secondary"> <?=$currency;?> <?=MIS::money_format($balances['deposit_balance']);?></h3>
                                    <span>DEPOSIT</span>
                                </div>
                                <div class="media-right media-middle">
                                    <i class="icon-wallet secondary font-large-2 float-right"></i>
                                </div>                        
                            </div>
                            <div class="progress progress-sm mt-1 mb-0">
                              <div class="progress-bar bg-secondary" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>


          <div class="col-md-6">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body text-left w-100">
                                <h3 class="success"> <?=$currency;?> <?=MIS::money_format($balances['payout_balance']);?></h3>
                                <span>PAYOUT</span>
                            </div>
                            <div class="media-right media-middle">
                                <i class="icon-wallet success font-large-2 float-right"></i>
                            </div>                        
                        </div>
                        <div class="progress progress-sm mt-1 mb-0">
                          <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <div class="col-md-6">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left w-100">
                            <h3 class="warning"><?=$currency;?> <?=MIS::money_format($balances['total_earnings']);?></h3>
                            <span>EARNINGS</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-social-dropbox warning font-large-2 float-right"></i>
                        </div>                        
                    </div>
                    <div class="progress progress-sm mt-1 mb-0">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="col-md-6">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left w-100">
                        <h3 class="info"><?=$currency;?> <?=MIS::money_format($balances['commission_balance']);?></h3>
                        <span>COMMISSION</span>
                    </div>
                    <div class="media-right media-middle">
                        <i class="icon-layers info font-large-2 float-right"></i>
                    </div>                        
                </div>
                <div class="progress progress-sm mt-1 mb-0">
                  <div class="progress-bar bg-info" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
          </div>
      </div>
  </div>
</div>


<div class="col-md-6">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left w-100">
                        <h3 class="danger"><?=$currency;?> <?=MIS::money_format($balances['hot_wallet']);?></h3>
                        <span>HOT WALLET</span>

                        <small>Sellable Coins:  <?=$currency;?> <?=MIS::money_format($balances['available_hot_wallet']);?> </small>

                        <?php if ($balances['available_hot_wallet'] > 0) :?>
                            <button class="btn btn-secondary btn-sm" onclick="$confirm_dialog = new ConfirmationDialog('<?=domain;?>/user/sell_hotwallet_coins',
                            'Do you want to sell  <?=$currency;?><?=MIS::money_format($balances['available_hot_wallet']);?> ? ');">Sell</button>
                        <?php endif;?>
                    </div>
                    <div class="media-right media-middle">
                        <i class="icon-social-dropbox danger font-large-2 float-right"></i>
                    </div>                        
                </div>
                <div class="progress progress-sm mt-1 mb-0">
                  <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="col-md-6">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left w-100">
                        <span>COLD WALLET</span>
                        <a href="#" class="">
                            <p class="text-bold-400 mb-0">
                                Price: <?=tch;?>/USD <?=$balances['trucash_exchange'];?><br>
                                <?=$currency;?> <?=$balances['held_wallet'];?> => <?=tch;?><?=$balances['held_wallet_in_trucash'];?> 
                            </p>
                        </a>

                    </div>
                    <div class="media-right media-middle">
                        <i class="icon-shield secondary font-large-2 float-right"></i>
                    </div>                        
                </div>
                <div class="progress progress-sm mt-1 mb-0">
                  <div class="progress-bar bg-secondary" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="col-md-6">
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <div class="media">
                    <div class="media-body text-left w-100">
                        <h3 class="danger">
                            <?=$user->referred_members_uplines(1)[1]['username'];?></h3>
                            <span>SPONSOR</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-user danger font-large-2 float-right"></i>
                        </div>                        
                    </div>
                    <div class="progress progress-sm mt-1 mb-0">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 40%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>





</div>




</div>

<div class="row">

    <div class="col-md-6">

                <!-- <h4>BINARY INFORMATION</h4> -->

        <div class="match-height">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title">Binary Information</h4>
                    </div>

                    <div class="row">
                        <div class="col-6">

                          <ul class="list-group list-group-flush">
                              <li class="list-group-item">
                                  Total Direct Referrals
                                  <span class="badge badge-pill bg-primary">
                                      <?=count($user->referred_members_downlines(1,'placement')[1]);?>
                                  </span> 
                              </li>

                          </ul>

                        </div>
                        <div class="col-6">

                          <ul class="list-group list-group-flush">
                              <li class="list-group-item">
                                  Binary Volume
                                  <span class="badge badge-pill bg-primary">
                                      <?=$currency;?><?=MIS::money_format($total_volumes);?>
                                  </span> 
                              </li>

                          </ul>
                          
                        </div>
                        <div class="col-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <span class="badge badge-pill bg-danger float-right"><?=$currency;?><?=MIS::money_format($left_volume);?></span> Volume Left
                                </li>
                                <li class="list-group-item">
                                     Member Left Qualifier
                                    <span class="badge badge-pill bg-danger float-"><?=$qualifiers_left['qualifiers_text'];?></span>
                                </li>
                            </ul>

                        </div>
                        <div class="col-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <span class="badge badge-pill bg-secondary float-right"><?=$currency;?><?=MIS::money_format($right_volume);?></span> Volume Right
                                </li>
                                <li class="list-group-item">
                                    Member Right Qualifier
                                    <span class="badge badge-pill bg-danger float-"><?=$qualifiers_right['qualifiers_text'];?></span>
                                </li>
                            </ul>
                        </div>

                    </div>
                  </div>
                </div>
            </div>

        </div>

        <div class="col-md-6">

            <div class="col-md-12">
                <h4>FINANCIAL STATS</h4>
                <div class="card">
                    <div class="card-content">
                      <div class="media align-items-stretch">
                        <div class="p-2 media-middle">
                            <h1 class="success"><?=$currency;?><?=MIS::money_format($balances['completed_withdrawal']);?></h1>
                      </div>
                      <div class="media-body p-2">
                          <h4>Completed Withdrawals</h4>
                              </div>
                      <div class="media-right bg-success p-2 media-middle">
                          <i class="icon-wallet font-large-2 white"></i>
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
                  <h1 class="success"><?=$currency;?><?=MIS::money_format($balances['rank_bonus']);?></h1>
              </div>
              <div class="media-body p-2">
                  <h4>Career/Rank Bonus</h4>
              </div>
              <div class="media-right bg-success p-2 media-middle">
                  <i class="icon-wallet font-large-2 white"></i>
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
          <h1 class="success"><?=$currency;?><?=MIS::money_format($balances['available_payout_balance']);?></h1>
      </div>
      <div class="media-body p-2">
          <h4>PAYOUT AVAILABLE</h4>
      </div>
      <div class="media-right bg-success p-2 media-middle">
          <i class="icon-wallet font-large-2 white"></i>
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

