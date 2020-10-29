<?php
	$user_bitcoin = v2\Models\UserWithdrawalMethod::for($auth->id, 'bitcoin');
	$bitcoin_details = @$user_bitcoin->DetailsArray;

;?>
<div class="form-group">
  <label>Bitcoin Address</label>
  <input type="" placeholder="Enter Bitcoin Address" value="<?=$bitcoin_details['bitcoin_address'] ?? '';?>" name="details[bitcoin_address]" required="" class="form-control">
</div>
