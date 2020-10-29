<?php
$page_title = "Packages";
include 'includes/header.php';
use v2\Models\InvestmentPackage;

;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6  mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Packages</h3>
      </div>

    <!--   <div class="content-header-right col-6">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
          <a class="btn btn-outline-primary" href="<?=domain;?>">
            + Create
          </a>
        </div>
      </div> -->
    </div>
    <div class="content-body">

      <?php $i=1; foreach (SubscriptionPlan::orderBy('hierarchy')->AvailableForAdmin()->get() as $key => $plan) :?>



      <div class="row" >
        <div class="col-12">
          <div class="card">
            <div class="card-header"  data-toggle="collapse" data-target="#plan<?=$plan->id;?>">
              <a href="javascript:void;" class="card-title">
                <span class="badge badge-secondary">
                  <?=$plan->hierarchy;?>
                </span>
                <?=$plan->package_type;?></a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                  </ul>
                </div>

              </div>
              <div class="card-body row collapse show" id="plan<?=$plan->id;?>">

                <form class="col-12 ajax_form" method="POST" action="<?=domain;?>/admin/update_account_plans">

                  <div class="row">

                    <div class="form-group col-md-4">
                      <label>Package Type </label>
                      <input type="" name="package_type" required="" value="<?=$plan->package_type;?>" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label>Price </label>
                      <input type="number" step="0.01" name="price" required="" value="<?=$plan->price;?>" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label>Commission Price </label>
                      <input type="number" step="0.01" name="commission_price" required="" value="<?=$plan->commission_price;?>" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label>Vat (%) </label>
                      <input type="number" step="0.01" name="percent_vat" required="" value="<?=$plan->percent_vat;?>" class="form-control">
                    </div>

                    <div class="form-group col-md-2">
                      <label>Commission Level  </label>
                      <input type="number" step="1" name="downline_commission_level" required="" value="<?=$plan->downline_commission_level;?>" class="form-control">
                    </div>
                    
                    <div class="form-group col-md-2">
                      <label>Get Pool</label>
                      <input type="number" step="1" name="get_pool" required="" value="<?=$plan->get_pool;?>" class="form-control">
                    </div>
                    
                    

                    <div class="form-group col-md-2">
                      <label>Hierarchy </label>
                      <input type="" name="hierarchy" required="" value="<?=$plan->hierarchy;?>" class="form-control">
                    </div>

                    <input type="hidden" name="id" value="<?=$plan->id;?>">


                    <div class="form-group col-md-2">
                      <label>
                      <br>Available <br>
                      <input type="checkbox" <?=($plan->is_available())? 'checked' :'';?> name="availability">
                      </label><br>
                    </div>

                    <?php foreach (SubscriptionPlan::$benefits as $key => $benefit):?>

                    <div class="form-group col-md-2">
                      <label><br><?=$benefit['title'];?><br>
                      <input type="checkbox" <?=(@$plan->DetailsArray['benefits'][$key] == 1)? 'checked' :'';?>
                       value="1" name="details[benefits][<?=$key;?>]" >
                      </label><br>
                    </div>
                    <?php endforeach;?>



                

                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-success">Save</button>
                  </div>

                </form>

              </div>

            </div>
          </div>
        </div>

        <?php $i++; endforeach;?>



      </div>
    </div>
  </div>
  <!-- END: Content-->

  <?php include 'includes/footer.php';?>
