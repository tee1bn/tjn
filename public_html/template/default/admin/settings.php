<?php
$page_title = "Settings";
 include 'includes/header.php';?>

    <script src="<?=general_asset;?>/js/angulars/admin_settings.js"></script>



    <!-- BEGIN: Content-->
    <div ng-controller="Settings" ng-cloak class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Settings</h3>
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

             <div class="row" >
                <div class="col-12">
                    <div class="card">

                        <div class="card-header"  data-toggle="collapse" data-target="#payment_gateway_settings">
                          <a href="javascript:void;" class="card-title">Payment Gateways Settings</a>
                           <div class="heading-elements">
                              <ul class="list-inline mb-0">
                                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                  <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                              </ul>
                            </div>
                        </div>
                        <div class="card-body row collapse " id="payment_gateway_settings">

                               <div class="col-12" ng-repeat =" ($index , $gateway) in $payment_gateway_settings">
                                   <div class="card card-bordered" >

                                       <div class="card-header"  data-toggle="collapse" data-target="#payment_gateway_settings{{$index}}">
                                         <a href="javascript:void;" class="card-title">{{$gateway.name}}</a>
                                          <div class="heading-elements">
                                             <ul class="list-inline mb-0">
                                                 <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                 <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                             </ul>
                                           </div>
                                       </div>
                                       <div class="card-body row collapse " id="payment_gateway_settings{{$index}}">


                                            
                                            <div class="col-6" ng-repeat =" (key , $setting) in $gateway.json_settings">
                                                <div class="card">

                                                    <div class="card-header"  data-toggle="collapse" data-target="#gateway_settings{{$index}}">
                                                      <a href="javascript:void;" class="card-title">{{key}}</a>
                                                    </div>
                                                    <div class="card-body row collapse show " id="gateway_settings{{$index}}">


                                                        <div class="form-group col-md-12" ng-repeat="(key, $input) in $setting" ng-init="kkey = key">
                                                          <label> {{kkey}} </label>
                                                          <input  type="" ng-model="$setting[key]" class="form-control" name="">
                                                        </div>                                                    
                                                  

                                                     </div>

                                                </div>
                                            </div>

                                            <form class="col-md-12 ajax_form" method="post" action="<?=domain;?>/settings/update_payment_settings">

                                              <input type="" style="display:none;" name="criteria" value="{{$gateway.criteria}}" >
                                              <textarea style="display: none;" class="form-control" name="settings">{{$gateway}}</textarea>

                                              <button class="form-control btn-success">Update</button>

                                            </form>
  
                                        </div>


                                   </div>
                               </div>


                            
                      

                         </div>

                    </div>
                </div>
              </div>



              <div class="row" >
                 <div class="col-12">
                     <div class="card">

                         <div class="card-header"  data-toggle="collapse" data-target="#tax_settings">
                           <a href="javascript:void;" class="card-title">Tax Settings</a>
                         </div>
                         <div class="card-body row collapse " id="tax_settings">

                                <div class="col-12" ng-repeat =" ($index , $gateway) in $tax_settings">
                                    <div class="card card-bordered" >

                                        <div class="card-header"  data-toggle="collapse" data-target="#taxx_settings{{$index}}">
                                          <a href="javascript:void;" class="card-title">{{$gateway.name}}</a>
                                        </div>
                                        <div class="card-body row collapse " id="taxx_settings{{$index}}">
                                             
                                             <div class="col-6" ng-repeat =" (key , $setting) in $gateway.json_settings">
                                                 <div class="card">

                                                     <div class="card-header"  data-toggle="collapse" data-target="#taxxx{{$index}}">
                                                       <a href="javascript:void;" class="card-title">{{key}}</a>
                                                     </div>
                                                     <div class="card-body row collapse show " id="taxxx{{$index}}">


                                                         <div class="form-group col-md-12" ng-repeat="(key, $input) in $setting" ng-init="kkey = key">
                                                           <label> {{kkey}} </label>
                                                           <input  type="" ng-model="$setting[key]" class="form-control" name="">
                                                         </div>                                                    
                                                   

                                                      </div>

                                                 </div>
                                             </div>

                                             <form class="col-md-12 ajax_form" method="post" action="<?=domain;?>/settings/update_payment_settings">

                                               <input type="" style="display:none;" name="criteria" value="{{$gateway.criteria}}" >
                                               <textarea style="display: none;" class="form-control" name="settings">{{$gateway}}</textarea>

                                               <button class="form-control btn-success">Update</button>

                                             </form>
              
                                         </div>


                                    </div>
                                </div>
                          </div>
                     </div>
                 </div>
               </div>






                 <div class="row" >
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header"  data-toggle="collapse" data-target="#demo">
                                <a href="javascript:void;" class="card-title">Settings</a>
                                 <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                       </div>

                            </div>
                            <div class="card-body row collapse" id="demo">

                                <div ng-repeat="($key, $setting) in $site_settings" class="form-group col-md-6">
                                    <span class="badge badge-secondary">{{$index+1}}</span>
                                    <label>{{$key |replace: '_':' '}}</label>
                                    <input type="" placeholder="{{$key}}" ng-model="$site_settings[$key]" class="form-control">
                                </div>                              



                              <form action="<?=domain;?>/settings/update_site_settings" method="post" class="ajax_form" id="site_settings_form">

                                <textarea style="display: none;" name="content">{{$site_settings}}</textarea>

                                              
                                <div class="text-center col-12">
                                    <button ng-show="$site_settings.length != 0" class="btn btn-success" type="submit">Update 
                                        </button>
                                </div>
                              </form>

                             </div>

                        </div>
                    </div>
                </div>

            

        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
