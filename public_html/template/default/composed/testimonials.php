       <div class="dropdown">
                          <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                             <i class="fa fa-filter"></i>
                          </button>
                          <div class="dropdown-menu" style="padding: 20px;">
                            <form action="<?=$action ?? '';?>" method="get" id="filter_form">
                                <div class="row">

                                    <div class="form-group col-sm-6">
                                        <label>Ref(ID)</label><br>
                                        <input type="" name="ref" placeholder="ID (Ref)" class="form-control" value="<?=$sieve['ref']??'';?>">
                                    </div>


                                    <div class="form-group col-sm-6">
                                        <label>User</label><br>
                                        <input type="" name="name" placeholder="First or Last Name" class="form-control" value="<?=$sieve['name']??'';?>">
                                    </div>
                                </div>

                                <div class="row">
                               
                                    <div class="form-group col-md-6">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="">Select</option>
                                            <?php foreach ([0=> 'Not Approved' , 1=> 'Approved'] as $key => $value):?>
                                                <option <?=(isset($sieve['status']) && ($sieve['status']==(int)$key)) ?'selected':'';?> value="<?=$key;?>"> 
                                                    <?=$value;?>
                                                </option>
                                            <?php endforeach ;?>
                                        </select>
                                    </div>

                               
                                    <div class="form-group col-md-6">
                                        <label>Published Status</label>
                                        <select class="form-control" name="status">
                                            <option value="">Select</option>
                                            <?php foreach ([0=> 'Not Published' , 1=> 'Published'] as $key => $value):?>
                                                <option <?=(isset($sieve['published_status']) && ($sieve['published_status']==(int)$key)) ?'selected':'';?> value="<?=$key;?>"> 
                                                    <?=$value;?>
                                                </option>
                                            <?php endforeach ;?>
                                        </select>
                                    </div>

                               
                                    <div class="form-group col-md-6">
                                        <label>Type</label>
                                        <select class="form-control" name="type">
                                            <option value="">Select</option>
                                            <?php foreach (['written','video'] as $key => $value):?>
                                                <option <?=(isset($sieve['type']) && ($sieve['type']==$value)) ?'selected':'';?> value="<?=$value;?>"> 
                                                    <?=$value;?>
                                                </option>
                                            <?php endforeach ;?>
                                        </select>
                                    </div>

                                </div>
                             

                             
                                <div class="row">
                                    <div class=" form-group col-sm-6">
                                        <label>*  Created (From):</label>
                                        <input placeholder="Start" type="date" 
                                        value="<?=$sieve['created_at']['start_date'] ?? '';?>" 
                                        class="form-control" name="created_at[start_date]">
                                    </div>


                                    <div class=" form-group col-sm-6">
                                        <label>* Created (To)</label>
                                        <input type="date" placeholder="End "
                                            value="<?=$sieve['created_at']['end_date'] ?? '';?>" 
                                         class="form-control" name="created_at[end_date]">
                                    </div>

                                    
                                </div>


                                <div class="form-group">
                                    <button type="Submit" class="btn btn-primary">Submit</button>
                                    <!-- <a  onclick="$('#filter_form').reset()">Reset</a> -->
                                </div>
                            </form>

                          </div>
                        </div>
                        