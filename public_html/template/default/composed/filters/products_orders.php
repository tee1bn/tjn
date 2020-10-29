   <div class="dropdown">
                          <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                             <i class="fa fa-filter"></i>
                          </button>
                          <div class="dropdown-menu" style="padding: 20px;">
                            <form action="<?=$action;?>" method="get" id="filter_form">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Ref</label><br>
                                        <input type="" name="ref" class="form-control" value="<?=$sieve['ref'];?>">
                                    </div>
                                    
                                    <div class="form-group col-sm-6">
                                        <label>User</label><br>
                                        <input type="" name="user" placeholder="First or Last Name or email, phone ,username" class="form-control" value="<?=$sieve['user'];?>">
                                    </div>


                                    <div class="form-group col-sm-6">
                                        <label>Item</label><br>

                                        <select class="form-control" name="item">
                                            <option value="">Select</option>
                                            <?php foreach (SubscriptionPlan::available()->get() as $key => $value):?>
                                                <option <?=($sieve['item']==(int)$value->id) ?'selected':'';?> value="<?=$value->id;?>"> 
                                                    <?=$value->package_type;?>
                                                </option>
                                            <?php endforeach ;?>
                                        </select>

                                    </div>
                                </div>

                                <div class="row">


                                  </div>

                                <div class="row">
                                
                                    <div class="form-group col-md-6">
                                        <label>Paid Status</label>
                                        <select class="form-control" name="payment_status">
                                            <option value="">Select</option>
                                            <?php foreach (['unpaid'=> 'UnPaid' , 'paid'=> 'Paid' ,] as $key => $value):?>
                                                <option <?=($sieve['payment_status']==$key) ?'selected':'';?> value="<?=$key;?>"> 
                                                    <?=$value;?>
                                                </option>
                                            <?php endforeach ;?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Payment Method</label>
                                        <select class="form-control" name="payment_method">
                                            <option value="">Select</option>
                                            <?php foreach ($shop->available_payment_method as $key => $value):?>
                                                <option <?=($sieve['payment_method']==$value['name']) ?'selected':'';?> value="<?=$value['name'];?>"> 
                                                    <?=$value['name'];?>
                                                </option>
                                            <?php endforeach ;?>
                                        </select>
                                    </div>

                                </div>
                             

                                <div class="row">
                                    <div class=" form-group col-sm-6">
                                        <label>*  Ordered(From):</label>
                                        <input placeholder="Start" type="date" 
                                        value="<?=$sieve['ordered']['start_date'];?>" 
                                        class="form-control" name="ordered[start_date]">
                                    </div>


                                    <div class=" form-group col-sm-6">
                                        <label>* Ordered (To)</label>
                                        <input type="date" placeholder="End "
                                            value="<?=$sieve['ordered']['end_date'];?>" 
                                         class="form-control" name="ordered[end_date]">
                                    </div>

                                    
                                </div>


                                <div class="form-group">
                                    <button type="Submit" class="btn btn-primary">Submit</button>
                                    <!-- <a  onclick="$('#filter_form').reset()">Reset</a> -->
                                </div>
                            </form>

                          </div>
                        </div>
                        