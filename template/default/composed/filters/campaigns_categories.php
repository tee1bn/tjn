       <div class="dropdown">
                          <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                             <i class="fa fa-filter"></i>
                          </button>
                          <div class="dropdown-menu" style="padding: 20px;">
                            <form action="" method="get" id="filter_form">
                                <div class="row">

                                    <div class="form-group col-sm-12">
                                        <label>Title</label><br>
                                        <input type="" name="title" placeholder="Title" class="form-control" value="<?=$sieve['title'];?>">
                                    </div>


                                    <div class="form-group col-sm-12">
                                        <label>Admin</label><br>
                                        <select class="form-control" name="admin_id"> 
                                            <option value="">Select</option>
                                            <?php foreach (Admin::all() as $key => $admn) :?>
                                            <option <?=$admn->id==$sieve['admin_id']?'selected':'';?> value="<?=$admn->id;?>"><?=$admn->fullname;?></option>
                                            <?php endforeach ;?>
                                        </select>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class=" form-group col-sm-6">
                                        <label>*  Date (From):</label>
                                        <input placeholder="Start" type="date" 
                                        value="<?=$sieve['created_at']['start_date'];?>" 
                                        class="form-control" name="created_at[start_date]">
                                    </div>


                                    <div class=" form-group col-sm-6">
                                        <label>* Date (To)</label>
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
                        