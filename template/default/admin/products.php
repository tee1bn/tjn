<?php
$page_title = "Products";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Products</h3>
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
              <h4 class="card-title">Products</h4>
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


                          <table id="myTable" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>#sn</th>
                                <th>Item</th>
                                <th>Price(<?=$currency;?>)</th>
                                <!-- <th>Scheme</th> -->
                                <th style="width:40%;">Description</th>
                                <th>Created</th>
                                <th>Action</th>
                              </tr>
                            </thead>

                            
                            <?php $i=1; foreach (Products::all() as $item) :

                            if ($item->is_on_sale()) {

                              $on_sale_status = 'Put off sale';
                              $label = 'info';
                            }else{

                              $on_sale_status = 'Put on sale';
                              $label = 'default';

                            }

                            ?>


                            <tr>
                              <td><?=$i;?></td>
                              <td style="text-transform: capitalize;"><?=$item->name;?> </td>
                              <td><?=($item->price);?></td>
                              <!-- <td><?=($item->scheme_attached->package_type);?></td> -->
                              <td>
                               <button class="btn-primary btn-sm btn" data-toggle="collapse" data-target="#de<?=$item['id'];?>">Description 
                                <span class="fa fa-caret"></span>
                              </button>

                              <div id="de<?=$item['id'];?>" class="collapse"
                                style="text-align: justify;">
                                <?=($item['description']);?>
                              </div>

                            </td>
                            <td>
                              <label type='label' class='label label-primary'>
                                <?=$item->created_at->toFormattedDateString();?>
                              </label>
                            </td>
                            <td>

                              




                              <div class="dropdown">
                                <button type="button" class="btn btn-secondary btn-xs dropdown-toggle" data-toggle="dropdown">
                                  Actions
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="<?=domain;?>/admin-products/edit_item/<?=$item->id;?>">Edit</a>
                                  <a class="dropdown-item" href="<?=domain;?>/admin-products/pausePlayProduct/<?=$item->id;?>"><?=$on_sale_status;?></a>                          
                                  <a class="dropdown-item" href="<?=domain;?>/admin/download_request/<?=$item->id;?>"> File Download Link </a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="$confirm_dialog = new ConfirmationDialog('<?=$item->deletelink;?>')">Delete</a>
                          
                        </div>
                      </div>

                    </td>
                  </tr>
                  
                  
                  <?php $i++; endforeach;?>
                  
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
