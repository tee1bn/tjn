


<?php
	$user_skrill = v2\Models\UserWithdrawalMethod::for($auth->id, 'skrill');
	$skrill_details = @$user_skrill->DetailsArray;

;?>


<div class="form-group">
  <label>Email Address</label>
  <input type="email"
   placeholder="Enter Skrill Email Address" value="<?=$skrill_details['email_address'] ?? '';?>" name="details[email_address]" required="" class="form-control">
</div>
