<?php
$page_title = "$page_title";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0" style="display: inline;"><?=$page_title;?></h3>
            <small class="float-right">Showing <?=$orders->count();?> of <?=$data;?> </small>
          </div>
          
    <div class="content-header-right col-md-6 col-12">
      <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group" role="group">
        <!--   <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
          <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div> -->
        </div>
        <!-- <a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a> -->
        <?=MIS::generate_form(['model'=>'Orders','user_foreign_key' => 'user_id'], "$domain/category_crud/new_category_app", 'Save into Category ', 'open_new_category_modal');?>

        <!-- <a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a> -->
      </div>
    </div>

        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">

            <?php include_once 'template/default/composed/filters/orders.php';?>

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
                      <th>#Ref</th>
                      <th>User</th>
                      <th>Course</th>
                      <th>Action</th>
                    </tr>
                  </thead>                    

                   <?php  $i=1; foreach ($orders as $order) :?>
                    <tr>
                      <td><?=$i;?> - <?=$order->TransactionID;?>
                        <br><span class="badge badge-secondary"><?=date('M j, Y H:i:A', strtotime($order->created_at));?></span>
                        <br/><?=$order->DisplayStatus;?><?=$order->PaidStatus;?>
                      </td>
                      <td><?=$order->user->DropSelfLink;?></td>
                      <td>

                       <?php foreach ($order->order_detail() as $item):?>
                             <div class="alert alert-light" style="margin: 0px;padding: 2px;">
                               <b><?=($item['market_details']['name']);?></b><br>
                                 <?=$item['qty'];?> x  <?=$this->money_format($item['deal_price']);?> = <?=$this->money_format($item['deal_price'] * $item['qty'] );?>


                                 <div class="dropdown" style="display: inline;">
                                   <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">
                                      <small class="badge badge-secondary"><?=@$item['market_details']['offers_available'][$item['offer_id']]['name'] ?? '';?></small>
                                   </button>
                                   <div class="dropdown-menu">
                                     <?php foreach ($item['market_details']['offers_available'][$item['offer_id']]['details_array'] as $key => $value) :?>

                                      <a href="javascript:void(0);" class="dropdown-item" >
                                        <?=$key;?>: <?=$value;?>
                                      </a>
                                     <?php endforeach ;?>


                                   </div>


                                 </div>


                             </div>
                         
                       <?php endforeach ;?>

                        Payable: <?=$currency;?><?=MIS::money_format($order->amount_payable);?>
                      </td>
                  
                      <td>

                          <?php if(! $order->is_paid()) :?>
                          <!--   <form id="fo<?=$order->id;?>" class="ajax_form"
                             action="<?=$order->reverifyLink;?>" method="post">
                             <button type="submit" class="dropdown-item" class="">
                              Query
                            </button>
                          </form> -->
                        <?php endif ;?>


                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                          </button>
                          <div class="dropdown-menu">
                              <a class="dropdown-item" target="_blank" 
                              onclick="$confirm_dialog = new ConfirmationDialog('<?=domain;?>/admin/mark_course_order/paid/<?=$order->id?>')">
                                <span type='span' class='label label-sm label-primary'>Mark Paid</span>
                              </a>

                              <a href="<?=domain;?>/admin/order_invoice/<?=$order->id;?>" class="dropdown-item" >
                                Invoice
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
