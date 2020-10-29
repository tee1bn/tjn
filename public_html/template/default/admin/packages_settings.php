<?php
$page_title = "Packages Settings";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Packages Settings</h3>
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
          <h4 class="card-title">Packages Settings</h4>
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
          


                            <form 
                              id="scheme_form"
                              class="ajax_form"
                              action="<?=domain;?>/admin/update_subscription_plans" method="post" >
                                <div class="card-body table-responsive">
                                    
                                    <table id="myTable" class="table table-striped">
                                        <thead>
                                          <tr>
                                            <th>SN</th>
                                            <th>Plan</th>
                                            <th>Price(<?=$currency;?>)</th>
                                            <th title="Amount on which Commission is calculated">Commission Price(<?=$currency;?>)</th>
                                            <th>VAT (%)</th>
                                            <th>Features <small class="text-danger">*separated commas</small></th>
                                            <th>Hierarchy</th>
                                            <th>Commission Level</th>
                                            <th>Get Pool</th>
                                            <th>Availability</th>
                                          </tr>
                                        </thead>
                                        <tbody>

                                            <?php $i=1; foreach (SubscriptionPlan::all() as $key => $plan) :?>

                                            <tr>
                                                <td>
                                                   <?=$i++;?>
                                                </td>
                                                <td>
                                                    <input type="" value="<?=$plan->package_type;?>"
                                                    name="plan[<?=$plan->id;?>][package_type]">
                                                </td>


                                       
                                                <td>
                                                    <input style="width: 55px;" type="number" step="0.01" value="<?=$plan->price;?>" name="plan[<?=$plan->id;?>][price]">
                                                </td>
                                       
                                                <td>
                                                    <input style="width: 55px;" type="number" step="0.01" value="<?=$plan->commission_price;?>" name="plan[<?=$plan->id;?>][commission_price]">
                                                </td>
                                       
                                                <td>
                                                    <input style="width: 55px;" type="number" step="0.01" value="<?=$plan->percent_vat;?>"
                                                     name="plan[<?=$plan->id;?>][percent_vat]">
                                                </td>

                                                <td>
                                                  <textarea name="plan[<?=$plan->id;?>][features]"><?=$plan->features;?></textarea>
<!--                                                     <input type="" value="<?=$plan->features;?>" name="plan[<?=$plan->id;?>][features]">
 -->                                                </td>
                                                <td>
                                                    <input style="width: 35px;"  type="number" value="<?=$plan->hierarchy;?>" name="plan[<?=$plan->id;?>][hierarchy]">
                                                </td>
                                             
                                                <td>
                                                    <input style="width: 35px;"  type="number" value="<?=$plan->downline_commission_level;?>" name="plan[<?=$plan->id;?>][downline_commission_level]">
                                                </td>
                                             
                                                <td>
                                                    <input style="width: 35px;" max="1" min="0" type="number" value="<?=$plan->get_pool;?>" name="plan[<?=$plan->id;?>][get_pool]">
                                                </td>
                                             
                                                <td>
                                                    <input type="checkbox" <?=($plan->is_available())? 'checked' :'';?> name="plan[<?=$plan->id;?>][availability]">
                                                </td>
                                            </tr>                                     
                                        
                                            <?php  endforeach ;?>
                                        </tbody>
                                      </table>

                                </div>                           

                                <div class="form-group text-center">
                                    <button class="btn btn-primary">Update</button>
                                </div>

                                
                            </form>





      </div>
    </div>
      </section>


    <!--   <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">blank</h4>
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
