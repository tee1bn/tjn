<?php 
$page_title = 'Delivery';
$page_description = "";

include 'includes/header.php';?>


<div class="app-content container center-layout mt-2 ">
  <div class="content-wrapper">

    <div class="content-body">

      <div class="" >

        <div class="">
          <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
              <h3 class="content-header-title mb-0">Delivery</h3>

            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">

            </div>
          </div>
          <div class="content-body">
            <style>
              .courses-in-cart ul li{
                list-style-type: none;
              }

              .courses-in-cart{
                border: 1px solid #00000014;
                padding: 5px;
              }

              .form-group{
                margin-bottom: 2px !important;
              } 
            </style>
            <div id="content"  ng-controller="ShopController" ng-cloak>
              <div class="content-detached content-lef" >
                <div class="content-body">
                  <section class="row">
                    <div id="" class="card col-md-7">
                      <div class="card-header">
                        <h4 class="card-title">x Item(s)</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                      </div>


                      <div class="card-content collapse show">
                        <div class="card-body">
                          <div class="card-text">

                            <div ng-repeat="($index, $item) in $shop.$cart.$items" class="media courses-in-cart">
                               <div class="media-body">
                                <h4 class="media-heading"><b>{{$item.market_details.name}}</b></h4>
                                <span ng-bind-html = $item.market_details.short_description></span>
                              </div>
                              <ul>
                                <li class="text-danger"><a>34mb</a></li>
                                <li><h2><b><?=$currency;?>{{$item.market_details.price }}<i class="fa fa-tags"></i> </b></h2></li>
                              </ul>                                 

                                </div>
                                <hr />
                                <a href="" class="pull-right btn btn-outline-dark"> Download all</a><br>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class=" col-md-5" >
                          <div class=" card ">
                            <div class="card-body">
                              <h6>Summary</h6>


                                      </div>
                                    </div>

                                  </div>

                                </section>

                              </div>
                            </div>

                          </div>


                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>




              <?php include 'includes/footer.php';?>