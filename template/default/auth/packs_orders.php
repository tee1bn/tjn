<?php
$page_title = "Your Packs";
 include 'includes/header.php';
 ;?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Your Packs</h3>
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
          <h4 class="card-title">Your Packs</h4>
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
                                
                                <table id="myTable" class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>#Ref</th>
                                        <th>Plan</th>
                                        <th>Cost(<?=$currency;?>)</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach ($this->auth()->subscriptions as $order):
                                        $subscriber = $order->user;
                                        ?>
                                      <tr>
                                        <td><?=$order->id;?></td>
                                        <td><?=$order->plandetails['package_type'];?></td>
                                        <td><?=$this->money_format($order['price']);?></td>
                                        <td><span class="badge badge-primary"><?=$order->created_at->toFormattedDateString();?></span></td>
                                        <td><?=$order->paymentstatus;?></td>
                                        <td>
                                            <div class="dropdown">
                                              <a href="javascript:void;" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-circle"></i>
                                                <i class="fa fa-circle"></i>
                                                <i class="fa fa-circle"></i>
                                              </a>
                                              <div class="dropdown-menu">


                                                <a class="dropdown-item" target="_blank" href="<?=domain;?>/user/package_invoice/<?=$order->id;?>">Invoice</a>
                                                

                                                
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

    </div>
      </section>


    <!--   <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Package Orders</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
      </section> -->


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
