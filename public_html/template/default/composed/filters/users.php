       <div class="dropdown">
                          <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                             <i class="fa fa-filter"></i>
                          </button>
                          <div class="dropdown-menu" style="padding: 20px;">
                            <form action="<?=$action ?? '';?>" method="get" id="filter_form">
                                <div class="row">

                                    <div class="form-group col-sm-12">
                                        <label>Name</label><br>
                                        <input type="" name="name" placeholder="First or Last Name" class="form-control" 
                                        value="<?=$sieve['name']??'';?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Client Email</label><br>
                                        <input type="email" name="email" class="form-control" value="<?=$sieve['email'] ?? '';?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Phone</label><br>
                                        <input type="text" name="phone" class="form-control" value="<?=$sieve['phone']??'';?>">
                                    </div>
                                  </div>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>Username</label><br>
                                        <input type="text" name="username" class="form-control" value="<?=$sieve['username']??'';?>">
                                    </div>
                               
                                    <div class="form-group col-md-6">
                                        <label>Status</label>
                                        <select class="form-control" name="active_status">
                                            <option value="">Select</option>
                                            <?php foreach ([2=> 'Blocked' , 1=> 'Active'] as $key => $value):?>
                                                <option <?=((isset($sieve['active_status'])) &&($sieve['active_status']==(int)$key)) ?'selected':'';?> value="<?=$key;?>"> 
                                                    <?=$value;?>
                                                </option>
                                            <?php endforeach ;?>
                                        </select>
                                    </div>

                                </div>
                             

                                <div class="row">
                                    <div class=" form-group col-sm-6">
                                        <label>*  Registration(From):</label>
                                        <input placeholder="Start" type="date" 
                                        value="<?=$sieve['registration']['start_date'] ??'';?>" 
                                        class="form-control" name="registration[start_date]">
                                    </div>


                                    <div class=" form-group col-sm-6">
                                        <label>* Registration (To)</label>
                                        <input type="date" placeholder="End "
                                            value="<?=$sieve['registration']['end_date'] ?? '';?>" 
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
                        