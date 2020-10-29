
              <ul class="nav nav-tabs" >
                <li class="active card-title"><a data-toggle="tab" href="#home" class="btn btn-sm btn-success">Deposit history</a></li>
                <li><a data-toggle="tab" > | </a></li>

                <li class="card-title"><a data-toggle="tab"  class="btn btn-sm btn-danger" href="#menu1">Withdrawal History</a></li>
              </ul>

              <div class="tab-content">
                <div id="home" class="tab-pane fade in active">

                  <a href="javascript:void(0);"><h5 data-toggle="collapse" data-target="#history">Deposit History</h5></a>
                  <div class="row collapse show table-responsive"  id="history" >
                    
                    <table class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>#Ref</th>
                          <th>Name</th>
                          <th>Account/Broker</th>
                          <th>Amount/Payable</th>
                          <th>Date/Status</th>
                          <!-- <th>Action</th> -->
                        </tr>
                      </thead>                    

                       <?php  $i=1; foreach ($user->deposits as $deposit) :?>
                        <tr>
                          <td><?=$i;?> - <?=$deposit->TransactionID;?></td>
                          <td><?=$deposit->user->DropSelfLink;?></td>
                          <td>
                            <?=$deposit->account_number;?><br>
                            <?=$deposit->broker->name;?>
                          </td>
                          <td>
                              $<?=MIS::money_format($deposit->amount);?><br>
                              <?=$currency;?><?=MIS::money_format($deposit->amount_payable);?><br>
                          </td>
                          <td><span class="badge badge-secondary"><?=$deposit->created_at->format('M j, Y H:i:A');?></span>
                            <br/><?=$deposit->DisplayStatus;?><?=$deposit->PaidStatus;?> </td>
                         <!--  <td>
                            <div class="dropdown">
                              <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                              </button>
                              <div class="dropdown-menu">
                                  <a class="dropdown-item" target="_blank" href="<?=domain;?>/admin/process_deposit/<?=$deposit->id;?>">
                                    <span type='span' class='label label-sm label-primary'>View</span>
                                  </a>
                              </div>
                            </div>

                          </td> -->
                        </tr>
                    
                        <?php $i++; endforeach ; ?>
                           
                    
                          </tbody>
                    </table>                               




                  </div>
                 
                </div>
                <div id="menu1" class="tab-pane fade">

                  <a href="javascript:void(0);"><h5 data-toggle="collapse" data-target="#history">Withdrawal History</h5></a>
                  <div class="row collapse show table-responsive"  id="history" >
                    
                    <table class="table table-striped table-sm">
                      <thead>
                        <tr>
                          <th>#Ref</th>
                          <th>Name</th>
                          <th>Account/Broker</th>
                          <th>Bank</th>
                          <th>Amount/Payable</th>
                          <th>Date/Status</th>
                          <!-- <th>Action</th> -->
                        </tr>
                      </thead>                    


                       <?php  $i=1; foreach ($user->withdrawals as $withdrawal) :?>
                          <tr>
                            <td><?=$i;?> - <?=$withdrawal->trans_id;?></td>
                            <td><?=$withdrawal->user->DropSelfLink;?></td>
                            <td>
                              <?=$withdrawal->account_number;?><br>
                              <?=$withdrawal->broker->name;?>
                            </td>

                            <td>
                              <small>Bank: </small><?=$withdrawal->bank->financial_bank->bank_name;?><br>
                             <small>Acc Name: </small> <?=$withdrawal->bank->account_name;?><br>
                             <small>Acc No: </small> <?=$withdrawal->bank->account_number;?>
                            </td>

                            <td>
                                $<?=MIS::money_format($withdrawal->amount);?><br>
                                <?=$currency;?><?=MIS::money_format($withdrawal->amount_payable);?><br>
                            </td>
                            <td><span class="badge badge-secondary"><?=$withdrawal->created_at->format('M j, Y H:i:A');?></span>
                              <br/><?=$withdrawal->DisplayStatus;?><?=$withdrawal->PaidStatus;?> </td>
                            <!-- <td>
                              <div class="dropdown">
                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" target="_blank" href="<?=domain;?>/admin/process_withdrawal/<?=$withdrawal->encrypt_id();?>">
                                      <span type='span' class='label label-sm label-primary'>View</span>
                                    </a>
                                </div>
                              </div>

                            </td> -->
                          </tr>



                    
                        <?php $i++; endforeach ; ?>
                           
                    
                          </tbody>
                    </table>                               




                  </div>


                </div>


            
              </div>
