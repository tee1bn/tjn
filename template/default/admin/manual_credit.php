<?php
$page_title = "Manual Credits";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Manual Credits</h3>
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
              <h4 class="card-title">Manual Credits</h4>
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

                <form method="post" id="submit_manual_credit" action="<?=domain;?>/admin/submit_manual_credit">
                  <div class="row">

                    <div class="form-group col-md-6">
                      <label>Amount</label>
                      <input type="number" step="0.01" min="0"  name="amount" class="form-control" required="">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Username</label>
                      <input type="" name="username" list="usernames" class="form-control" required="" onkeyup ="populate_option(this.value)">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Category</label>
                      <select class="form-control" required="" name="category">
                        <option value="">Select Bonus</option>
                        <option value="speaker_bonus">Speaker Bonus</option>
                        <option value="office_bonus">Office Bonus</option>
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Value Date</label>
                      <input type="date" name="paid_at" required=""  class="form-control" required="">
                    </div>

                    <div class="form-group col-md-6">
                      <label>Comment</label>
                      <textarea class="form-control" required="" name="comment" rows="3" name=""></textarea>
                    </div>


                    <div class="form-group col-md-12">

                      <button type="button" class="btn btn-outline-primary" onclick="$confirm_dialog=new DialogJS(submit_form, [], 'Are you sure you want to continue? This action is not reversible.')">Submit</button>
                    </div>

                  </div>


                </form>

                <script>
                  submit_form = function(){
                    $('#submit_manual_credit').submit();
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
