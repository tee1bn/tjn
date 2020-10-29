<?php
$page_title = "My Team Tree";
include 'includes/header.php';

$user   =  User::find($user_id);
@$upline = $user->referred_members_uplines(1, $tree_key)[1];
$max_uplevel = $user->max_uplevel('placement')['max_level'];

$auth_user = $auth;
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">My Team tree</h3>
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



    <style>

      td{
        padding-right: 1px !important;
        padding-left: 1px !important;
        text-align: center;
    }
</style>

<div class="col-md-12">



    <datalist id="my_downlines">
      <option value=""></option>
    </datalist>

   
   <section id="video-gallery" class="card">
     <div class="card-header">

         <form action="<?=domain;?>/genealogy/showout" method="post" style="display: none; ">
       <div class="input-group col-md-4 col-8">
           <input type="text"  class="form-control" name="username" onkeyup="populate_option(this.value)" list="my_downlines"  
           placeholder="Search your downline & select from the predictions " aria-describedby="button-addon2">
           <input type="hidden" name="tree_key" value="<?=$tree_key;?>">
           <div class="input-group-append" id="button-addon2">
             <button class="btn btn-outline-dark" style="" type="submit">Go</button>
           </div>
       </div>
         </form>


  

       <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
       <div class="heading-elements">
         <div class="dropdown">
           <span type="span" style="cursor: pointer;" class="dropdown-toggle" data-toggle="dropdown">
             Filters
           </span>
           <div class="dropdown-menu">
             <a class="dropdown-item " href="<?=domain;?>/genealogy/team_tree/<?=$auth->username;?>/binary/2"> 
               <i class="fa fa-sitemap "></i> My Genealogy </a>
          <!--    <a class="dropdown-item " href="<?=domain;?>/genealogy/last/0/<?=$tree_key;?>"> <i class=" ft-chevrons-left"></i> Last Left</a>
             <a class="dropdown-item " href="<?=domain;?>/genealogy/last/1/<?=$tree_key;?>"><i class=" ft-chevrons-right"></i>Last Right</a> -->
             <span  id="gfilter" class="dropdown-item"  class="text-center">

               <!-- <i class="ft-corner-left-up" ></i> -->
               <!-- <label class="">Level up</label> -->
              <form action="<?=domain;?>/genealogy/up" method="post">
                 <div class="input-group col-12" style="padding: 0px;">
                     <input type="number" min="0"  max="<?=$max_uplevel;?>" required="" class="form-control form-control" 
                     name="level_up" placeholder="x-level up" aria-describedby="button-addon2">
                     <input type="hidden" name="tree_key" value="<?=$tree_key;?>">
                     <input type="hidden" name="user_id" value="<?=$user_id;?>">
                     <div class="input-group-append" id="button-addon2">
                       <button class="btn btn btn-outline-dark" type="submit">Up</button>
                     </div>
                 </div>
             </form>

              <form action="?" method="get">
               <label class="">Month</label>
                 <div class="input-group col-12" style="padding: 0px;">
                     <input type="month" value="<?=$_GET['month']??'';?>"  required="" class="form-control form-control" 
                     name="month" placeholder="Month" aria-describedby="button-addon2">
                     <div class="input-group-append" id="button-addon2">
                       <button class="btn btn btn-outline-dark" type="submit">Go</button>
                     </div>
                 </div>
                </form>
             </span>
           </div>
         </div>            
       </div>
     </div>


     <?php 

        $box_colors = array_values(SubscriptionPlan::$colors);

     ;?>


     <div class="card-content">
       <div class="card-body">
            <div class="" style="display:inline;">
                 <ol>
                   <li style="display: inline; margin-right: 3px;"><i class="fa fa-stop" style="color:<?=$box_colors[0];?>"></i> Basic
                   </li>
                   <li style="display: inline; margin-right: 3px;"><i class="fa fa-stop" style="color:<?=$box_colors[1];?>"></i> Advanced
                   </li>
                   <li style="display: inline; margin-right: 3px;"><i class="fa fa-stop" style="color:<?=$box_colors[2];?>"></i> Professional
                   </li>
                   <li style="display: inline; margin-right: 3px;margin-left: 3px;"> 
                    <i class="fa fa-check-circle text-success"> </i><i class="fa fa-times-circle text-danger"> </i>
                    Order Status: active / inactive
                   </li>
                 </ol>
             </div>

         <!-- <center  style="overflow-x: scroll; overflow-y: none; height: auto;"> -->
    
         <center style="overflow-x: scroll;">
           <ul class="tree" id="tree" style="width:100%;min-height:300px; ">
           </ul>
         </center>




         <style>
           
           .dropdown-toggle-no-after::after {
              content: none !important;
           }
         </style>

         <?php
            $month = $_GET['month'] ?? '';
         ;?>

         <script>
           $('.dropdown-menu').click(function(e) {
               e.stopPropagation();
           });



           $.ajax({
             type: "POST",
             url: $base_url+"/genealogy/fetch/<?=$user_id;?>/<?=$tree_key;?>/3?month=<?=$month;?>",
             data: null,
                 contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                 processData: false, // NEEDED, DON'T OMIT THIS
                 cache: false,
                 success: function(data) {
                   $("#tree").html(data.list);
                 },
                 error: function (data) {},
                 complete: function(){}
               });



           populate_option = function($query){

             // if ($query.length < 2) {return;}

             $.ajax({
                 type: "POST",
                 url: "<?=domain;?>/genealogy/search/"+$query+"/<?=$tree_key;?>",
                 data: null,
                 success: function(data) {

                     $('#my_downlines').html(data.line);
                 },
                 error: function (data) {
                 },
                 complete: function(){}
             });


           }


         </script>

       </div>
     </div>
   </section>




</div>



