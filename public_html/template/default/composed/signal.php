<style type="text/css">
  .signal{
       background: white;
       padding: 20px;
       border: 1px solid #00000017;
       border-radius: 5px;
  }

  .full-signal{
       border: 1px solid #00000017;
     }

     .js-embed-widget:hover{

     }

     .cover{

      background: #00ff6600;
      position: absolute;
      width: 75em;
      height: 11em;
      z-index: 999999999999;
     }
</style>

<?php
$detail = $signal->DetailArray;
;?>
                    <div class="card-body">

                            <div class="full-signal">
                              <div class="col-md-6 matching-height" style="padding: 0px; display: inline;">
                                <div class="signal">
                                    
                                  <h4 class="card-title" style="display: inline;">
                                    <a><b><?=$detail['symbol'] ?? '';?></b> <span class="badge <?=($detail['order']=='sell') ? 'badge-danger' :'badge-success';?>"><?=$detail['order'] ?? '';?></span>
                                      @ <?=$detail['entry_price'] ?? '';?>
                                    </a>
                                  </h4>
                                  <span class="float-right">
                                    <small><i class="ft-clock"></i> <?=date("M j Y, h:ia", strtotime($signal->published_at));?></small>
                                    <br> <a href="https://mt4.octafx.com/?refid=ib2547685" target="_blank" class="btn btn-sm btn-secondary">Trade Now</a>
                                    <br> <?=$detail['timeframe'] ?? 'all';?>
                                  </span>
                                  <br>SL:<?=$detail['stop_loss'] ?? '';?> TP:<?=$detail['take_profit'] ?? '';?>

                                  <br>
                                  <?php if ((isset($detail['comment'] )) && ($detail['comment'] != '')) :?>
                                  <small>
                                    <span class="badge badge-secondary">Note</span>
                                    <?=$detail['comment'] ?? '';?>
                                  </small>
                                  <?php endif ;?>
                                </div>


                              </div>
                              
                              <div class="col-md-6 matching-height" style="padding: 0px; display: inline;">
                                <div class="cover"> </div>
                                <!-- TradingView Widget BEGIN -->
                                <div class="tradingview-widget-container">
                                  <div class="tradingview-widget-container__widget"></div>

                                  <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                  {
                                  "symbol": "FX:<?=str_replace("/", '', $detail['symbol']);?>",
                                  "width": "100%",
                                  "height": "100%",
                                  "locale": "en",
                                  "dateRange": "<?=$detail['timeframe'] ?? 'all';?>",
                                  "colorTheme": "light",
                                  "trendLineColor": "#37a6ef",
                                  "underLineColor": "#E3F2FD",
                                  "isTransparent": false,
                                  "autosize": true,
                                  "largeChartUrl": ""
                                }
                                  </script>
                                </div>
                                <!-- TradingView Widget END -->

                              </div>
                              
                            </div>

                          

                          </div>
