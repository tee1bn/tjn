<?php
$page_title = "Dashboard";
include 'includes/header.php';

$deposits = $auth->deposits;
$withdrawals = $auth->withdrawals;


;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Dashboard</h3>
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



      <div class="row">
        <div class="col-xl-6 col-lg-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="p-2 text-center bg-dark bg-darken-2">
                            <i class="ft-trending-up font-large-2 white"></i>
                        </div>
                        <div class="p-2 bg-gradient-x-dark  media-body">
                            <h5>Deposits <span class="badge badge-dark"><?=$deposits->count();?></span></h5>
                            <h5 class="text-bold-400 mb-0">
                              $<?=$deposits->sum('amount_to_fund');?> ~ <?=$currency;?><?=$deposits->sum('amount_confirmed');?>
                          </h5>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <div class="col-xl-6 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-dark bg-darken-2">
                        <i class="ft-trending-down font-large-2 white"></i>
                    </div>
                     <div class="p-2 bg-gradient-x-dark  media-body">
                         <h5>Withdrawals <span class="badge badge-dark"><?=$withdrawals->count();?></span></h5>
                         <h5 class="text-bold-400 mb-0">
                           $<?=$withdrawals->sum('amount');?> ~ <?=$currency;?><?=$withdrawals->sum('amount_payable');?>
                       </h5>
                   </div>

              </div>
          </div>
      </div>
  </div>
  <div class="col-xl-6 col-lg-6 col-12">
    <div class="card">
        <div class="card-content">
            <div class="media align-items-stretch">
                <div class="p-2 text-center bg-dark bg-darken-2">
                    <i class="ft-award font-large-2 white"></i>
                </div>
                <div class="p-2 bg-gradient-x-dark dark media-body">
                 <h5>Education</h5>
                 <h5 class="text-bold-400 mb-0"><i class="ft-uses"></i>    
                  <?=($auth->enrolled_courses()->count());?>
               </h5>
           </div>
       </div>
   </div>
</div>
</div>  
<div class="col-xl-6 col-lg-6 col-12">
    <div class="card">
        <div class="card-content">
            <div class="media align-items-stretch">
                <div class="p-2 text-center bg-dark bg-darken-2">
                    <i class="ft-box font-large-2 white"></i>
                </div>
                <div class="p-2 bg-gradient-x-dark dark media-body">
                 <h5>Trading Accounts</h5>
                 <h5 class="text-bold-400 mb-0"><i class="ft-uses"></i>    
                  <?=$auth->trading_accounts->count();?>
               </h5>
           </div>
       </div>
   </div>
</div>
</div>
</div>






<h3>Things you can do</h3>
<section id="video-gallery" class="card">
 <ul class="list-group list-group-flush">
    
    <li class="list-group-item bg-dark white">
        1) Verification: <small>When you verify your Identity, you are able to fully enjoy all of our services. Otherwise, there will be limits to processing a deposit or withdrawal with us.</small>
        <a href="<?=domain;?>/user/verification" class="badge bg-secondary float-right">Verify My Profile</a>
    </li>

    
    <li class="list-group-item bg-dark white">
        2) Take our beginner course.
        <a href="<?=domain;?>/courses/1/access/Forex-101" class="badge bg-secondary float-right">Begin Course </a>
    </li>    

    <li class="list-group-item bg-dark white">
        3) Open a Trading account
        <div class="dropdown" style="display: inline;">
          <button type="button" class="btn btn-secondary float-right  btn-sm dropdown-toggle" data-toggle="dropdown">
           Open Live Account
          </button>
            <div class="dropdown-menu">
              <?php foreach (v2\Models\Broker::Active()->get() as $broker):?>
                <a class="dropdown-item" target="_blank" href="<?=$broker->getOpenAccountLink();?>">
                <small><b><?=$broker->name;?></b> Live Account</small>
                 </a>
              <?php endforeach ;?>
          </div>
        </div>


    </li>

    <li class="list-group-item bg-dark white">
        3) Make Deposits into your trading account
        <a href="<?=domain;?>/user/make-deposit" class="badge bg-secondary float-right">Make Deposit </a>
    </li>

    <li class="list-group-item bg-dark white">
        4) Withdrawal from your trading account.
        <a href="<?=domain;?>/user/make-withdrawal" class="badge bg-secondary float-right">Make Withdrawal </a>
    </li>
    
    <li class="list-group-item bg-dark white">
        5) Tell a that your friend about <?=project_name;?>.
        <span class="badge bg-secondary float-right">Share <?=project_name;?></span>
    </li>
       
  <!--   <li class="list-group-item bg-dark white">
        5) Become a forex blogger.
        <span class="badge bg-secondary float-right">Make Withdrawal</span>
    </li>
     -->
 </ul>

</section>



</div>
</div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>

