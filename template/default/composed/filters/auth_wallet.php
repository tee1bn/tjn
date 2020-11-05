       <div class="dropdown">
                          <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                             <i class="fa fa-filter"></i>
                          </button>
                          <div class="dropdown-menu" style="padding: 20px; top: 40px !important;">
                            <form action="<?=$action ??'';?>" method="get" id="filter_form">

                                <div class="row">



                                  <div class="form-group col-md-12">
                                      <label>ID</label>
                                      <input type="" name="ref" class="form-control" placeholder="Enter ID" value="<?=$sieve['ref'] ?? '';?>">
                                  </div>
                                  



                                    <div class=" form-group col-md-6">
                                        <label>*  Date(From):</label>
                                        <input placeholder="Start" type="date" 
                                        value="<?=$sieve['registration']['start_date'] ??'';?>" 
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
                        