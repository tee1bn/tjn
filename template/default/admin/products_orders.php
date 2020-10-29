<?php
$page_title = "$page_title";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6  mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0" style="display: inline;"><?=$page_title;?></h3>
          </div>
          
    <div class="content-header-right col-6">
      <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group" role="group">
            <small class="float-right">Showing <?=$orders->count();?> of <?=$data;?> </small>


        </div>
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
                      <th>Items x Qty</th>
                      <th>Product</th>
                      <th>Amount/Payable</th>
                      <th>Date/Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>                    

                   <?php  $i=1; foreach ($orders as $order) :?>
                    <tr>
                      <td><?=$i;?> - <?=$order->TransactionID;?></td>
                      <td><?=$order->user->DropSelfLink;?></td>
                      <td><?=$order->total_item();?> x <?=$order->total_qty();?></td>
                      <td>
                       <?=$order->order_detail()[0]['market_details']['name'];?>
                      </td>
                      <td>
                          <?=$currency;?><?=MIS::money_format($order->amount_payable);?><br>
                      </td>
                      <td><span class="badge badge-secondary"><?=date('M j, Y H:i:A', strtotime($order->created_at));?></span>
                        <br/><?=$order->DisplayStatus;?><?=$order->PaidStatus;?> </td>
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

                            <a  href="javascript:void(0);" onclick="$confirm_dialog = new ConfirmationDialog('<?=domain;?>/admin-products/mark_as_complete/<?=$order->id;?>')" 
                               class="dropdown-item"> 
                                 Mark as Paid 
                              <i class="fa fa-check"></i>
                            </a>


                            <a class="dropdown-item" href="<?=domain;?>/admin/order/<?=$order->id;?>">  
                                 Open 
                            </a>

                            <?php if ($order->payment_proof != null) : ?>
                                <a class="dropdown-item" target="_blank"
                                href="<?= domain; ?>/<?= $order->payment_proof; ?>">See Proof</a>
                            <?php endif; ?>


                            
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
