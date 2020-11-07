<?php
$page_title = "Memebrship Orders";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Memebrship Orders</h3>
      </div>

    </div>
    <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">
          <?php include_once 'template/default/composed/filters/subscription_orders.php';?>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <ul class="list-inline mb-0">
              <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
              <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="card-content table-responsive">




          <table id="" class="table table-striped">
            <thead>
              <tr>
                <th>#Ref</th>
                <th>User</th>
                <th>Package</th>
                <th>Amount(<?=$currency;?>)</th>
                <th>Date<br>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($subscription_orders as $order):
                $subscriber = $order->user;
                ?>
                <tr>
                  <td><?=$order->TransactionID;?></td>
                  <td><?=$subscriber->DropSelfLink;?></td>
                  <td><?= $order->plandetails['name']; ?> - </td>
                  <td><?=$this->money_format($order['price']);?>
                  <td><span class="badge badge-primary"><?=date("M j Y h:iA",strtotime($order->created_at));?></span><br>
                    <?=$order->paymentstatus;?></td>
                  <td>
                    <div class="dropdown">
                      <a href="javascript:void;" class=" btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                      </a>
                      <div class="dropdown-menu">

                        <a  href="javascript:void;" class="dropdown-item" onclick="$confirm_dialog = 
                        new ConfirmationDialog('<?=domain;?>/admin/confirm_payment/<?=$order->id;?>')"
                        class="btn btn-primary btn-xs">
                        Confirm Payment              
                      </a>
                      <a class="dropdown-item" target="_blank" href="<?=domain;?>/admin/package_invoice/<?=$order->id;?>">Invoice</a>

                      <form id="payment_proof_form<?=$order->id;?>" action="<?=domain;?>/user/upload_payment_proof/<?=$order->id;?>" method="post" enctype="multipart/form-data">

                        <input 
                        style="display: none" 
                        type="file" 
                        onchange="document.getElementById('payment_proof_form<?=$order->id;?>').submit();" id="payment_proof_input<?=$order->id;?>"  
                        name="payment_proof">

                        <input type="hidden" name="order_id" value="<?=$order->id;?>">
                      </form>


<!--  <a href="javascript:void;" class="dropdown-item"  onclick="document.getElementById('payment_proof_input<?=$order->id;?>').click()" >
Upload Proof
</a> -->

<?php if($order->payment_proof !=null) :?>
  <a class="dropdown-item" target="_blank" href="<?=domain;?>/<?=$order->payment_proof;?>">See Proof</a>
<?php endif;?>


</div>
</div>
</td>
</tr>
<?php endforeach ;?>

</tbody>
</table>




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
