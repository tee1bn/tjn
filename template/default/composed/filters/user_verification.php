<div class="row">

    <div class="dropdown col-md-6">
        <button class="btn btn-dark btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
            <span class="fa fa-filter"></span>
        </button>
        <ul class="dropdown-menu" style="padding: 20px;">
            <form action="<?=$action ?? '';?>" method="get" id="filter_form">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Name</label><br>
                        <input type="" name="name" placeholder="First, Last, Middle Name, email, phone, or username" class="form-control" value="<?=$sieve['name']??'';?>">
                    </div>
                </div>

          
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Type</label>
                        <select class="form-control" name="type">
                            <option value="">Select</option>
                            <?php foreach(v2\Models\UserDocument::$document_types as $key => $value) :?>
                                <option value="<?=$key;?>" <?=((isset($sieve['type'])) &&($sieve['type']==$key))?'selected':'';?>> <?=$value['name'];?></option>
                            <?php endforeach ; ?>
                        </select>

                    </div>
                    <div class="form-group col-md-6">
                        <label>Status</label>
                        <select class="form-control" name="status">
                            <option value="">Select</option>
                            <?php foreach(v2\Models\UserDocument::$statuses as $key => $value) :?>
                                <option value="<?=$key;?>" <?=(isset($sieve['status']) &&(intval($sieve['status'])===$key))?'selected':'';?>> <?=$value;?></option>
                            <?php endforeach ; ?>
                        </select>

                    </div>

                </div>
                <div class="row">
                    <div class=" form-group col-sm-6">
                        <label>*  Date (From):</label>
                        <input placeholder="Start" type="date" 
                        value="<?=$sieve['registration']['start_date']??'';?>" 
                        class="form-control" name="registration[start_date]">
                    </div>


                    <div class=" form-group col-sm-6">
                        <label>* Date (To)</label>
                        <input type="date" placeholder="End "
                            value="<?=$sieve['registration']['end_date']??'';?>" 
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