<!-- //TOD dupliacte this table for merchants
 --><div class="col-md-12">
   <div class="card" >
       <div class="card-content">
           <div class="card-body ">
            <div class="table-responsive">
                <table class="table table-sm">
                   <tr>
                     <td>Sales Partner ID:<?=$user->id;?></td>
                     <?php foreach ($dates as $key => $date):?>
                         <td><?=date("F Y", strtotime($date));?> </td>
                     <?php endforeach ;?>
                 </tr>
                 <tbody>
                     <tr>
                         <td>Own Merchants new</td>
                       <?php foreach ($dates as $key => $date):?>
                           <td><?=isset($own_merchants[$date]) ? $own_merchants[$date]->count() : 0;?> </td>
                       <?php endforeach ;?>

                       

                     </tr>
                     <tr>
                         <td>Merchants total</td>
                           <?php foreach ($dates as $key => $date):?>
                               <td><?=isset($total_merchants[$date]) ? $total_merchants[$date]->count() : 0;?> </td>
                           <?php endforeach ;?>
                     </tr>


                     <tr>
                         <td>Direct sales partner new</td>
                       <?php foreach ($dates as $key => $date):?>
                           <td><?=$direct_sales_agent[$date]['total'] ?? 0;?>/<?=$direct_sales_agent_and_active[$date]['total']??0;?> </td>
                       <?php endforeach ;?>

                       

                     </tr>
                     <tr>
                         <td>Sales Partner total</td>
                           <?php foreach ($dates as $key => $date):?>
                               <td><?=$sales_agent[$date]['total'] ?? 0;?> </td>
                           <?php endforeach ;?>
                     </tr>



                 </tbody>

             </table>
         </div>
     </div>
 </div>

</div>

</div>



<!-- //TOD dupliacte this table for merchants
 --><!-- 
 <div class="col-md-12">
   <div class="card" >
       <div class="card-content">
           <div class="card-body ">
            <div class="table-responsive">
                <table class="table table-sm">
                   <tr>
                     <td>Sales Partner ID:<?=$user->id;?></td>
                     <?php foreach ($dates as $key => $date):?>
                         <td><?=date("F Y", strtotime($date));?> </td>
                     <?php endforeach ;?>
                 </tr>
                 <tbody>
                     <tr>
                         <td>Direct sales partner new</td>
                       <?php foreach ($dates as $key => $date):?>
                           <td><?=$direct_sales_agent[$date]['total'] ?? 0;?> </td>
                       <?php endforeach ;?>

                       

                     </tr>
                     <tr>
                         <td>Sales Partner total</td>
                           <?php foreach ($dates as $key => $date):?>
                               <td><?=$sales_agent[$date]['total'] ?? 0;?> </td>
                           <?php endforeach ;?>
                     </tr>
                 </tbody>

             </table>
         </div>
     </div>
 </div>

</div>

</div> -->


</div>


<div class="row match-height"> 

  <?php

     $isp_silver = $auth->isp_silver(10);
     $silber2 = $auth->isp_silver2();
     $gold_tab = $auth->isp_gold();





  ;?>

<div class=" col-md-6">
   <div class="card" style="">
       <div class="card-content">
           <div class="card-body">
            <h4 class="card-tile border-0">Sales Partner ID: <?=$auth_user->id;?> </h4>
               <hr>
               <div class="row">

                   <div class="col-md-12">


                       <ul class="list-group list-group-flush">
                           <li class="list-group-item small-padding">

                               <div class="row">

                                   <span class="col-6">
                                      Number NSW Silver-Coins Incenvite: 
                                  </span>
                                  <span class="col-6">
                                   <?=$isp_silver['fa'];?>  <!-- with payout entitlement -->
                               </span>
                           </div>


                       </li>

                       <li class="list-group-item small-padding">

                           <div class="row">

                               <span class="col-6">
                                  Number NSW Silver -Coins: 
                              </span>
                              <span class="col-6">
                                <?=$silber2['direct_sales_partner_required'];?>/<?=$silber2['direct_sales_partner_count'];?>  with payout entitlement
                           </span>
                       </div>


                   </li>
                   <li class="list-group-item small-padding">

                       <div class="row">

                           <span class="col-6">
                              Number NSW Gold-Coins: 
                          </span>
                          <span class="col-6">
                              <?=$gold_tab['direct_sales_partner_required'];?>/<?=$gold_tab['direct_sales_partner_count'];?>  with payout entitlement
                       </span>
                   </div>


               </li>


           </ul>

       </div>


   </div>

</div>
</div>
</div>
</div>



<div class=" col-md-6">
   <div class="card" style="">
       <div class="card-content">
           <div class="card-body">
               <h4 class="card-tile border-0"><?=$auth_user->fullname;?>, ID:<?=$auth_user->id;?></h4>
               <hr>
               <div class="row">

                   <div class="col-md-12">


                       <ul class="list-group list-group-flush">
                           <li class="list-group-item small-padding">

                               <div class="row">

                                   <span class="col-6">
                                      First name: <?=$auth_user->firstname;?>
                                  </span>
                                  <span class="col-6">
                                   E-mail: <?=$auth_user->email;?>
                               </span>
                           </div>


                       </li>

                       <li class="list-group-item small-padding">

                           <div class="row">

                               <span class="col-6">
                                  Surname: <?=$auth_user->lastname;?>
                              </span>
                              <span class="col-6">
                            Phone: <?=$auth_user->phone;?>
                           </span>
                       </div>


                   </li>
                  

            </ul>

        </div>


    </div>

</div>
</div>
</div>
</div>


</div>

<div class="col-md-12">

    <small class="text-muted">* * * Due to data protection regulations only contacts data or names can be viewed by direct distributors. Exception: distributors have released what their contact details for the upline.</small>

</div>




</div>
</div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
