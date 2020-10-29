<?php
$page_title = "User Verification";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>
            <h3 class="content-header-title mb-0" style="display: inline;">User Verification</h3>
            <small class="float-right">Showing <?=$documents->count();?> of <?=$data;?> </small>
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

              <?php include_once 'template/default/composed/filters/user_verification.php';?>
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
                      <th>Type</th>
                      <th>Status</th>
                      <th>Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>                    

                   <?php  $i=1; foreach ($documents as $document) :?>
                    <tr>
                      <td><?=$i;?></td>
                      <td><?=$document->user->DropSelfLink;?></td>
                      <td><?=$document->Type['name'];?></td>
                      <td><?=$document->DisplayStatus;?></td>
                      <td><span class="badge badge-secondary"><?=date('M j, Y h:iA', strtotime($document->created_at));?></span>
                      </td>

                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                          </button>


                          <!-- The Modal -->
                          <div class="modal" id="processs<?=$document->id;?>">
                            <div class="modal-dialog modal-xl">
                              <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                  <h4 class="modal-title"><?=$document->Type['name'];?> <?=$document->DisplayStatus;?></h4>
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <div class="row">
                                      <div class="col-md-4">
                                        <?php $user = User::find($document->user->id);
                                         echo $this->view('composed/user_detail', compact('user'), true);?>
                                      </div>
                                      <div class="col-md-4">
                                          <?php
                                            $which = 'pending';
                                           $this->view('composed/user_documents', compact('user','which'), true);?>
                                          <?php
                                          echo "Approved";
                                            $which = 'approved';
                                           $this->view('composed/user_documents', compact('user','which'), true);?>
                                      </div>
                                      <div class="col-md-4">

                                        <div class="admin_comment" style="height: 182px;overflow-y: scroll;">

                                          <table class="table table-striped table-sm">
                                            

                                            <?php

                                             foreach ($document->adminComments() as $key => $comment):?>
                                              <tr>
                                                <td><?=$comment->comment;?>
                                                <br>
                                                <small><i>
                                                  <?=$comment->admin->fullname;?> 
                                                  <?=v2\Models\UserDocument::get_status($comment->status);?>
                                                  <?=date("M j, Y h:iA", strtotime($comment->created_at));?> 
                                                </i>
                                                </small> 


                                             
                                              </td>
                                              </tr>
                                            <?php endforeach;?>
                                          </table>

                                          
                                        </div>
                                        <?php if (! $document->is_approved()) :?>
                                        <form action="<?=domain;?>/user_doc_crud/push_to_state" method="post">
                                          <div class="form-group">
                                            <textarea rows="5" class="form-control" placeholder="Admin Comment" required="" name="comment"></textarea>
                                            <input type="hidden" name="doc_id" value="<?=$document->id;?>">
                                          </div>

                                          <div class="form-group">
                                                <select class="form-control" name="status" required="">
                                                    <option value="">Select</option>
                                                    <?php foreach(v2\Models\UserDocument::$statuses as $key => $value) :?>
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
                              <a class="dropdown-item" href="javascript:void(0);" 
                                  onclick="open_modal('<?=domain;?>/<?=$document->path;?>')">View</a>

                              <a type="button" class="dropdown-item" data-toggle="modal" data-target="#processs<?=$document->id;?>">
                                Process
                              </a>



                              <a class="dropdown-item" target="_blank" href="<?=$document->user->AdminEditUrl;?>">
                                <span type='span' class='label label-xs label-primary'>Edit Client</span>
                              </a>

                              <?php if (! $document->user->has_verified_phone()) :?>
                              <a class="dropdown-item" href="javascript:void(0)'">
                                <span type='span' class='label label-xs label-primary'> <?=MIS::generate_form(
                                  ['user_id'=> $document->user->id],
                                  "$domain/user_doc_crud/verify_phone",
                                  'Verify Phone'
                                  
                                  );?></span>
                              </a>
                              <?php endif;?>

                              <?php if (! $document->user->has_verified_email()) :?>
                              <a class="dropdown-item" href="javascript:void(0)'">
                                <span type='span' class='label label-xs label-primary'> <?=MIS::generate_form(
                                  ['user_id'=> $document->user->id],
                                  "$domain/user_doc_crud/verify_email",
                                  'Verify Email'
                                  
                                  );?></span>
                              </a>
                              <?php endif;?>

 
                             
                          </div>
                        </div>

                      </td>
                    </tr>
                
                    <?php $i++; endforeach ; ?>
                       
                
                      </tbody>
                    </table>                               

                    

                    <!-- The Modal -->
                    <div class="modal" id="view">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">Modal Heading</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>

                          <!-- Modal body -->
                          <div class="modal-body">
                            <div><img src="" id="image" style="height: auto;width: 100%;"></div>

                          </div>

                       
                        </div>
                      </div>
                    </div>

                    <script>
                      open_modal = function($src){

                        $('#view').modal('show');
                        $('#image').attr('src', $src);
                      }


                      $(document).on('show.bs.modal', '.modal', function () {
                          var zIndex = 1040 + (10 * $('.modal:visible').length);
                          $(this).css('z-index', zIndex);
                          setTimeout(function() {
                              $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
                          }, 0);
                      });
                    </script>
                  
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
