<?php
$page_title = "Wallet";
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

            <h3 class="content-header-title mb-0">Wallet</h3>
          </div>
          
          <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
              </div>
              <a class="btn btn-outline-primary" href="#">Balance: <?=$currency;?><?=MIS::money_format($balance);?></a>
              <a class="btn btn-outline-primary" href="#">Available: <?=$currency;?><?=MIS::money_format($withdrawable_balance);?></a>
              <!-- <a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a> -->
            </div>
          </div>
        </div>
        <div class="content-body">
        
 <form method="post"  action="<?=domain;?>/user/make_withdrawal_request">
                                        <div class="input-group mb-3">
                                            <input class="form-control" required="" type="number" 
                                                min="<?=$min_withdrawal;?>"
                                                name="amount"
                                                max="<?=$withdrawable_balance;?>" 
                                                placeholder="Enter Amount">
                                            <div class="input-group-append">
                                                <button class="input-group-text">Withdraw</button>
                                            </div>
                                        </div>
                                </form>

      <section id="video-gallery" class="card">



        <div class="card-header">
          <h4 class="card-title">History</h4>
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


                            <div class="table-responsive">
                                
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>#Ref</th>
                                        <th>Upon</th>
                                        <th>Amount(<?=$currency;?>)</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach ($auth->earnings()->get() as $earning):?>
                                      <tr>
                                        <td><?=$earning->id;?></td>
                                        <td><?=$earning->earned_off->full_name;?></td>
                                        <td><?=$this->money_format($earning['amount_earned']);?></td>
                                        <td><?=$earning->commission_type;?></td>
                                        <td><span class="badge badge-primary"><?=$earning->created_at->toFormattedDateString();?></span></td>
                                      
                                      </tr>
                                    <?php endforeach ;?>

                                     <?php foreach ($this->auth()->withdrawals_history()->get() as $earning):?>
                                      <tr>
                                        <td><?=$earning->id;?></td>
                                        <td>*</td>
                                        <td><?=$this->money_format($earning['amount_earned']);?></td>
                                        <td>
                                            <?=$earning->commission_type;?>

                                            <br>
                                            <small>
                                                <?=$earning->extra_detail;?>
                                                
                                            </small>
                                            
                                        </td>
                                        <td><span class="badge badge-primary"><?=$earning->created_at->toFormattedDateString();?></span></td>
                                      
                                      </tr>
                                    <?php endforeach ;?>
                                    
                                    </tbody>
                                  </table>

                            </div>


         
      </div>
    </div>
      </section>



        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
