
<?php if ($auth):?>
<datalist id="account_number_list">
  <?php foreach ($auth->trading_accounts as  $account):?> 
    <option><?=$account->account_number;?></option>
  <?php endforeach;?> 
</datalist>
<?php endif;?>

<small>Our Withdrawal process is fast and smooth. Your Funds will appear in your Bank account within 1 hour of confirming your withdrawal request.
</small>
<hr>
<div class="row">
  <div class="col-sm-12">
    
  <form action="<?=domain;?>/withdrawal_crud/complete_order/initialize" class="ajax_for" method="post" data-function="on_complete_order">

    <div class="form-group">
      <label>Account Number</label>
      <input type="number" required="" name="account_number" value="<?=$account_number;?>" class="form-control" list="account_number_list">
      <small class="text-info">* Enter the mt4 trading account number which you want to withdraw from</small>
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
      <label>Bank</label>

      <select name="bank_account_id" class="form-control" required="">
        <option value="">Select Bank</option>
        <?php foreach ($auth->banks->where('status', 'approved') as $key => $bank):?>
          <option value="<?=$bank->id;?>"><?=$bank->financial_bank->bank_name;?></option>
        <?php endforeach;?>
      </select>

      <small class="text-info">* Select your preferred bank account. Withdrawn funds will be sent here. <a class="btn btn-dark btn-sm" href="<?=domain;?>/user/bank-account">Add Bank Account</a></small>

    </div>

    <div class="form-group">
      <label>Amount ($)</label>
      <input type="number" required="" name="amount" class="form-control">
      <small class="text-info">* Enter the amount you intend to withdraw in USD.</small>
    </div>

    <div class="form-group">
      <button class="btn btn-dark"> Submit</button>

    </div>


      
  </form>
  </div>
 
</div>