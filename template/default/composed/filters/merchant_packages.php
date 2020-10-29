<div class="dropdown" style="display: block">
    <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-filter"></i>
    </button>
    <div class="dropdown-menu" style="padding: 20px;">
        <form action="<?=$action ?? '';?>" method="get" id="filter_form">
            <div class="row">

                <div class="form-group col-sm-6">
                    <label>Merchant ID</label><br>
                    <input type="text" placeholder="Merchant Id" name="id" class="form-control" value="<?=$sieve['id']??'';?>">
                </div>


            </div>


            <div class="row">
                <div class=" form-group col-sm-6">
                    <label>*  Registration(From):</label>
                    <input placeholder="Start" type="date"
                           value="<?=$sieve['registration']['start_date'] ?? '';?>"
                           class="form-control" name="registration[start_date]">
                </div>


                <div class=" form-group col-sm-6">
                    <label>* Registration (To)</label>
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
                        