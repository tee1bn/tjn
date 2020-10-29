          <div class="col-md-3">
            
            <style>
              .guest-side-list{
                padding:5px;
              }
              .tradingview-widget-copyright{
                display: none;
              }
            </style>



            <div class="card d-none d-lg-block" style="" >
              <div class="card-content">
                <div class="card-body">
                  <h4 class="card-title"><?=project_name;?></h4>
                  <h6 class="card-subtitle text-muted">Here, we meet all your needs to trade the global forex market from Nigeria.</h6>
                </div>

               
                <div class="card-body">



                    <ul class="list-group list-group-flush">

                                <li class="list-group-item guest-side-list">
                                  <a href="" class=" dropdown-toggle" data-toggle="dropdown"> Open Live Account</a>
                                  <div class="dropdown-menu">

                                  <?php foreach ($brokers_in_header as $key => $broker_in_header) :?>

                                       <a class="dropdown-item" target="_blank" href="<?=domain;?>/forex-account/open-live-account/<?=MIS::dec_enc('encrypt',$broker_in_header->id);?>"><small>Open <b><?=$broker_in_header->name;?></b> Live Account</small></a>

                                  <?php endforeach;?>

                                </div>

                                </li>


                                <li class="list-group-item guest-side-list">
                                  <span class="badge badge-pill bg-info float-right">@<?=$currency;?><?=$site_setting['fund_lpr_at'];?> </span>
                                  <a href="<?=domain;?>/user/make-deposit"title="Deposit funds into your forex trading acount">Make Deposit </a>
                                </li>
                                <li class="list-group-item guest-side-list">
                                  <span class="badge badge-pill bg-info float-right">@<?=$currency;?><?=$site_setting['withdraw_at'];?> </span>
                                  <a href="<?=domain;?>/user/make-withdrawal" title="Withdraw profits/funds from your forex trading account">Withdraw </a>
                                </li>
                                <li class="list-group-item guest-side-list">
                                  <span class="badge badge-pill bg-info float-right"><i class="ft-lock"></i></span>
                                  <a href="" class=" dropdown-toggle" data-toggle="dropdown" 
                                  title="Login into your trading account to trade through preferred broker">Personal Area</a>
                                  <div class="dropdown-menu">


                                    <?php foreach ($brokers_in_header as $key => $broker_in_header) :?>

                                         <a class="dropdown-item" target="_blank" href="<?=$broker_in_header->ClientCabinet;?>" >
                                          <small>Log in to <b><?=$broker_in_header->name;?></b> Personal Area</small>
                                        </a>
                                    <?php endforeach;?>
                                  </div>
                                </li>
                              </ul>
                </div>
              </div>
            </div>


            <div class="card d-none d-lg-block" style="" >
              <div class="card-content">


                <div class="card-body">
                  <h6 class="text-muted">Forex Quotes.</h6>
                 <!-- TradingView Widget BEGIN -->
                 <div class="tradingview-widget-container">
                   <div class="tradingview-widget-container__widget"></div>
                   <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/markets/currencies/" rel="noopener" target="_blank"><span class="blue-text">Forex</span></a> by TradingView</div>
                   <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
                   {
                   "colorTheme": "dark",
                   "dateRange": "12m",
                   "showChart": true,
                   "locale": "en",
                   "largeChartUrl": "",
                   "isTransparent": false,
                   "width": "auto",
                   "height": "400",
                   "plotLineColorGrowing": "rgba(25, 118, 210, 1)",
                   "plotLineColorFalling": "rgba(25, 118, 210, 1)",
                   "gridLineColor": "rgba(42, 46, 57, 1)",
                   "scaleFontColor": "rgba(120, 123, 134, 1)",
                   "belowLineFillColorGrowing": "rgba(33, 150, 243, 0.12)",
                   "belowLineFillColorFalling": "rgba(60, 120, 216, 0.12)",
                   "symbolActiveColor": "rgba(33, 150, 243, 0.12)",
                   "tabs": [
                     {
                       "title": "Forex",
                       "symbols": [
                         {
                           "s": "FX:EURUSD"
                         },
                         {
                           "s": "FX:GBPUSD"
                         },
                         {
                           "s": "FX:USDJPY"
                         },
                         {
                           "s": "FX:USDCHF"
                         },
                         {
                           "s": "FX:AUDUSD"
                         },
                         {
                           "s": "FX:USDCAD"
                         }
                       ],
                       "originalTitle": "Forex"
                     }
                   ]
                 }
                   </script>
                 </div>
                 <!-- TradingView Widget END -->
                </div>
              </div>
            </div>
<!-- 
            <div class="card d-none d-lg-block" style="" >
              <div class="card-content">
                <div class="card-body">
                  <?php 
                  use v2\Models\Broker;
                  $random_broker =  Broker::Active()->get()->random();
                  echo ($random_broker->WrittenArray['banner']);
                  ;?>
                </div>
              </div>
            </div> -->

          </div>

