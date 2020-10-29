<div class="dropdown">
    <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-filter"></i>
    </button>
    <div class="dropdown-menu" style="padding: 20px;">
        <form action="<?=$action ?? '';?>" method="get" id="filter_form">
            <div class="row">

                <div class="form-group col-sm-12">
                    <label>Owner Name</label><br>
                    <input type="" name="name" placeholder="First or Last Name" class="form-control" value="<?=$sieve['name']??'';?>">
                </div>

                <div class="form-group col-sm-12">
                    <label>Company Name</label><br>
                    <input type="" name="company_name" placeholder="Name or Office Email or Office Phone" class="form-control" value="<?=$sieve['company_name']??'';?>">
                </div>
            </div>

           

            <div class="row">

<!-- 
                <div class="form-group col-md-6">
                    <label>Status</label>
                    <select class="form-control" name="doc_status">
                        <option value="">Select</option>
                        <?php foreach(v2\Models\UserDocument::$statuses as $key => $value) :?>
                            <option value="<?=$key;?>" <?=((isset($sieve['doc_status'])) && (intval($sieve['doc_status'])===$key))?'selected':'';?>> <?=$value;?></option>
                        <?php endforeach ; ?>
                    </select>

                </div>
 -->
            </div>


            <div class="row">

<!-- 
                <div class="form-group col-md-6">
                    <label>Country</label>
                    <select class="form-control" name="country">
                        <option value="">Select Country</option>
                        <?php foreach (World\Country::all() as $key => $country) :?>
                            <option <?=((isset($sieve['country'])) && ($sieve['country']==(int)$country->id)) ?'selected':'';?>
                                    value="<?=$country->id;?>"><?=$country->name;?></option>
                        <?php endforeach ;?>
                    </select>
                </div> -->
            </div>
            <div class="row">
                <div class=" form-group col-sm-6">
                    <label>*  Created(From):</label>
                    <input placeholder="Start" type="date"
                           value="<?=$sieve['registration']['start_date'] ?? '';?>"
                           class="form-control" name="registration[start_date]">
                </div>


                <div class=" form-group col-sm-6">
                    <label>* Created (To)</label>
                    <input type="date" placeholder="End "
                           value="<?=$sieve['registration']['end_date'] ?? '';?>"
                           class="form-control" name="registration[end_date]">
                </div>


            </div>


            <div class="form-group">
                <button type="Submit" class="btn btn-primary">Submit</button>
<!--                <button type="reset"  class="reset btn btn-primary">Reset</button>-->
            </div>
        </form>

    </div>
</div>
                        