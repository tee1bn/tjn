       <div class="dropdown">
                          <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                             <i class="fa fa-filter"></i>
                          </button>
                          <div class="dropdown-menu" style="padding: 20px; top: 40px !important;">
                            <form action="<?=$action ?? '';?>" method="get" id="filter_form">
                                
                              <div class="row">

                                <div class="form-group col-md-6">
                                    <label>ID</label><br>
                                    <input type="" name="ref" class="form-control" placeholder="Enter ID" value="<?=$sieve['ref'] ?? '';?>">
                                </div>
                                



                                <div class="form-group col-md-6">
                                    <label>User </label><br>
                                    <input type="" name="name" placeholder="First, Last, Name, email, phone, or username" class="form-control" value="<?=$sieve['name'] ?? '';?>">
                                </div>


                             

                              </div>



                                <div class="row">
                                    <div class=" form-group col-md-6">
                                        <label>*  Amount (From):</label>
                                        <input placeholder="Start" type="number" step="0.0001" 
                                        value="<?=$sieve['cost']['start'] ?? '';?>" 
                                        class="form-control" name="cost[start]">
                                    </div>


                                    <div class=" form-group col-md-6">
                                        <label>* Amount (To)</label>
                                        <input type="number" step="0.0001" placeholder="End "
                                            value="<?=$sieve['cost']['end'] ?? '';?>" 
                                         class="form-control" name="cost[end]">
                                    </div>                    
                                </div>

                                


                                <div class="row">
                                    <div class=" form-group col-md-6">
                                        <label>*  Paid Date(From):</label>
                                        <input placeholder="Start" type="date" 
                                        value="<?=$sieve['cleared']['start_date'] ?? '';?>" 
                                        class="form-control" name="cleared[start_date]">
                                    </div>


                                    <div class=" form-group col-md-6">
                                        <label>* Paid Date (To)</label>
                                        <input type="date" placeholder="End "
                                            value="<?=$sieve['cleared']['end_date'] ?? '';?>" 
                                         class="form-control" name="cleared[end_date]">
                                    </div>
                                </div>


<!-- 
                                <div class="row">
                                    <div class=" form-group col-md-6">
                                        <label>*  Date(From):</label>
                                        <input placeholder="Start" type="date" 
                                        value="<?=$sieve['registration']['start_date'] ?? '';?>" 
                                        class="form-control" name="registration[start_date]">
                                    </div>


                                    <div class=" form-group col-md-6">
                                        <label>* Date (To)</label>
                                        <input type="date" placeholder="End "
                                            value="<?=$sieve['registration']['end_date'] ?? '';?>" 
                                         class="form-control" name="registration[end_date]">
                                    </div>
                                </div>
 -->

                                <div class="form-group">
                                    <button type="Submit" class="btn btn-primary">Submit</button>
                                    <!-- <a  onclick="$('#filter_form').reset()">Reset</a> -->
                                </div>
                            </form>

                          </div>
                        </div>
                        