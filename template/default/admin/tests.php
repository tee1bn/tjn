<?php
$page_title = "Tests";
include 'includes/header.php';
;?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Tests</h3>
      </div>

          <div class="content-header-right col-6">

      </div>
        </div>
        <div class="content-body">

          <section id="video-gallery" class="card">
            <div class="card-header">
              <h4 class="card-title">Sales <small>- simulate a sale</small></h4>
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

              <form action="<?=domain;?>/testing/create_sale" method="POST" class="ajax_for">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Username</label>
                    <select name="user_id" class="form-control">
                      <option value="">Select user</option>
                      <?php foreach (User::all() as $key => $user) :?>
                        <option value="<?=$user->id;?>"><?=$user->fullname;?> (<?=$user->username;?>) <?=$user->TheRank['name'];?></option>
                      <?php endforeach ;?>
                    </select>
                  </div>

                  <div class="form-group col-md-6">
                    <label>Amount</label>
                    <input type="" class="form-control" name="priced_amount">
                  </div>

                  
                  <div class="form-group col-md-6">
                    <label>Level</label>
                    <input type="" class="form-control" name="level">
                  </div>

                  
                  <div class="form-group col-md-12">

                    <button class="btn  btn-outline-dark ">Submit</button>
                  </div>

                  
                </div>
                
              </form>





            </div>

          </div>
        </section>



          <section id="video-gallery" class="card">
            <div class="card-header">
              <h4 class="card-title">Ranks <small>update a user rank</small></h4>
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


              <form action="<?=domain;?>/testing/change_user_rank" method="POST" class="ajax_for">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label>Username</label>
                    <select name="user_id" class="form-control">
                      <option value="">Select user</option>
                      <?php foreach (User::all() as $key => $user) :?>
                        <option value="<?=$user->id;?>"><?=$user->fullname;?> (<?=$user->username;?>) <?=$user->TheRank['name'];?></option>
                      <?php endforeach ;?>
                    </select>
                  </div>

                  <div class="form-group col-md-6">
                    <label>Rank</label>
                    <select name="rank" class="form-control">
                      <option value="">Select Rank</option>
                      <?php foreach ([1,2,3,4,5,6,7,8,9,10] as $key => $rank) :?>
                        <option value="<?=$key;?>"><?=$rank;?></option>
                      <?php endforeach ;?>
                    </select>
                  </div>

                  
                  <div class="form-group col-md-12">

                    <button class="btn  btn-outline-dark ">Submit</button>
                  </div>

                  
                </div>
                
              </form>






            </div>

          </div>
        </section>




      </div>
    </div>
  </div>
  <!-- END: Content-->

  <?php include 'includes/footer.php';?>
