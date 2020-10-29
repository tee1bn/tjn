       <div class="dropdown">
                          <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                             <i class="fa fa-filter"></i>
                          </button>
                          <div class="dropdown-menu" style="padding: 20px; top: 40px !important;">
                            <form action="<?=$action??'';?>" method="get" id="filter_form">

                              <div class="row">

                                <div class="form-group col-md-6">
                                    <label>ID</label><br>
                                    <input type="" name="ref" class="form-control" placeholder="Enter ID" value="<?=$sieve['ref'] ?? '';?>">
                                </div>
                                



                                <div class="form-group col-md-6">
                                    <label>User </label><br>
                                    <input type="" name="name" placeholder="First, Last, Name, email, phone, or username" 
                                    class="form-control" value="<?=$sieve['name'] ?? '';?>">
                                </div>

                                
                                <div class="form-group col-md-6">
                                    <label>Order ID </label><br>
                                    <input type="" name="order_id" placeholder="order_id" 
                                    class="form-control" value="<?=$sieve['order_id'] ?? '';?>">
                                </div>

                                
                             <!--                   
                                  <div class="form-group col-md-6">
                                      <label>Is Transfer</label>
                                      <select class="form-control" name="is_transfer">
                                          <option value="">Select</option>
                                          <?php foreach (['yes'=> 'yes' , 'no'=> 'no' ,] as $key => $value):?>
                                              <option <?=((isset($sieve['is_transfer'])) && ($sieve['is_transfer']==$key)) ?'selected':'';?> value="<?=$key;?>"> 
                                                  <?=$value;?>
                                              </option>
                                          <?php endforeach ;?>
                                      </select>
                                  </div>
                                                -->
                                  <div class="form-group col-md-6">
                                      <label>Paid Status</label>
                                      <select class="form-control" name="payment_status">
                                          <option value="">Select</option>
                                          <?php foreach (['unpaid'=> 'UnPaid' , 'paid'=> 'Paid' ,] as $key => $value):?>
                                              <option <?=(($sieve['payment_status']) && ($sieve['payment_status']==$key)) ?'selected':'';?> value="<?=$key;?>"> 
                                                  <?=$value;?>
                                              </option>
                                          <?php endforeach ;?>
                                      </select>
                                  </div>


                                  <div class="form-group col-md-6">
                                      <label>Status</label>
                                      <select class="form-control" name="status">
                                          <option value="">Select</option>
                                          <?php foreach(v2\Models\Wallet::$statuses as $key => $value) :?>
                                              <option value="<?=$key;?>" <?=((isset($sieve['status'])) &&($sieve['status']===$key))?'selected':'';?>> <?=$value;?></option>
                                          <?php endforeach ; ?>
                                      </select>

                                  </div>

                              <div class="form-group col-md-6">
                                  <label>Comment </label><br>
                                  <input type="" name="comment" placeholder="Comment" 
                                  class="form-control" value="<?=$sieve['comment'] ?? '';?>">
                              </div>

                              </div>

                              








                                <div class="row">
                                    <div class=" form-group col-md-6">
                                        <label>*  Amount (From):</label>
                                        <input placeholder="Start" type="number" step="0.0001" 
                                        value="<?=$sieve['amount']['start']??'';?>" 
                                        class="form-control" name="amount[start]">
                                    </div>


                                    <div class=" form-group col-md-6">
                                        <label>* Amount (To)</label>
                                        <input type="number" step="0.0001" placeholder="End "
                                            value="<?=$sieve['amount']['end']??'';?>" 
                                         class="form-control" name="amount[end]">
                                    </div>                    
                                </div>

                                


                                <div class="row">
                                    <div class=" form-group col-md-6">
                                        <label>*  Cleared(From):</label>
                                        <input placeholder="Start" type="date" 
                                        value="<?=$sieve['cleared']['start_date']??'';?>" 
                                        class="form-control" name="cleared[start_date]">
                                    </div>


                                    <div class=" form-group col-md-6">
                                        <label>* Cleared (To)</label>
                                        <input type="date" placeholder="End "
                                            value="<?=$sieve['cleared']['end_date']??'';?>" 
                                         class="form-control" name="cleared[end_date]">
                                    </div>
                                </div>



                                <div class="row">
                                    <div class=" form-group col-md-6">
                                        <label>*  Date(From):</label>
                                        <input placeholder="Start" type="date" 
                                        value="<?=$sieve['registration']['start_date']??'';?>" 
                                        class="form-control" name="registration[start_date]">
                                    </div>


                                    <div class=" form-group col-md-6">
                                        <label>* Date (To)</label>
                                        <input type="date" placeholder="End "
                                            value="<?=$sieve['registration']['end_date']??'';?>" 
                                         class="form-control" name="registration[end_date]">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button type="Submit" class="btn btn-primary">Submit</button>
                                    <!-- <a  onclick="$('#filter_form').reset()">Reset</a> -->
                                </div>
                            </form>

                          </div>
                        </div>
                        