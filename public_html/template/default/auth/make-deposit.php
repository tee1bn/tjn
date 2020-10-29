
<?php if ($auth):?>
<datalist id="account_number_list">
  <?php foreach ($auth->trading_accounts as  $account):?> 
    <option><?=$account->account_number;?></option>
  <?php endforeach;?> 
</datalist>
<?php endif;?>


<small>Our Deposit process is fast and smooth. Your Funds will appear in your trading account within 10mins of confirming your deposit</small>
<hr>
<div class="row">
  <div class="col-sm-12">
    
  <form action="<?=domain;?>/deposit_crud/complete_order/initialize" class="ajax_for" method="post" data-function="on_complete_order">

    <div class="form-group">
      <label>Account Number</label>
      <input type="number" required="" maxlength="11" name="account_number" value="<?=$account_number;?>" class="form-control" list="account_number_list">
      <small class="text-info">* Enter the mt4 trading account number which you want to fund</small>
    </div>

    <div class="form-group">
      <label>Broker</label>
      <select name="broker_id" class="form-control" required="">
        <option value="">Select Broker</option>
        <?php foreach (v2\Models\Broker::Active()->get() as $key => $broker):?>
          <option <?=($broker_id==$broker->id) ?'selected' : '';?> value="<?=$broker->id;?>"><?=$broker->name;?></option>
        <?php endforeach;?>
      </select>
      <small class="text-info">* Select the broker associated with your trading account. Only listed Brokers are currently supported.</small>

    </div>

    <div class="form-group">
      <label>Amount ($)</label>
      <input type="number" step="1" required="" min="5" name="amount" class="form-control">
      <small class="text-info">* Enter the amount you intend to fund in USD.</small>

    </div>

    <div class="form-group">
      <button class="btn btn-dark"> Submit</button>

    </div>


      
  </form>
  </div>
 
</div>