<?php
$page_title = "Settings";
include 'includes/header.php';?>

<script type="text/javascript" src="<?=$this_folder;?>/angularjs/settings.js"></script>
<script src="<?=asset;?>/angulars/admin_settings.js"></script>



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

         <div class="row" style="display: ;">
          <div class="col-12">
            <div class="card">

              <div style="" class="card-header"  data-toggle="collapse" data-target="#payment_gateway_settings">
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

            <div class="card-header"  data-toggle="collapse" data-target="#demo">
              <a href="javascript:void;" class="card-title">General Settings</a>
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



      <div class="row" >
        <div class="col-12">
          <div class="card">

            <div class="card-header"  data-toggle="collapse" data-target="#BonusSettings">
              <a href="javascript:void;" class="card-title">The Matrix Settings- On Sales Partner</a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                  <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
              </div>

            </div>
            <div class="card-body row collapse" id="BonusSettings">
              <div class="col-12">


                <div class="card">

                  <div class="card-header"  data-toggle="collapse" data-target="#matrix_table_1">
                    <a href="javascript:void;" class="card-title">Matrix Plan Table 1</a>
                    <div class="heading-elements">
                      <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      </ul>
                    </div>

                  </div>
                  <div class="card-body row collapse" id="matrix_table_1">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>SN</th>
                          <th>Generation</th>
                          <th>Commission (%)</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="(key, $setting) in $matrix_plan_table_1.table">
                          <td>{{$index + 1}}</td>
                          <td>{{$setting.level}}</td>
                          <td contenteditable="true" ng-model="$setting.commission">{{$setting.commission}}</td>
                        </tr>

                      </tbody>
                    </table>


                    <form action="<?=domain;?>/settings/update/matrix_plan_table_1" method="post" class="ajax_form" id="matrix_plan_table_1">

                      <textarea style="display: none;" name="content">{{$matrix_plan_table_1}}</textarea>

                      <div class="text-center col-12">
                        <button ng-show="$matrix_plan_table_1.length != 0" class="btn btn-success" type="submit">Update </button>
                      </div>
                    </form>

                  </div>

                </div>


                <div class="card">

                  <div class="card-header"  data-toggle="collapse" data-target="#points_value">
                    <a href="javascript:void;" class="card-title">Points Value</a>
                    <div class="heading-elements">
                      <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      </ul>
                    </div>

                  </div>
                  <div class="card-body row collapse" id="points_value">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>SN</th>
                          <th>Course Level</th>
                          <th>Tag</th>
                          <th>Points </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="(key, $setting) in $points_value.courses">
                          <td>{{$index + 1}}</td>
                          <td>{{$setting.level}}</td>
                          <td>{{$setting.tag}}</td>
                          <td contenteditable="true" ng-model="$setting.points">{{$setting.points}}</td>
                        </tr>

                      </tbody>
                    </table>

                    <div class="form-group col-12">
                      <label>Video Testimonial Points </label>
                      <input type="" name="" ng-model="$points_value.video_testimonial">
                    </div>


                    <form action="<?=domain;?>/settings/update/points_value" method="post" class="ajax_form" id="points_value">

                      <textarea style="display: none;" name="content">{{$points_value}}</textarea>

                      <div class="text-center col-12">
                        <button ng-show="$points_value.length != 0" class="btn btn-success" type="submit">Update </button>
                      </div>
                    </form>

                  </div>

                </div>


                
                <div class="card">

                  <div class="card-header"  data-toggle="collapse" data-target="#ranks_and_generation">
                    <a href="javascript:void;" class="card-title">Ranks and Generational Depth</a>
                    <div class="heading-elements">
                      <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                      </ul>
                    </div>

                  </div>
                  <div class="card-body row collapse" id="ranks_and_generation">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>SN</th>
                          <th>Rank</th>
                          <th>Commission Depth </th>
                          <th>Max payout </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-repeat="(key, $setting) in $rank_and_generation.ranks">
                          <td>{{$index + 1}}</td>
                          <td>{{$setting.level}}</td>
                          <td contenteditable="true" ng-model="$setting.generation">{{$setting.generation}}</td>
                          <td contenteditable="true" ng-model="$setting.max_payout">{{$setting.max_payout}}</td>
                        </tr>

                      </tbody>
                    </table>



                    <form action="<?=domain;?>/settings/update/rank_and_generation" method="post" class="ajax_form" id="rank_and_generation">

                      <textarea style="display: none;" name="content">{{$rank_and_generation}}</textarea>

                      <div class="text-center col-12">
                        <button ng-show="$rank_and_generation.length != 0" class="btn btn-success" type="submit">Update </button>
                      </div>
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

            <div class="card-header"  data-toggle="collapse" data-target="#LeadershipProgram">
              <a href="javascript:void;" class="card-title">Leadership Program Settings</a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                  <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
              </div>

            </div>

            <style>
              td > span {
                /*border: 1px solid #00000033;*/
                margin: 1px;
                padding: 5px;
              }
            </style>


            <div class="card-body row collapse" id="LeadershipProgram">
              <div class="col-12">
              <div class="table-responsive">
                <!-- {{$leadership_ranks.rank_qualifications}} -->

                <table class="table">
                  <thead>
                    <tr>
                      <th>SN</th>
                      <th>Rank</th>
                      <th>Actions <!-- <br>Points (Volume) --> </th>
                      <th>Life Personal Points<br> (LPP)</th>
                      <th>Life Group Points<br> (LGP)</th>
                      <th>Downlines in team</th>
                      <th>Direct Line</th>
                      <!-- <th>Cash Rewards</th> -->
                      <!-- <th>Downline Gain<br><small>downline at generation</small></th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="(key, $setting) in $leadership_ranks.rank_qualifications">
                      <td>{{$index + 1}}</td>
                      <td> 
                        <span contenteditable="true" ng-model="$leadership_ranks.all_ranks[key].name"></span>
                      </td>
                        <td>
                          <!-- <span contenteditable="true" ng-model="$setting.points_volume.activity.action"></span> -->
                          <!-- <span contenteditable="true" ng-model="$setting.points_volume.points"></span> -->



                          <span  ng-repeat="($index, $activity) in $setting.rating.activity">
                            <span contenteditable="true" ng-model="$activity.count"></span>
                            <span contenteditable="true" ng-model="$activity.action"></span>


                            <br>
                          </span>

                        </td>
                        <td>
                            <span contenteditable="true" ng-model="$setting.points_volume.life_personal_points"></span>
                          </td>
                          <td>
                            <span contenteditable="true" ng-model="$setting.points_volume.life_group_points"></span>

                        </td>

                        <td>
              
                          <span  ng-repeat="($index, $in_team) in $setting.rating.in_team">
                            <span contenteditable="true" ng-model="$in_team.count"></span>


                            <select ng-model="$setting.rating.in_team[$index].member_rank">
                              <option value="">Please Select</option>
                              <option value="{{$rank.index}}"  ng-repeat="($index, $rank) in $leadership_ranks.all_ranks" ng-selected="$rank.index==$in_team.member_rank">{{$rank.name}}</option>
                            </select>
                            <br>
                          </span>


                        </td>
                        <td>
                          
                          <span  ng-repeat="($index, $direct_line) in $setting.rating.direct_line">
                            <span contenteditable="true" ng-model="$direct_line.count"></span>
                            <select ng-model="$setting.rating.direct_line[$index].member_rank">

                              <option value="">Please Select</option>
                              <option  value="{{$rank.index}}" ng-repeat="($index, $rank) in $leadership_ranks.all_ranks" ng-selected="$rank.index==$direct_line.member_rank">{{$rank.name}}</option>
                            </select>
                            <br>
                          </span>
                        </td>

                        <!-- <td>                       
                          <span contenteditable="true" ng-model="$setting.cash_rewards.amount"></span>                      
                          <br>

                          <span  ng-repeat="($index, $perk) in $setting.cash_rewards.perks">
                            <span contenteditable="true" ng-model="$perk"></span>
                            <br>
                          </span>

                        </td>

                        <td>                       
                          <span  ng-repeat="($index, $binary_gain) in $setting.binary_gains">
                            <span ng-hide="$binary_gain.count==''">
                              Count: <span contenteditable="true" ng-model="$binary_gain.count"></span><br>
                            </span>
                            <span ng-hide="$binary_gain.level==''">
                              Level: <span contenteditable="true" ng-model="$binary_gain.level"></span>
                            </span>
                            <br>
                          </span>
                        </td> -->

                      </tr>

                    </tbody>
                  </table>

                  <form action="<?=domain;?>/settings/update/leadership_ranks" method="post" class="ajax_form" id="leadership_ranks_form">

                    <textarea style="display: none;" name="content">{{$leadership_ranks}}</textarea>

                    <div class="text-center col-12">
                      <button ng-show="$leadership_ranks.length != 0" class="btn btn-success" type="submit">Update </button>
                    </div>
                  </form>
                </div>
                </div>
              </div>

            </div>
          </div>
        </div>



        <div class="row" >
          <div class="col-12">
            <div class="card">

              <div class="card-header"  data-toggle="collapse" data-target="#Rules">
                <a href="javascript:void;" class="card-title">Rules Settings</a>
                <div class="heading-elements">
                  <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                  </ul>
                </div>

              </div>

              <div class="card-body row collapse" id="Rules">
                <div class="col-12">
                  <div class="row">
                      
                    <div class="form-group col-md-6">
                      <label>Withdrawal Fee (%)</label>
                      <input type="" class="form-control" name="" ng-model="$rules_settings.withdrawal_fee_percent">
                    </div>


                    <div class="form-group col-md-6">
                      <label>Minimum Withdrawal </label>
                      <input type="" class="form-control" name="" ng-model="$rules_settings.min_withdrawal_usd">
                    </div>

                 <!--
                    <div class="form-group col-md-6">
                    <label>User Transfer Fee (%)</label>
                    <input type="" class="form-control" name="" ng-model="$rules_settings.user_transfer_fee_percent">
                  </div>

                    <div class="form-group col-md-6">
                    <label>Min Transfer Amount </label>
                    <input type="" class="form-control" name="" ng-model="$rules_settings.min_transfer_usd">
                  </div>
                  </div>


                   <div class="form-group col-12">
                    <label>Minimum Deposit </label>
                    <input type="" class="form-control" name="" ng-model="$rules_settings.min_deposit_usd">
                  </div>


                  <div class="form-group col-12">
                    <label>The Yields of liability and bonuses by career plan are paid </label>
                    <input type="" class="form-control" name="" ng-model="$rules_settings.yield_of_liability_and_bonuses_is_paid">
                  </div>


                  <div class="form-group col-12">
                    <label>The Service Package begins to compute from <b>nth</b> day of acquiring it  </label>
                    <input type="" class="form-control" name="" ng-model="$rules_settings.service_package_computes_returns_from_xth_day">
                  </div>

                  <hr/>
                  <div class=" row">
                    <div class="form-group col-md-12">
                      The income and commissions generated are paid in: 
                    </div>
                    <div class="form-group col-md-4">
                      <label>Cash (%)  </label>
                      <input type="" class="form-control" name="" ng-model="$rules_settings.income_split_percent.cash_percent">
                    </div>
                    <div class="form-group col-md-4">
                      <label>TruCash (%)  </label>
                      <input type="" class="form-control" name="" ng-model="$rules_settings.income_split_percent.trucash_percent">
                    </div>


                    <div class="form-group col-md-4">
                      <label>Grace Period to sell Hot Wallet Coins (Days)  </label>
                      <input type="" class="form-control" name="" ng-model="$rules_settings.income_split_percent.grace_period_to_sell_hot_wallet">
                    </div>


                  </div>
                  
                  <hr/>
                  <div class=" row">
                    <div class="form-group col-md-12">
                      This month Membership Expiry  : 
                    </div>
                    <div class="form-group col-md-4">
                      <label>From  </label>
                      <input type="" class="form-control" name="" ng-model="$rules_settings.this_month_membership_expiry_rule.from">
                    </div>

                    <div class="form-group col-md-4">
                      <label>To   </label>
                      <input type="" class="form-control" name="" ng-model="$rules_settings.this_month_membership_expiry_rule.to">
                    </div>
 
                    <div class="form-group col-md-4">
                      <label>Membersihp Renewal x/month  </label>
                      <input type="" class="form-control" name="" ng-model="$rules_settings.this_month_membership_expiry_rule.renewal_date">
                    </div>

 -->
                  </div>


                  <form action="<?=domain;?>/settings/update/rules_settings" method="post" class="ajax_form" id="rules_settings_form">

                    <textarea style="display: none;" name="content">{{$rules_settings}}</textarea>

                    <div class="text-center col-12">
                      <button ng-show="$rules_settings.length != 0" class="btn btn-success" type="submit">Update </button>
                    </div>
                  </form>





                </div>
              </div>

            </div>
          </div>
        </div>







               <div class="row" >
                 <div class="col-12">
                   <div class="card">

                     <div class="card-header"  data-toggle="collapse" data-target="#CurrencyPricing">
                       <a href="javascript:void;" class="card-title">Currency Pricing Settings</a>
                       <div class="heading-elements">
                         <ul class="list-inline mb-0">
                           <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                           <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                         </ul>
                       </div>

                     </div>


                     <!-- {{$currencies_and_codes}} -->


                     <div class="card-body row collapse show" id="CurrencyPricing">
                       <div class="col-12">
                         <div class="row">
                             
                           <div class="form-group col-md-3">
                             <label>Priced Currency <small>from course platform</small></label>
                             <select class="form-control custom-select" ng-model="$currency_pricing.priced_currency">
                               <option ng-selected="key==$currency_pricing.priced_currency" value="{{key}}" ng-repeat="(key, $currency) in $currencies_and_codes" >{{key}} </option>
                             </select>
                           </div>


                           <div class="form-group col-md-3">
                             <label>Commission Currency <small>affiliate system</small></label>
                             <select class="form-control custom-select" disabled="">
                               <option ng-selected="key==$currency_pricing.used_currency" value="{{key}}" ng-repeat="(key, $currency) in $currencies_and_codes" >{{key}} </option>
                             </select>
                           </div>


                           <div class="form-group col-md-6">
                             <label>Exchange <span style="text-transform: uppercase; font-weight: bold;">
                             {{$currency_pricing.priced_currency}}/{{$currency_pricing.used_currency}} -- {{$currency_pricing.pricedcurrency_usedcurrency}}</span> 
                            </label>
                             <input type="" class="form-control" name="" ng-model="$currency_pricing.pricedcurrency_usedcurrency">
                           </div>



                   
                         </div>


                         <form action="<?=domain;?>/settings/update/currency_pricing" method="post" class="ajax_form" id="rules_settings_form">

                           <textarea style="display: none;" name="content">{{$currency_pricing}}</textarea>

                           <div class="text-center col-12">
                             <button ng-show="$currency_pricing.length != 0" class="btn btn-success" type="submit">Update </button>
                           </div>
                         </form>





                       </div>
                     </div>

                   </div>
                 </div>
               </div>





      </div>
    </div>
  </div>
  <!-- END: Content-->

  <?php include 'includes/footer.php';?>
