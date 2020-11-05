<?php
$page_title = "Sales";
include 'includes/header.php';
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Sales</h3>
      </div>
      <div class="content-header-right col-6">
      </div>

        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">
              <?php include_once 'template/default/composed/filters/products_orders.php';?>
              <!-- <h4 class="card-title">Commission Wallet</h4> -->
              <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">


                <?=$note;?>

              </div>
            </div>
            <div class="card-content">


              <div class="card-body table-responsive">

              


                <table id="" class="table table-striped">
                  <thead>
                    <tr>
                      <th>#Ref</th>
                      <th>Buyer/Item</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php foreach ($orders as $order):?>
                    <tr>
                      <td><?=$order->TransactionID;?><br>
                        <span class="badge badge-primary"><?=date("M j, Y h:iA" , strtotime($order->created_at));?></span><br>
                        <?=$order->payment;?>
                      </td>
                      <td>
                        <?=$order->Buyer->fullname;?>
                        <?php 
                            $items_sold_by_editor = $order->items_sold_by_editor($auth->id);
                           foreach ($items_sold_by_editor['order_details'] as $item):
                          ?>
                              <div class="alert alert-dark" style="margin: 0px;padding: 2px;">
                                <b><?=($item['market_details']['name']);?></b><br>
                             </div>
                        <?php endforeach ;?>
                        Total: <?=$currency;?><?=MIS::money_format($items_sold_by_editor['total']);?>                      
                      </td>
                    </tr>
                  <?php endforeach ;?>



                </tbody>
              </table>

                  <?php if ($orders->isEmpty()) :?>
                    <center>Your sales will show here </center>
                  <?php endif ;?>
  


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
