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

                              
<!-- 
                              <div class="form-group col-md-6">
                                  <label>Comment </label><br>
                                  <input type="" name="comment" placeholder="Comment" 
                                  class="form-control" value="<?=$sieve['comment'] ?? '';?>">
                              </div>
 -->



                              </div>

                              

                                <div class="row">
                                    <div class=" form-group col-md-6">
                                        <label>*  level (From):</label>
                                        <input placeholder="Start" type="number" step="0.0001" 
                                        value="<?=$sieve['level']['start']??'';?>" 
                                        class="form-control" name="level[start]">
                                    </div>


                                    <div class=" form-group col-md-6">
                                        <label>* level (To)</label>
                                        <input type="number" step="0.0001" placeholder="End "
                                            value="<?=$sieve['level']['end']??'';?>" 
                                         class="form-control" name="level[end]">
                                    </div>                    
                                </div>


                                <div class="row">
                                    <div class=" form-group col-md-6">
                                        <label>*  points (From):</label>
                                        <input placeholder="Start" type="number" step="0.0001" 
                                        value="<?=$sieve['points']['start']??'';?>" 
                                        class="form-control" name="points[start]">
                                    </div>


                                    <div class=" form-group col-md-6">
                                        <label>* points (To)</label>
                                        <input type="number" step="0.0001" placeholder="End "
                                            value="<?=$sieve['points']['end']??'';?>" 
                                         class="form-control" name="points[end]">
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
                                    <button type="Submit" class="btn btn-outline-dark">Submit</button>
                                    <!-- <a  onclick="$('#filter_form').reset()">Reset</a> -->
                                </div>
                            </form>

                          </div>
                        </div>
                        