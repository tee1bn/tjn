<?php
$page_title = "Process Deposit";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Process Deposit</h3>
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



              <h4 class="card-title" style="display: inline;">Process Deposit</h4>


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
                <a href="javascript:void(0);"  class="card-title"><h5 data-toggle="collapse" data-target="#demo">Deposit Order</h5></a>
                <div class="row collapse show"  id="demo" >
                  <div class="col-md-4">
                    <?php $user = $deposit->user;
                    echo $this->view('composed/user_detail', compact('user'), true);?>
                  </div>

                  <div class="col-md-4">
                    <table class="table table-striped">
                      <tr>
                        <th style='padding: 5px;'>Trans ID</th>
                        <td class='text-right' style='padding: 5px;'><?=$deposit->TransactionID;?></td>  
                      </tr>

                      <tr>
                        <th style='padding: 5px;'>Order</th>
                        <td class='text-right' style='padding: 5px;'>$<?=$deposit->amount;?></td>  
                      </tr>


                      <?= $deposit->fetchPaymentBreakdown()['line'];?>
                    </table>
                  </div>

                  <div class="col-md-4">
                    <table class="table table-striped table-sm">

                      <tr>
                        <th style='padding: 5px;'>Account Number</th>
                        <td class='text-right' style='padding: 5px;'><?=$deposit->account_number;?></td>  
                      </tr>

                      <tr>
                        <th style='padding: 5px;'>Broker</th>
                        <td class='text-right' style='padding: 5px;'><?=$deposit->broker->name;?></td>  
                      </tr>

                      <tr>
                        <th style='padding: 5px;'>Status</th>
                        <td class='text-right' style='padding: 5px;'><?=$deposit->PaidStatus;?><?=$deposit->DisplayStatus;?></td>  
                      </tr>

                      <tr>
                        <th style='padding: 5px;'>Date</th>
                        <td class='text-right' style='padding: 5px;'><?=date("M j, Y h:iA", strtotime($deposit->created_at));?></td>  
                      </tr>

                      <tr>
                        <th style='padding: 5px;'>Amount Confirmed </th>
                        <td class='text-right' style='padding: 5px;'><?=$currency;?> <?=MIS::money_format($deposit->amount_confirmed);?></td>  
                      </tr>

                      <tr>
                        <th style='padding: 5px;'>Amount to Fund </th>
                        <td class='text-right' style='padding: 5px;'> $<?=MIS::money_format($deposit->amount_to_fund);?></td>  
                      </tr>

                    </table>
                  </div>
                </div>



                <?php 
                $user = $deposit->user;
                $this->view('composed/user_transaction_history', compact('user'), true);

                ;?>
                <hr />



                <a href="javascript:void(0);"><h5 data-toggle="collapse" data-target="#process">Process & Comments</h5></a>
                <div class="row collapse show"  id="process" >

                  <div class="admin_comment col-md-4" style="height: 182px;overflow-y: scroll;">

                    <table class="table table-striped table-sm">


                      <?php

                      foreach ($deposit->adminComments() as $key => $comment):?>
                        <tr>
                          <td><?=$comment->comment;?>
                          <br>
                          <small><i>
                            <?=$comment->admin->fullname;?> 
                            <?=v2\Models\DepositOrder::get_status($comment->status);?>
                            <?=date("M j, Y h:iA", strtotime($comment->created_at));?> 
                          </i>
                        </small> 
                      </td>
                    </tr>
                  <?php endforeach;?>
                </table>


              </div>
              <div class="col-md-4" id="reverse_calculation">
                <?php if ($deposit->is_confirmed() ||  $deposit->is_completed()) :

                  $reverse_calculation = $deposit->doReverseCalculation($deposit->amount_confirmed);
                  $view = $this->buildView('composed/deposit_reverse_calculation', compact('reverse_calculation') );
                  echo $view;
                  ?>
                <?php endif;?>


              </div>
              <div class="col-md-4">

                <?php if (! $deposit->is_completed()) :?>




                  <?php if (count($filtered_admin_action) != 0) :?>
                    <form action="<?=domain;?>/deposit_crud/push_to_state" method="post">

                      <?php if (! $deposit->is_confirmed()) :?>
                        <div class="form-group">
                            <label>Amount Confirmed</label>

                            <input required="" min="0" type="number" onchange="determineAmountToFund(this.value);" step="0.01" name="amount_confirmed" class="form-control" >                        
                        </div>
                      <?php endif;?>





                      <div class="form-group">
                        <textarea rows="5" class="form-control" placeholder="Admin Comment" required="" name="comment"></textarea>
                        <input type="hidden" name="doc_id" value="<?=MIS::dec_enc('encrypt', $deposit->id);?>">
                      </div>

                      <div class="form-group">
                        <select class="form-control" name="status" required="">
                          <option value="">Select</option>
                          <?php foreach($filtered_admin_action as $key => $value) :?>
                            <option value="<?=$value;?>"> <?=$value;?></option>
                          <?php endforeach ; ?>
                        </select>                                   

                      </div>
                      <div class="form-group">
                        <button id="submit_btn" style="display:none;" class="btn btn-dark">Submit</button>
                        <button type="button" class="btn btn-dark" 
                        onclick="$confirm_dialog= new DialogJS(submit_form,[])">Proceed</button>

                      </div>

                    </form>

                    <script>
                      submit_form = function(){
                        $('#submit_btn').click();
                      }


                      determineAmountToFund = function($amount_confirmed){


                          $.ajax({
                              type: "POST",
                              url: $base_url+"/admin/request_reverse_calculation/<?=$enc_deposit_id;?>/"+$amount_confirmed,
                              data: null,
                              contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                              processData: false, // NEEDED, DON'T OMIT THIS
                              cache: false,
                              success: function(data) {     
                                  $("#page_preloader").css('display', 'none');

                                  console.log(data);
                                  $('#reverse_calculation').html(data.view);

                               
                              },
                              error: function (data) {
                              },
                              complete: function(){
                                  
                                  $("#page_preloader").css('display', 'none');

                              }
                          });

                      }

                      
                      
                    </script>

                  <?php endif;?>
                <?php endif;?>

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
