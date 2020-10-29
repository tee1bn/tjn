


<?php
	$user_local_bank = v2\Models\UserWithdrawalMethod::for($auth->id, 'local_bank');
	$local_bank_details = @$user_local_bank->MethodDetails;
  $financial_banks = v2\Models\FinancialBank::all();

;?>

 <?=$local_bank_details['account_name'] ?? '';?>
<!-- 
<div class="form-group">
  <label>Account Holder</label>
  <input type="text"
   placeholder="Enter Account Name" value="<?=$local_bank_details['account_name'] ?? '';?>" name="details[account_name]" required="" class="form-control">
</div> -->

<div class="form-group">
  <label>Account Number</label>
  <input type="text"
   placeholder="Enter Account Number" value="<?=$local_bank_details['account_number'] ?? '';?>" name="details[account_number]" required="" class="form-control">
</div>

<div class="form-group">
  <label>Bank</label>

  <select name="details[bank_id]" class="form-control" required="">
    <option value="">Select</option>
    <?php foreach ($financial_banks as  $bank):?> 
      <option value="<?=$bank->id;?>" <?=($bank->id==$local_bank_details['bank_id']) ? 'selected' :'';?> ><?=$bank->bank_name;?></option>
    <?php endforeach ;?> 

  </select>

</div>
