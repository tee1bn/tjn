<?php
$page_title = "Orders";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Orders</h3>
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
              <!-- <h4 class="card-title">Orders</h4> -->
              <?php
              $remove_user = true;
               include_once 'template/default/composed/filters/products_orders.php';?>

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



                  <table id="" class="table table-striped">
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
                        <?=$order->payment;?>
                        </td>
                        <td>
                          <?php foreach ($order->order_detail() as $item):?>
                                <div class="alert alert-secondary" style="margin: 0px;padding: 2px;">
                                  <b><a href="javascript:void;"><?=($item['market_details']['name']);?></a></b><br>
                                    <?=$item['qty'];?> x  <?=$this->money_format($item['market_details']['price']);?> = 
                                    <?=$this->money_format($item['market_details']['price'] * $item['qty'] );?>
                                </div>
                            
                          <?php endforeach ;?>
                          <b>Total</b>: <?=$currency;?> <?=$this->money_format($order->total_price());?>
                          <div class="dropdown" style="display: inline;">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-toggle="dropdown">
                             Action <span class="caret"></span></button>
                              <form id="payment_proof_form<?=$order->id;?>" action="<?=domain;?>/user/upload_payment_proof/<?=$order->id;?>" method="post" enctype="multipart/form-data">
                                <input 
                                style="display: none" 
                                type="file" 
                                onchange="document.getElementById('payment_proof_form<?=$order->id;?>').submit();" id="payment_proof_input<?=$order->id;?>"  
                                name="payment_proof">

                                <input type="hidden" name="order_id" value="<?=$order->id;?>">
                              </form>

                              <ul class="dropdown-menu">

                              <?php if(! $order->is_paid()) :?>
                              

                                <li>
                                 <a href="javascript:void;" class="dropdown-item"  onclick="document.getElementById('payment_proof_input<?= $order->id;?>').click()" >
                                    Upload Proof
                                </a></li>

                                <li>
                                 <a href="<?=domain;?>/user/pay_now/<?=$order->id;?>" class="dropdown-item" >
                                    Pay Now
                                </a></li>
                              
                              <?php else:?>
                           
                              <?php endif;?>                                             




                                <?php if($order->payment_proof !=null) :?>
                                  <li><a class="dropdown-item" target="_blank" href="<?=domain;?>/<?=$order->payment_proof;?>">See Proof</a>
                                  </li>
                                <?php endif ;?>
                             
                                <li>          
                                <a href="<?=domain;?>/user/bank-transfer/<?=$order->id;?>/advert_papers" class="dropdown-item" >
                                  Invoice
                                </a>
                              </li>
                              <!-- <li><a href="#">JavaScript</a></li> -->

                            </ul>
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
