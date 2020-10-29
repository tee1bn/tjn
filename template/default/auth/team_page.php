<?php
$upline = User::where('mlm_id',$user->referred_by)->first();
$page_title = "Overview Team";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Overview Team</h3>
          </div>
          
        </div>

        <style>
          .team-leader{

            height: 100px;
            border-radius: 46px;
            width: 100px;
            object-fit: cover;
          }
        </style>


        <div class="content-body">
          <?php require_once 'template/default/auth/includes/team_page.php';?>
         
              <div class="row">

               <div class="col-md-4">

                <div class="dropdown">
                  <button class="btn btn-dark btn-block  dropdown-toggle" type="button" data-toggle="dropdown"> 
                    Lifeline Level <span class="badge badge-secondary"> <?=$level_of_referral;?> </span>
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu">
                   <?php for ($i=1; $i <=3 ; $i++):?>
                        <li>
                          <a class="dropdown-item" href="<?=domain;?>/genealogy/placement_list/<?=$user->username;?>/<?=$i;?>">
                          Level <?=$i;?>
                          </a>
                        </li>
                   <?php endfor;?>
                  </ul>
                </div>

               
             </div>

               <div class="col-md-8">
                     <div class="card" >
                         <div class="card-content">
                             <div class="card-body" style="
    padding: 7px !important;
    padding-bottom: 5px!important;
    padding-top: 10px!important;">
                                  <label>
                                    
                                    <input type="checkbox" name="" style="
    height: 20px;
    width: 20px;
    position: absolute;
    top: 11px;">
                                     <span style="margin-left: 20px;">share my personal information (name, email, phone) for the entire Upline</span>
                                  </label>
                                
                         </div>
                 </div>
                   
               </div>
               
             </div>
               <div class="col-md-12">
                   <div class="form-group col-md-3">
                     <input type="" class="form-control" placeholder="Search for sales partner ID" name="">
                   </div>
               
             </div>


<style>
  
  td{
    padding-right: 1px !important;
    padding-left: 1px !important;
    text-align: center;
  }
</style>
               <div class="col-md-12">
                     <div class="card" >
                         <div class="card-content">
                             <div class="card-body table-responsive">
                                <table class="table">
                                                 <tr>
                                                   <td style="width: 5%;">Sn</td>
                                                   <td>Partner ID</td>
                                                   <td>Surname</td>
                                                   <td>Level</td>
                                                   <td>E-mail</td>
                                                   <td>Phone</td>
                                                   <td>Registered</td>
                                                   <td>Direct <br>sales partner</td>
                                                   <td>Own <br>Merchants</td>
                                                   <td>Status</td>
                                                 </tr>
                                                 <tbody>
                                                   <tr>
                                                     <td>1</td>
                                                     <td>12</td>
                                                     <td>opeifa</td>
                                                     <td>3</td>
                                                     <td>32@gmail.com</td>
                                                     <td>08323323232</td>
                                                     <td>4/12/3233</td>
                                                     <td>3</td>
                                                     <td>32</td>
                                                     <td>active</td>
                                                   </tr>
                                                   <tr>
                                                     <td>1</td>
                                                     <td colspan="6"><b>Total</b></td>
                                                     <td>3</td>
                                                     <td>32</td>
                                                     <td>active</td>
                                                   </tr>
                                                 </tbody>
                                                   
                                                </table>
                         </div>
                 </div>
                   
               </div>
               
             </div>

               <div class="col-md-12">
                
                <small class="text-muted">* * * Due to data protection regulations only contacts data may be viewed by direct distributors. Ausnamhe: Distributors have shared that their contact information for the upline</small>
               
             </div>
             

           </div>




        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
