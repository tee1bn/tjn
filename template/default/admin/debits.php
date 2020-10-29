<?php
$page_title = "Withdrawals";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Withdrawals</h3>
          </div>
          
          <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              
              <a class="btn btn-outline-primary">Total: <?=$currency;?> <?=MIS::money_format($inflows_total);?></a>
            </div>
          </div>
        </div>
        <div class="content-body">

 <div class="row">
                            <span class="col-md-5">From
                                    <input type="date" name=""  value="<?=$from;?>" onchange="$start_date=this.value" class="form-control">
                                </span> 
                                <span class="col-md-5">To
                                    <input type="date" name=""   value="<?=$to;?>"  onchange="$end_date=this.value" class="form-control">
                                </span> 
                                 <span class="col-md-2">&nbsp;
                                    <button class="form-control" 
                                    onclick="window.location.href = '<?=domain;?>/admin/debits/'+$start_date+'/'+$end_date;">Sort
                                </button>
                                </span>
                        </div>        




      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Withdrawals</h4>
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
                                    <thead>
                                      <tr>
                                        <th>#Ref</th>
                                        <th>User</th>
                                        <th>Amount(<?=$currency;?>)</th>
                                        <th>Remark</th>
                                        <th>Date</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach ($debits as $debit):?>
                                      <tr>
                                        <td><?=$debit->id;?></td>
                                        <td><?=$debit->owned_by->DropSelfLink;?></td>
                                        <td><?=$this->money_format($debit['amount_earned']);?></td>
                                        <td>
                                            <?=$debit->commission_type;?>

                                            <br>
                                            <small>
                                                <?=$debit->extra_detail;?>
                                                
                                            </small>
                                            
                                        </td>
                                        <td><span class="badge badge-primary"><?=$debit->created_at->toFormattedDateString();?></span></td>
                                      
                                      </tr>
                                    <?php endforeach ;?>
                                    
                                    </tbody>
                                  </table>
                            </div>      </div>
    </div>
      </section>



        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
