

<?php
	$user_payeer = v2\Models\UserWithdrawalMethod::for($auth->id, 'payeer');
	$payeer_details = @$user_payeer->DetailsArray;

;?>


<div class="form-group">
  <label>Payeer ID</label>
  <input type="" placeholder="Enter Payeer ID" value="<?=$payeer_details['payeer_id'] ?? '';?>" name="details[payeer_id]" required="" class="form-control">
</div>
