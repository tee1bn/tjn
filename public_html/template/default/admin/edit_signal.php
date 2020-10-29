<?php
$page_title = "Edit Signal";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Edit Signal</h3>
          </div>
 <div class="content-header-right col-md-6 col-12">
   <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
     <a class="btn btn-secondary  float-right" href="<?=domain;?>/admin/signals">All Signals</a>
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

              <h4 class="card-title" style="display: inline;">Edit Signal</h4>


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

                <form action="<?=domain;?>/signals/update_signal" method="post">

                    <div class="row">
                      <div class="form-group col-md-3">
                        <label>Symbol</label>
                        <input type="" name="detail[symbol]" class="form-control"  value="<?=$signal->DetailArray['symbol'] ?? '';?>">
                      </div>


                      <div class="form-group col-md-3">
                        <label>Order</label>
                        <input type=""  name="detail[order]" class="form-control"  value="<?=$signal->DetailArray['order'] ?? '';?>">
                        <span class="text-danger">*<code>buy</code> or <code>sell</code> </span>
                      </div>



                      <div class="form-group col-md-3">
                        <label>Entry Price</label>
                        <input type="number" min="0" step="0.00001" name="detail[entry_price]" class="form-control"  value="<?=$signal->DetailArray['entry_price'] ?? '';?>">
                      </div>

                      <div class="form-group col-md-3">
                        <label>Stop loss</label>
                        <input type="number" min="0" step="0.00001" name="detail[stop_loss]" class="form-control"  value="<?=$signal->DetailArray['stop_loss'] ?? '';?>">
                      </div>

                      <div class="form-group col-md-3">
                        <label>Take Profit</label>
                        <input type="number" min="0" step="0.00001" name="detail[take_profit]" class="form-control"  value="<?=$signal->DetailArray['take_profit'] ?? '';?>">
                      <input type="hidden" name="signal_id" value="<?=$signal->id;?>">
                      </div>  


                      <div class="form-group col-md-3">
                        <label>Time Frame</label>
                      <!-- 
                        <select class="form-control" name="detail[timeframe]">

                            <option value="">Select time frame</option>
                          <?php foreach ($timeframes as $key => $timeframe) :?>
                            <option value="<?=$timeframe;?>" <?=($timeframe==$signal->DetailArray['timeframe']) ? 'selected':'';?> ></option>

                          <?php endforeach;?>
                          
                        </select>
                      -->
                        <input type=""  name="detail[timeframe]" class="form-control"  value="<?=$signal->DetailArray['timeframe'] ?? '';?>">
                      </div>

                      <div class="col-md-3">
                        <label>Trailing stop</label>
                        <input type="number" min="0"  name="detail[trailing_stop]" class="form-control"  value="<?=$signal->DetailArray['trailing_stop'] ?? '';?>">
                      </div>


                      <div class="form-group col-md-3">
                        <label>Starts at</label>
                        <input type="datetime-local" name="starts_at" class="form-control"  value="<?=$signal['FormattedStartsAt'] ?? '';?>">
                      </div>

                      <div class="form-group col-md-3">
                        <label>Closes at</label>
                        <input type="datetime-local" name="closes_at" class="form-control"  value="<?=$signal['FormattedClosesAt'] ?? '';?>">
                      </div>


                      <div class="form-group col-md-3">
                        <label>Comment</label>
                        <textarea name="detail[comment]" rows="4" class="form-control"><?=$signal->DetailArray['comment'] ?? '';?></textarea>
                      </div>


                      
                    </div>

                    <?php

                      $publish = Config::domain()."/signals/update_signal/publish";
                      $send_test = Config::domain()."/signals/update_signal/send_test";

                    ;?>
                  <div class="form-group col-md-12">
                    <div class="btn-group">
                      <button type="submit" id="submit_btn" class="btn btn-outline-primary">Save</button>
                      <button type="button" 
                        onclick="$confirm_dialog= new DialogJS(submit_campaign, ['<?=$publish;?>'],'Are you sure you want to publish?');" 
                        class="btn btn-outline-primary">Publish</button>

                      <button type="button" 
                        onclick="$confirm_dialog= new DialogJS(submit_campaign, ['<?=$send_test;?>'],'Are you sure you want to send test?');" 
                        class="btn btn-outline-primary">Send test</button>
                        
                    </div>


                  
                </form>


                <script type="text/javascript">
                  
                  submit_campaign =  function($data){
                    $form = $('#campaign_form');
                    $form.attr('action', $data); 
                    $('#submit_btn').click();
                  }
                  

                </script>

                  
              </div>
            </div>
          </section>



        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
