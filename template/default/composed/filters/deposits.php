<div class="row">

    <div class="dropdown col-md-6">
        <button class="btn btn-dark btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="fa fa-filter"></span>
        </button>
        <ul class="dropdown-menu" style="padding: 20px;">
            <form action="<?=$action;?>" method="get" id="filter_form">
                <div class="row">

                    <div class="form-group col-sm-6">
                        <label>Ref</label><br>
                        <input type="" name="ref" class="form-control" value="<?=$sieve['ref'] ?? '';?>">
                    </div>
                    

                    <div class="form-group col-sm-6">
                        <label>Name</label><br>
                        <input type="" name="name" placeholder="First, Last, Middle Name, email, phone, or username" class="form-control" value="<?=$sieve['name'] ??'';?>">
                    </div>

                </div>

          
                <div class="row">
                   <div class="form-group col-md-6">
                       <label>Account Number</label><br>
                       <input type="" name="account_number" placeholder="Account number" class="form-control" value="<?=$sieve['account_number'] ?? '';?>">
                   </div>


                    <div class="form-group col-md-6">
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="">Select</option>
                            <?php foreach(v2\Models\DepositOrder::$statuses as $key => $value) :?>
                                <option value="<?=$key;?>" <?=((isset($sieve['status'])) &&  (($sieve['status'])===$key))?'selected':'';?>> <?=$value;?></option>
                            <?php endforeach ; ?>
                        </select>

                    </div>

                </div>

                
                <div class="row">
                    <div class=" form-group col-sm-6">
                        <label>*  Amount (From):</label>
                        <input placeholder="Start" type="number" step="0.0001" 
                        value="<?=$sieve['amount']['start'] ?? '';?>" 
                        class="form-control" name="amount[start]">
                    </div>


                    <div class=" form-group col-sm-6">
                        <label>* Amount (To)</label>
                        <input type="number" step="0.0001" placeholder="End "
                            value="<?=$sieve['amount']['end'] ?? '';?>" 
                         class="form-control" name="amount[end]">
                    </div>                    
                </div>

                

                
                <div class="row">
                
                    <div class="form-group col-md-6">
                        <label>Paid Status</label>
                        <select class="form-control" name="payment_status">
                            <option value="">Select</option>
                            <?php foreach (['unpaid'=> 'UnPaid' , 'paid'=> 'Paid' ,] as $key => $value):?>
                                <option <?=( (isset($sieve['payment_status'])) && ($sieve['payment_status']==$key)) ?'selected':'';?> value="<?=$key;?>"> 
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
                                <option <?=(($sieve['payment_method']) &&  ($sieve['payment_method']==$value['name'])) ?'selected':'';?> value="<?=$value['name'];?>"> 
                                    <?=$value['name'];?>
                                </option>
                            <?php endforeach ;?>
                        </select>
                    </div>

                </div>
                

                <div class="row">
                    <div class=" form-group col-sm-6">
                        <label>*  Date (From):</label>
                        <input placeholder="Start" type="date" 
                        value="<?=$sieve['registration']['start_date'] ?? '';?>" 
                        class="form-control" name="registration[start_date]">
                    </div>


                    <div class=" form-group col-sm-6">
                        <label>* Date (To)</label>
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

        </ul>
    </div>

    <style>
        hr{
            margin: 5px;
        }
    </style>
</div>
