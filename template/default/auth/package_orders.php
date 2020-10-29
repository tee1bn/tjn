<?php
$page_title = "My Invoices";
include 'includes/header.php';; ?>


<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <?php include 'includes/breadcrumb.php'; ?>

                <h3 class="content-header-title mb-0">My Invoices</h3>
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

                <?php include_once 'template/default/composed/filters/auth_subscription_orders.php';?>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                   <small class="float-right">Showing <?=$subscription_orders->count();?> of <?=$data;?> </small>

               </div>
           </div>
           <div class="card-content">


            <div class="card-body table-responsive">

                <table id="myTble" class="table table-striped">
                    <thead>
                        <tr>
                            <th>#Ref</th>
                            <th>OrderID</th>
                            <th>Package -Month</th>
                            <th>Amount(<?= $currency; ?>)</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subscription_orders as $order):
                            $subscriber = $order->user;
                            ?>
                            <tr>
                                <td><?= $order->id; ?></td>
                                <td><?= $order->TransactionID; ?></td>
                                <td><?= $order->plandetails['package_type']; ?> - <?=$order->no_of_month;?> </td>
                                <td><?= $this->money_format($order['price']); ?></td>
                                <td>
                                    <span class="badge badge-primary"><?= $order->created_at->toFormattedDateString(); ?></span>
                                </td>
                                <td><?= $order->paymentstatus; ?></td>
                                <td>
                                    <div class="dropdown">
                                        <a href="javascript:void;" class="btn btn-sm btn-outline-dark dropdown-toggle" data-toggle="dropdown">
                                        </a>
                                        <div class="dropdown-menu">


                                            <a class="dropdown-item" target="_blank"
                                            href="<?= domain; ?>/user/package_invoice/<?= $order->id; ?>">Invoice</a>


                                            <form id="payment_proof_form<?= $order->id; ?>"
                                              action="<?= domain; ?>/user/upload_payment_proof/<?= $order->id; ?>"
                                              method="post" enctype="multipart/form-data">

                                              <input
                                              style="display: none"
                                              type="file"
                                              onchange="document.getElementById('payment_proof_form<?= $order->id; ?>').submit();"
                                              id="payment_proof_input<?= $order->id; ?>"
                                              name="payment_proof">

                                              <input type="hidden" name="order_id" value="<?= $order->id; ?>">
                                          </form>




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
                                    </td>
                                </tr>
                            <?php endforeach; ?>

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

<?php include 'includes/footer.php'; ?>


