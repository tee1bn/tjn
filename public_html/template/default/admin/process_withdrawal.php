<?php
$page_title = "Process Withdrawal";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Process Withdrawal</h3>
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

       

          <h4 class="card-title" style="display: inline;">Process Withdrawal</h4>


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
              <a href="javascript:void(0);"><h5 data-toggle="collapse" data-target="#demo">Deposit Order</h5></a>
              <div class="row collapse show"  id="demo" >
                <div class="col-md-4">
                  <?php $user = $withdrawal->user;
                   echo $this->view('composed/user_detail', compact('user'), true);?>
                </div>

                <div class="col-md-4">
                  <table class="table table-striped">
                    <tr>
                        <th style='padding: 5px;'>Trans ID</th>
                        <td class='text-right' style='padding: 5px;'><?=$withdrawal->trans_id;?></td>  
                    </tr>

                     <tr>
                        <th style='padding: 5px;'>Order</th>
                        <td class='text-right' style='padding: 5px;'>$<?=$withdrawal->amount;?></td>  
                    </tr>

                    <tr>
                        <th style='padding: 5px;'>Payable</th>
                        <td class='text-right' style='padding: 5px;'><?=$currency;?><?=$withdrawal->amount_payable;?></td>  
                    </tr>

                     <tr>
                        <th style='padding: 5px;'>Bank</th>
                        <td class='text-right' style='padding: 5px;'><?=$withdrawal->bank->financial_bank->bank_name;?></td>  
                    </tr>

                     <tr>
                        <th style='padding: 5px;'>Account Holder</th>
                        <td class='text-right' style='padding: 5px;'><?=$withdrawal->bank->AccountHolder;?></td>  
                    </tr>

                     <tr>
                        <th style='padding: 5px;'>Account Number</th>
                        <td class='text-right' style='padding: 5px;'><?=$withdrawal->bank->account_number;?></td>  
                    </tr>

                  </table>
                </div>

                <div class="col-md-4">
                  <table class="table table-striped">
                    <tr>
                        <th style='padding: 5px;'>Account Number</th>
                        <td class='text-right' style='padding: 5px;'><?=$withdrawal->account_number;?></td>  
                    </tr>

                     <tr>
                        <th style='padding: 5px;'>Broker</th>
                        <td class='text-right' style='padding: 5px;'><?=$withdrawal->broker->name;?></td>  
                    </tr>

                     <tr>
                        <th style='padding: 5px;'>Status</th>
                        <td class='text-right' style='padding: 5px;'><?=$withdrawal->PaidStatus;?><?=$withdrawal->DisplayStatus;?></td>  
                    </tr>

                     <tr>
                        <th style='padding: 5px;'>Date</th>
                        <td class='text-right' style='padding: 5px;'><?=date("M j, Y h:iA", strtotime($withdrawal->created_at));?></td>  
                    </tr>

                  </table>
                </div>
              </div>


              <?php 
                $user = $withdrawal->user;
                $this->view('composed/user_transaction_history', compact('user'), true);

              ;?>
              <hr />


              <hr/>
              <a href="javascript:void(0);"><h5 data-toggle="collapse" data-target="#process">Process</h5></a>
              <div class="row collapse show"  id="process" >

                <div class="admin_comment col-md-6" style="height: 182px;overflow-y: scroll;">

                  <table class="table table-striped table-sm">
                    

                    <?php

                     foreach ($withdrawal->adminComments() as $key => $comment):?>
                      <tr>
                        <td><?=$comment->comment;?>
                        <br>
                        <small><i>
                          <?=$comment->admin->fullname;?> 
                          <?=v2\Models\Withdrawal::get_status($comment->status);?>
                          <?=date("M j, Y h:iA", strtotime($comment->created_at));?> 
                        </i>
                        </small> 
                      </td>
                      </tr>
                    <?php endforeach;?>
                  </table>

                  
                </div>
                <div class="col-md-6">
                  <?php if (! $withdrawal->is_completed()) :?>
                    <?php if (count($filtered_admin_action) != 0) :?>

                    <form action="<?=domain;?>/withdrawal_crud/push_to_state" method="post">
                      <div class="form-group">
                        <textarea rows="5" class="form-control" placeholder="Admin Comment" required="" name="comment"></textarea>
                        <input type="hidden" name="doc_id" value="<?=MIS::dec_enc('encrypt', $withdrawal->id);?>">
                      </div>

                      <div class="form-group">
                            <select class="form-control" name="status" required="">
                                <option value="">Select</option>
                                <?php foreach($filtered_admin_action as $key => $value) :?>
                                    <option value="<?=$key;?>"> <?=$value;?></option>
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
