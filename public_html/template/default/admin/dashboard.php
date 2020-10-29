<?php
$page_title = "Dashboard";
 include 'includes/header.php';?>
  <?php


    $settings = SiteSettings::site_settings();
    $min_withdrawal = $settings['minimum_withdrawal'];      
    $balance = $auth->available_balance();
    $withdrawable_balance =  $settings['withdrawable_percent'] * 0.01 * $balance;      
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
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-primary bg-darken-2">
                        <i class="icon-arrow-up font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-primary white media-body">
                        <h5>Upline</h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-pus"></i> 
                          <?=@$auth->referred_members_uplines(1)[1]['username'];?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-danger bg-darken-2">
                        <i class="ft-briefcase font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-danger white media-body">
                        <h5>Package</h5>
                        <small class="text-bold-400 mb-0"><i class="ft-c"></i>    
                          Your package will show here
                        <!-- <?=$auth->subscription->package_type;?> -->
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-warning bg-darken-2">
                        <i class="fa fa-sitemap font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-warning white media-body">
                        <h5>Referrals</h5>
                        <h5 class="text-bold-400 mb-0"><i class="ft-uses"></i>    
                          <?=count($auth->referred_members_downlines(1)[1]);?> 
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="media align-items-stretch">
                    <div class="p-2 text-center bg-success bg-darken-2">
                        <i class="icon-wallet font-large-2 white"></i>
                    </div>
                    <div class="p-2 bg-gradient-x-success white media-body">
                        <h5>Wallet</h5>
                        <h5 class="text-bold-400 mb-0"> <?=$currency;?> <?=MIS::money_format($balance);?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>








      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">News</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
         <div class="card-content">
      <div class="card-body row">

        <div class="col-md-12">
            <div class="card" style="height: 508px;">
                <div class="card-content">
                  
                    <ul class="list-group list-group-flush">
                     
                           <?php $i=1; foreach (BroadCast::live()->take(3) as $broadcast) :?>
                     
                        <li class="list-group-item bg-dark">
                            <span class="badge bg-dark float-right">
                                <?= $broadcast->created_at->toFormattedDateString();?></span>
                            <?=$broadcast->broadcast_message;?>
                        </li>
                        


                        <?php $i++; endforeach ;?>
                    </ul>
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

