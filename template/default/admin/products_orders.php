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


                  <table id="myTabl" class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th style="width: 20px;">#Ref</th>
                        <th>Items </th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php foreach ($orders as $order):?>
                      <tr>
                        <td><?=$order->TransactionID;?>
                        <span class="badge badge-sm badge-primary"><?=date("M j, Y h:iA" , strtotime($order->created_at));?></span><br>
                        <?=$order->payment;?><br>
                        <?=$order->Buyer->DropSelfLink;?>
                          
                        </td>
                        <td>
                          <?php foreach ($order->order_detail() as $item):?>
                                <div class="alert alert-secondary" style="margin: 0px;padding: 2px;">
                                  <b><a href="<?=$item['market_details']['single_link'];?>" target="_blank">
                                    <?=($item['market_details']['name']);?></a></b><br>
                                    <?=$item['qty'];?> x  <?=$this->money_format($item['market_details']['price']);?> = 
                                    <?=$this->money_format($item['market_details']['price'] * $item['qty'] );?>
                                </div>
                            
                          <?php endforeach ;?>
                          <b>Total</b>: <?=$currency;?> <?=$this->money_format($order->total_price());?>

                          <div class="dropdown" style="display: inline;">
                            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown">Action
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
                    <?php endforeach ;?>

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
