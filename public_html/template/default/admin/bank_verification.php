<?php
$page_title = "Bank Verification";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6  mb-2">
            <?php include 'includes/breadcrumb.php';?>
            <h3 class="content-header-title mb-0" style="display: inline;">Bank Verification</h3>
          </div>
          
          <div class="content-header-right col-6">
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
              <small class="float-right">Showing <?=$banks->count();?> of <?=$data;?> </small>
            <!--   <div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
              </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a> -->
            </div>
          </div>
        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">

              <?php include_once 'template/default/composed/filters/bank_verification.php';?>
              <h4 class="card-title" style="display: inline;"></h4>


              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                  <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
             <div class="card-content">
              <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#sn</th>
                      <th>User</th>
                      <th>Bank</th>
                      <th>Status</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>                    

                   <?php  $i=1; foreach ($banks as $bank) :?>
                    <tr>
                      <td><?=$bank->id;?></td>
                      <td><?=$bank->user->DropSelfLink;?></td>
                      <td>
                        <?=$bank->financial_bank->bank_name;?><br>
                        Acc Holder: <?=$bank->AccountHolder;?> <br>
                        Acc No: <?=$bank->account_number;?> <br>
                        
                      </td>
                      <td><?=$bank->DisplayStatus;?></td>
                      <td><span class="badge badge-secondary"><?=date('M j, Y h:iA', strtotime($bank->created_at));?></span>
                      </td>

                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                          </button>


                          <!-- The Modal -->
                          <div class="modal" id="processs<?=$bank->id;?>">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                  <h4 class="modal-title"><?=$bank->Type['name'];?> <?=$bank->DisplayStatus;?></h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="row">
                                      <div class="col-md-6">
                                        
                                        <?=$bank->financial_bank->bank_name;?><br>
                                        Acc Holder: <?=$bank->AccountHolder;?> <br>
                                        Acc No: <?=$bank->account_number;?> <br>

                                        <?php $user = User::find($bank->user->id);
                                         echo $this->view('composed/user_detail', compact('user'), true);?>
                                      </div>
                                      <div class="col-md-6">

                                        <div class="admin_comment" style="height: 182px;overflow-y: scroll;">

                                          <table class="table table-striped table-sm">
                                            

                                            <?php

                                             foreach ($bank->adminComments() as $key => $comment):?>
                                              <tr>
                                                <td><?=$comment->comment;?>
                                                <br>
                                                <small><i>
                                                  <?=$comment->admin->fullname;?> 
                                                  <?=v2\Models\UserBank::get_status($comment->status);?>
                                                  <?=date("M j, Y h:iA", strtotime($comment->created_at));?> 
                                                </i>
                                                </small> 
                                              </td>
                                              </tr>
                                            <?php endforeach;?>
                                          </table>

                                          
                                        </div>

                                        <?php if (! $bank->is_approved()) :?>

                                        <form action="<?=domain;?>/userbankcrud/push_to_state" method="post">
                                          <div class="form-group">
                                            <textarea rows="5" class="form-control" placeholder="Admin Comment" required="" name="comment"></textarea>
                                            <input type="hidden" name="doc_id" value="<?=$bank->id;?>">
                                          </div>

                                          <div class="form-group">
                                                <select class="form-control" name="status" required="">
                                                    <option value="">Select</option>
                                                    <?php foreach(v2\Models\UserBank::$statuses as $key => $value) :?>
                                                        <option value="<?=$key;?>"> <?=$value;?></option>
                                                    <?php endforeach ; ?>
                                                </select>                                   

                                          </div>
                                          <div class="form-group">
                                            <button class="btn btn-dark">Submit</button>
                                          </div>
                                        
                                              
                                        </form>
                                        <?php endif ;?>
                                        
                                      </div>
                                    </div>

                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>

                              </div>
                            </div>
                          </div>
                          <div class="dropdown-menu">
                              <a type="button" class="dropdown-item" data-toggle="modal" data-target="#processs<?=$bank->id;?>">
                                Process
                              </a>
                          </div>
                        </div>

                      </td>
                    </tr>
                
                    <?php $i++; endforeach ; ?>
                       
                
                      </tbody>
                    </table>                               

                  
              </div>
            </div>
          </section>

          <ul class="pagination">
              <?= $this->pagination_links($data, $per_page);?>
          </ul>

        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
