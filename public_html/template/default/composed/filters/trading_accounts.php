<div class="row">

    <div class="dropdown col-md-6">
        <button class="btn btn-dark btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="fa fa-filter"></span>
        </button>
        <ul class="dropdown-menu" style="padding: 20px;">
            <form action="<?=$action;?>" method="get" id="filter_form">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Name</label><br>
                        <input type="" name="name" placeholder="First, Last, Middle Name, username, email, phone" class="form-control" value="<?=$sieve['name'];?>">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                      <label>Is LPR</label>
                      <select name="is_lpr" class="form-control">
                        <option value="">Select </option>
                        <?php foreach ([1=> 'Yes', 0=> 'No'] as $key => $value) :?>
                          <option <?=($sieve['is_lpr']==$key) ?'selected' : '';?> value="<?=$key;?>"><?=$value;?></option>
                        <?php endforeach;?>
                      </select>
                    </div>

                    <div class="form-group col-md-6">
                      <label>Is Active</label>
                      <select name="is_active" class="form-control">
                        <option value="">Select </option>
                        <?php foreach ([1=> 'Yes', 0=> 'No'] as $key => $value) :?>
                          <option <?=($sieve['is_active']==$key) ?'selected' : '';?> value="<?=$key;?>"><?=$value;?></option>
                        <?php endforeach;?>
                      </select>
                    </div>

               
                </div>


                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Account Number</label>
                        <input type="number" name="account_number" value="<?= $sieve['account_number']; ?>" class="form-control">
                    </div>


                    <div class="form-group col-md-6">
                      <label>Broker</label>
                      <select name="broker" class="form-control" >
                        <option value="">Select Broker</option>
                        <?php foreach (v2\Models\Broker::Active()->get() as $key => $broker):?>
                          <option <?=($sieve['broker']==$broker->id) ?'selected' : '';?> value="<?=$broker->id;?>"><?=$broker->name;?></option>
                        <?php endforeach;?>
                      </select>
                    </div>

       

                </div>


               

                <div class="row">
                    <div class=" form-group col-sm-6">
                        <label>*  Registration (From):</label>
                        <input placeholder="Start" type="date" 
                        value="<?=$sieve['registration']['start_date'];?>" 
                        class="form-control" name="registration[start_date]">
                    </div>


                    <div class=" form-group col-sm-6">
                        <label>* Registration (To)</label>
                        <input type="date" placeholder="End "
                            value="<?=$sieve['registration']['end_date'];?>" 
                         class="form-control" name="registration[end_date]">
                    </div>

                    
                </div>


                <div class="form-group">
                    <button type="Submit" class="btn btn-primary">Submit</button>
                    <!-- <a  onclick="$('#filter_form').reset()">Reset</a> -->
                </div>
            </form>

        </ul>
    </div>

    <style>
        hr{
            margin: 5px;
        }
    </style>
</div>
