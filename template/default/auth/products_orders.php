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


                <table id="myTable" class="table table-striped">
                     <?php $i=1; foreach ($orders as $order):?>
                      <tr>

                        <div class="alert bg-dark text-white  alert-dismissible mb-2 " role="alert">
                        <span style="margin-right: 7px;">
                             <?=$i++;?>)
                        </span>

                                <strong> Items x Qty: <?=$order->total_item();?> x <?=$order->total_qty();?></strong>
                                 <br>
                                <small>Price: </small><?=$currency;?><?=$this->money_format($order['amount_payable']);?><br>
                                <span class="float-"><?=date("M j Y h:ia" , strtotime($order->created_at));?> <?=$order->paymentstatus;?></span>
                            <div style="position: absolute;top: 10px;right: 25px;">
                            <?=$order->TransactionID;?>
                            <div class="dropdown">
                              <button type="button" class="btn btn-secondary  btn-sm dropdown-toggle" data-toggle="dropdown">
                                Actions
                              </button>
                              <div class="dropdown-menu">
                                <form id="payment_proof_form<?=$order->id;?>" action="<?=domain;?>/user/upload_payment_proof/<?=$order->id;?>/product" method="post" enctype="multipart/form-data">
                                    <input 
                                    style="display: none" 
                                    type="file" 
                                    onchange="document.getElementById('payment_proof_form<?=$order->id;?>').submit();" id="payment_proof_input<?=$order->id;?>"  
                                    name="payment_proof">

                                    <input type="hidden" name="order_id" value="<?=$order->id;?>">
                                </form>

                                    <a href="<?=domain;?>/user/product_order/<?=$order->id;?>" class="dropdown-item" >
                                        Open
                                    </a>

                                <?php if(! $order->is_paid()) :?>
                                


                                   <a href="javascript:void;" class="dropdown-item"  onclick="document.getElementById('payment_proof_input<?= $order->id;?>').click()" >
                                      Upload Proof
                                  </a>

                                
                                <?php else:?>
                                <!-- 
                                    <a href="<?=domain;?>/user/download_request/<?=$order->id;?>" class="dropdown-item" >
                                        Download
                                    </a> -->


                                <?php endif;?>                                             
                                <?php if ($order->payment_proof != null) : ?>
                                    <a class="dropdown-item" target="_blank"
                                    href="<?= domain; ?>/<?= $order->payment_proof; ?>">See Proof</a>
                                <?php endif; ?>


                                
                              </div>
                            </div>
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
