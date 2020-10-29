<?php
$page_title = "Simulate Packages";
include 'includes/header.php';
use v2\Models\InvestmentPackage;

;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Simulate Packages</h3>
      </div>

    </div>
    <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Simulate Packages</h4>
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


            <datalist id="usernames">
            </datalist>

            <form method="post" id="simulate_packages" class="ajax_for" action="<?=domain;?>/package_crud/submit_simulate_packages">
              <div class="row">

                <div class="form-group col-md-6">
                  <label>Package</label>
                  <select class="form-control" required="" name="investment_id">
                    <option value="">Select Package</option>
                    <?php foreach (InvestmentPackage::available()->get() as  $investment) :?>
                    <option value="<?=$investment->id;?>"><?=$investment->name;?>: 
                      <?=$currency;?><?=MIS::money_format($investment->DetailsArray['min_capital']);?> -
                                <?=MIS::money_format($investment->DetailsArray['max_capital']);?>
                    </option>
                  <?php endforeach;?>

                </select>
              </div>

                <div class="form-group col-md-6">
                  <label>Amount</label>
                  <input type="number" step="0.01" min="0"  name="amount" class="form-control" required="">
                </div>

                <div class="form-group col-md-6">
                  <label>Username</label>
                  <input type="" name="username" list="usernames" class="form-control" required="" onkeyup ="populate_option(this.value)">
                </div>

              <div class="form-group col-md-6">
                <label>Value Date</label>
                <input type="date" name="paid_at" required=""  class="form-control" required="">
              </div>

              <!-- <div class="form-group col-md-12">
                <label>Comment</label
                <textarea class="form-control" required="" name="comment" rows="3" name=""></textarea>
              </div> -->


              <div class="form-group col-md-12">

                <button type="button" class="btn btn-outline-primary" onclick="$confirm_dialog=new DialogJS(submit_form, [], 'Are you sure you want to continue? This action is not reversible.')">Submit</button>
              </div>

            </div>


          </form>

          <script>
            submit_form = function(){
              $('#simulate_packages').submit();
            }

            populate_option = function($query){

              console.log($query.length);

              if ($query.length < 3) {return;}

              $.ajax({
                type: "POST",
                url: "<?=domain;?>/admin/search/"+$query,
                data: null,
                success: function(data) {

                  $('#usernames').html(data.line);
                  console.log(data);
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
