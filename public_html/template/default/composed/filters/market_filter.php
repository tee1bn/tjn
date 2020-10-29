       <div class="dropdown">
                          <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                             <i class="fa fa-filter"></i>
                          </button>
                          <div class="dropdown-menu" style="padding: 20px;">
                            <form action="<?=$action ?? '';?>" method="get" id="filter_form">
                                <div class="row">

                                    <div class="form-group col-sm-12">
                                        <label>Author</label><br>
                                        <input type="" name="name" placeholder="First, Last, Middle Name, Phone, Email, Username"
                                         class="form-control" value="<?=$sieve['name'] ??'';?>">
                                    </div>
                                </div>

                          

                                <div class="row">
                               
                                    <div class="form-group col-md-6">
                                        <label>Category</label>
                                        <select class="form-control" name="category">
                                            <option value="">Select Category</option>
                                            <?php foreach (v2\Models\Market::$register as $key => $value):?>
                                                <option <?=( (isset($sieve['category'])) && ($sieve['category']==(int)$key)) ?'selected':'';?> value="<?=$key;?>"> 
                                                    <?=$value['name'];?>
                                                </option>
                                            <?php endforeach ;?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Status</label>
                                        <select class="form-control" name="status">
                                            <option value="">Select</option>
        
                                            <?php foreach ([0=> 'Declined' , 1=> 'In Review', 2=> 'Approved'] as $key => $value):?>
                                                <option <?=( (isset($sieve['status'])) && ($sieve['status']==(int)$key)) ?'selected':'';?> value="<?=$key;?>"> 
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
                                        value="<?=$sieve['created']['start_date'] ?? '';?>" 
                                        class="form-control" name="created[start_date]">
                                    </div>


                                    <div class=" form-group col-sm-6">
                                        <label>* Created  (To)</label>
                                        <input type="date" placeholder="End "
                                            value="<?=$sieve['created']['end_date'] ?? '';?>" 
                                         class="form-control" name="created[end_date]">
                                    </div>

                                    
                                </div>


                                <div class="form-group">
                                    <button type="Submit" class="btn btn-primary">Submit</button>
                                    <!-- <a  onclick="$('#filter_form').reset()">Reset</a> -->
                                </div>
                            </form>

                          </div>
                        </div>
                        