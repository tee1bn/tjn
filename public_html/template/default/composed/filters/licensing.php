                        <div class="dropdown">
                          <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                             <i class="fa fa-filter"></i>
                          </button>
                          <div class="dropdown-menu" style="padding: 20px;">
                            <form action="" method="get" id="filter_form" class="ajax_for" data-function='add_filter_url'>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label>License Key</label><br>
                                        <input type="" name="license_key" class="form-control" value="<?=$sieve['license_key'];?>">
                                    </div>
                                  

                                    <div class="form-group col-sm-6">
                                        <label>Status</label><br>
                                        <select class="form-control" name="status">
                                            <option value="">Select</option>
                                            <?php foreach (['available', 'taken'] as $key => $value):?>
                                                <option <?=($sieve['status'] == $value) ?'selected':'';?> value="<?=$value;?>"> 
                                                    <?=$value;?>
                                                </option>
                                            <?php endforeach ;?>
                                        </select>

                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label>Product</label><br>
                                        <select class="form-control" name="product">
                                            <option value="">Select</option>
                                            <?php foreach (Products::all() as $key => $product):?>
                                                <option <?=($sieve['product'] == $product->id) ?'selected':'';?> value="<?=$product->id;?>"> 
                                                    <?=$product->name;?>
                                                    <?=$product->id;?>
                                                </option>
                                            <?php endforeach ;?>
                                        </select>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class=" form-group col-sm-6">
                                        <label>*  Created (From):</label>
                                        <input placeholder="Start" type="date" 
                                        value="<?=$sieve['created_at']['start_date'];?>" 
                                        class="form-control" name="created_at[start_date]">
                                    </div>


                                    <div class=" form-group col-sm-6">
                                        <label>* Created  (To)</label>
                                        <input type="date" placeholder="End "
                                            value="<?=$sieve['created_at']['end_date'];?>" 
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
                        

                        <script>
                            add_filter_url= function(data){
                                 $scope = angular.element($('#lists')).scope();                         
                                 $scope.fetch_page_content(data.url);
                                 $scope.$apply();

                                console.log(data.url);

                            }
                        </script>