
<!-- Latest compiled and minified CSS -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
<?php

use v2\Models\Wallet;
use v2\Models\Withdrawal;

;?>
<style>
  table tbody tr:nth-child(even){ 
    background: #e9e9e9 !important;
  }

  table tbody tr td , table thead tr td { 
    padding: 5px;

  }

  table tbody tr , table thead tr { 
    line-height: 15px;
  }


  table thead td {
    background-color: #88b988a6;
    text-align: center;
  }
</style>                          


<div class="container">
  <div class="row">
    <div class="col-md-12">
        <?php if((!isset($remove_mle_detail)) || ($remove_mle_detail == false)):?>
      <div class="invoice-title">
        <h2 style="display: inline;">
          <!-- <img style="width: 100px;" src="<?=$logo;?>" >  -->
        </h2>

        <?=CMS::fetch('full_contact');?>
      </div>
      <hr>
      <?php endif;?>
      <div class="row">


        <table class="table" style="width: 100%;">
          <tbody>
            <tr>
              <td style="text-align: left;">
                <address>
                  <strong></strong><br>
                  Status: <?=$withdrawal['DisplayStatus'];?><br>
                  Payment Month: <?=date("F Y" , strtotime($withdrawal->payment_month));?><br>
                  IBAN: <?=$withdrawal->MethodDetailsArray['iban'];?>

                </address>

              </td>
              <td style="text-align: right;">
              </td>
              <td style="text-align: right;">

                <address>
                  <?php 
                  $user = $withdrawal->user;
                  ;?>

                  <strong>
                    <?=$user->fullname;?>
                  </strong>
                 <br>Phone: 
                  <a href="tel:<?=$user->phone;?>">
                    <?=$user->phone;?>
                  </a>
                  <br>Email: 
                  <a href="mailto:<?=$user->email;?>">
                    <?=$user->email;?>
                  </a>

                  <br>Address: 
                  <span style=""><?=$user->fullAddress;?></span>

                </address>



                <strong>Generated Date:</strong><br>
                <?=date("F d, Y");?><br><br>

              </td>
            </tr>
          </tbody>
        </table>

      </div>

      <hr>


      <div class="row">
        <div class="col-xs-6">
                    </div>
                    <div class="col-xs-6 text-right">
             </div>
                </div>
            </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title" style="text-align: center;"><strong>Summary</strong></h3>
              </div>
              <div class="panel-body">
                <div class="table-responsie">

                  <table class="table table-striped table-bordered" style="width: 100%; border:;">
                    <thead>
                      <tr>
                        <th>Sn</th>
                         <th style="text-align: left;">Ref</th>
                        <th style="text-align: right;">Remark</th>
                        <th style="text-align: right;">Post</th>
                        <th style="text-align: right;">Amount (<?=$currency;?>)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $i= 1;
                      $date_range = MIS::date_range($withdrawal->payment_month, 'month', true);
                      $credits = Wallet::whereDate('paid_at', '>=' , $date_range['start_date'])
                                            ->whereDate('paid_at', '<=' , $date_range['end_date'])
                                            ->where('user_id', $user->id)
                                            ->Credit()
                                            ->get();

                      $debits = Wallet::whereDate('paid_at', '>=' , $date_range['start_date'])
                                            ->whereDate('paid_at', '<=' , $date_range['end_date'])
                                            ->where('user_id', $user->id)
                                            ->Debit()
                                            ->get();


                      $commissions = $credits->merge($debits);

                      $sub_total = $credits->sum('amount') - $debits->sum('amount');

                      foreach ($commissions as $key => $commission) :?>

                        <tr>
                          <th scope="row"><?=$i++;?></th>
                          <td>
                            <p>#<?=$commission['id'];?> </p>
                          </td>
                          <td style="text-align: right;">
                            <p><small class="text-mute"> <?=$commission['comment'];?></small></p>
                          </td>
                          <td style="text-align: right;">
                            <?=$commission['type'];?>
                          </td>

                          <td style="text-align: right;">
                            <?=MIS::money_format($commission['amount'] );?>
                          </td>
                        </tr>

                      <?php endforeach ;?>
                    </tbody>
                  </table>


                            <hr>
                            <div style="width: 60%; float: left;">
                                <small>
                                  <!-- <?=CMS::fetch('bank_transfer');?> -->
                                </small>
                            </div>

                            <div style="width: 40%; float: right;">

                    <table class="table" style="width: 100%; border:;">
                      <tbody>

                        <tr>
                          <td style="text-align: right;">Sub Total(<?=$currency;?>)</td>
                          <td class="" style="text-align: right;">
                            <?=MIS::money_format($sub_total);?>
                          </td>
                        </tr>

                      <!--   <tr>
                          <td style="text-align: right;">Arrears(<?=$currency;?>)</td>
                          <td class="" style="text-align: right;">
                            <?=MIS::money_format($withdrawal->amount);?>
                          </td>
                        </tr>
 -->

                        <tr>
                          <td style="text-align: right;">Fee</td>
                          <td class="" style="text-align: right;">
                           - <?=MIS::money_format($withdrawal->fee);?>
                          </td>
                        </tr>



                        <tr>
                          <td class="text-bold-800" style="text-align: right;">Payable(<?=$currency;?>)</td>
                          <td class="text-bold-800 " style="text-align: right;"> 
                            <?=MIS::money_format($withdrawal->amountToPay);?>
                          </td>
                        </tr>

                      </tbody>
                    </table>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
    </div>





