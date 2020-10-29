<?php
$page_title = "Support";
include 'includes/header.php';

;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
   
    <div class="content-body">

      <div class="app-content "  ng-controller="ShopController">

        <div class="content-wrapper">
          <div class="content-header row">
            <div class="content-header-left col-6 mb-2">
              <h3 class="content-header-title mb-0">Support</h3>
            </div>
            <div class="content-header-right text-right col-6">
                <a class="btn btn" href="<?=domain;?>/user/contact-us">+ Ticket</a>
            </div>
          </div>
          <div class="content-body">

            

            <div class="card">
             <div  class="card-content collapse show">
              <div class="card-body card-dashboard">

                
                <p class="card-text">List of Support Tickets - <?=$tickets->count();?></p>
                <table id="payment-histor" class="table table-striped table-bordered zero-configuration">
                 <tbody>

                   <?php foreach ($tickets as $key => $ticket):?>
                     <tr>
                       <td style="padding: 0px;">
                         <div class="col-md-12 custom-green" style="padding: 0px;">
                           <div class="alert custom-green  alert-dismissible mb-2" role="alert" style="margin:0px !important; ">
                            <small class="float-left">
                             <?=$ticket->displayStatus;?>
                             <?=date('M j, Y h:iA', strtotime($ticket->created_at));?>
                           </small>
                           <strong class="float-right">
                             <div class="dropdown">
                               <button type="button" class="btn btn-secondary  btn-sm dropdown-toggle" data-toggle="dropdown">
                                 Actions
                               </button>
                               <div class="dropdown-menu">
                                 <a class="dropdown-item" 
                                 href="<?=$ticket->UserLink;?>">Open </a>
                                 <?=$ticket->closeButton;?> 
                               </div>
                             </div>
                           </strong><br>
                           <strong>Ticket ID: <?=$ticket->code;?></strong>
                           
                           <br>
                           <small>Subject: 
                            <?=$ticket->subject_of_ticket;?>
                          </small>
                        </div>
                      </div>

                    </td>
                  </tr>
                <?php endforeach;?>
              </tbody>
              
            </table>


          </div>
        </div>
      </div>
      <ul class="pagination">
       <?= $this->pagination_links($data, $per_page);?>
     </ul>

   </div>
 </div>
</div>


</div>
</div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
