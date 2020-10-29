<?php
$page_title = "Merchant Packages";
 include 'includes/header.php';?>
  <?php
    use v2\Models\Withdrawal;

    ;?>




    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Merchant</h3>
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



            <div class="row grouped-multiple-statistics-card">
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row">

                      <?php foreach ($records ??[] as $licenseName => $licenseCount) :?>

                      <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                        <div class="d-flex align-items-start mb-sm-1 mb-xl-0 border-right-blue-grey border-right-lighten-5">
                          <span class="card-icon primary d-flex justify-content-center mr-3">
                            <div class="b-box">
                                <span class="d-box">
                                    <?=$licenseCount;?>
                                </span>
                            </div>
                          </span>

                          <div class="stats-amount mr-3">
                            <h3 class="heading-text text-bold-600"><?=$licenseName;?></h3>
                            <p class="sub-heading">Package</p>
                          </div>
                        </div>
                      </div>

                      <?php endforeach ;?>



                      <div class="col-lg-6 col-xl-3 col-sm-6 col-12">
                        <div class="d-flex align-items-start">
                          <span class="card-icon warning d-flex justify-content-center mr-3">

                            <div class="b-box">
                                <span class="d-box">
                                    <?=$response['meta']['total'];?>
                                </span>
                            </div>
                                </span>
                          <div class="stats-amount mr-3">
                            <h3 class="heading-text text-bold-600">Merchant Connections</h3>
                            <small>Total</small>
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>

           

          <div class="row">

  
            <div class=" col-md-12">
                        <div class="card" style="">
                            <div class="card-content">
                                <div class="card-body">
                                  <?php include_once 'template/default/composed/filters/merchant_packages.php';?>
                                      
                                    <h4 class="card-tile border-0" style="position: absolute;right: 35px;top: 20px;">
                                        <small class="float-right">
                                            <?=$note;?>

                                        </small>

                                    </h4>
                                    <hr>
                                    <div class="row table-responsive">

                                        <table class="table">
                                            <tr>
                                                <td></td>
                                                <td>Merchant ID</td>
                                                <td>Company name</td>
                                                <td>Package</td>
                                                <td>Phone</td>
                                                <td>Order date</td>
                                                <td>Status</td>
                                            </tr>
                                            <tbody>
                                              <?php $i=1; foreach ($result as $key => $merchant) :

                                                $status = in_array(strtolower($merchant['setupFeeState']), ['paid', 'active'])? 
                                                  '<span class="ft-check text-success fa-2x"></span>' :
                                                  '<span class="ft-x text-danger fa-2x"></span>' ;

                                              ?>
                                                <tr>
                                                    <td><?=$i++;?></td>
                                                    <td><?=$merchant['id'];?></td>
                                                    <td><?=$merchant['name'];?></td>
                                                    <td><?=$merchant['licenseName'];?></td>
                                                    <td><?=$merchant['phone'];?></td>
                                                    <td><?=date("d/m/Y", strtotime($merchant['createdAt']));?></td>
                                                    <td><?=$status;?></td>
                                                </tr>
                                              <?php endforeach  ;?>
                                            </tbody>
                                        </table>
                                     
                                        
                                    </div>

                                </div>
                            </div>
                        </div>

                    <ul class="pagination">
                        <?= $this->pagination_links($response['meta']['total'], $per_page);?>
                    </ul>
                    </div>



</div>


<div>
    <small> * * Due to data protection regulations only contacts data may be angzeigt of dealers which you have connected personally. 
</small>
</div>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>

