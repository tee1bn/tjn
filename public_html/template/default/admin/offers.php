<?php
$page_title = "Offers";
 include 'includes/header.php';

 use v2\Models\Offer;


 ;?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Offers</h3>
          </div>
          
          <div class="content-header-right col-6 ">
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
              <a class="btn btn-outline-primary" href="<?=Offer::create_offer();?>"><i class="ft-plus"></i> Offer</a>
              <a class="btn btn-outline-primary" href="<?=domain;?>/admin/offers">All Offers</a>
            </div>
          </div>
        </div>
        <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">

          <div class="dropdown" style="display: inline;">
            <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-filter"></i>
            </button>
              <div class="dropdown-menu">

            </div>
          </div>

          <h4 class="card-title" style="display: inline;">Offers</h4>


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

              <table class="table">
                <thead>
                  <th>Sn</th>
                  <th>Name <br>Context</th>
                  <th>Details</th>
                  <th>Lists</th>
                  <th>Status<br>Date</th>
                  <th>Action</th>
                </thead>
                <tbody>
                  <?php $i=1; foreach ($offers as $key => $offer) :?>

                  <tr>
                    <td><?=$i++;?></td>
                    <td><?=$offer->name;?><br><?=$offer->context;?></td>
                    <td>
                        <ul>
                      <?php foreach ($offer->DetailsArray as $key => $detail) :?>
                          <li>
                              <?=($key);?>: <?=($detail);?>
                          </li>

                      <?php endforeach ;?>
                        </ul>
                    </td>
                    <td><?=implode(",<br>", $offer->ListsArray);?></td>
                    <td><?=$offer->AvailableStatus;?><br>
                      <span class="badge badge-dark"><?=date("Y-m-d H:ia", strtotime($offer->created_at));?></span>
                    </td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                          
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" target="_blank" href="<?=$offer->EditUrl;?>">
                              <span type='span' class='label label-xs label-primary'>Edit</span>
                            </a>

                              <a  class="dropdown-item"  href="javascript:void;"  onclick="$confirm_dialog = 
                                new ConfirmationDialog('<?=domain;?>/delete_offer/<?=$user->id;?>')">
                                        <span type='span' class='label label-xs label-primary'>Delete </span>
                                      </a>



                        </div>
                      </div>


                    </td>
                  </tr>

                <?php endforeach;?>
                </tbody>
              </table>

              
          </div>
        </div>
      </section>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
