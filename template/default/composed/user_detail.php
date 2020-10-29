<table class="table table-striped table-sm">
  
    <tr>
      <td>Sex(Verification)</td>
      <td><?=$user->DisplayGender;?>  <?=$user->VerifiedBagde;?></td>
    </tr>
    <tr>
      <td>Name  (L M F)</td>
      <td><?=$user->DisplayTitle;?> <?=$user->fullname;?></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><?=$user->email;?> <?=$user->emailVerificationStatus;?></td>
    </tr>
    <tr>
      <td>Phone</td>
      <td><?=$user->phone;?> <?=$user->phoneVerificationStatus;?></td>
    </tr>
    <tr>
      <td>Address</td>
      <td><?=$user->address;?></td>
    </tr>
   
    <tr>
      <td>State, Country</td>
      <td><?=$user->decoded_state->name;?>, <?=$user->decoded_country->name;?></td>
    </tr>
    <tr>
      <td title="date of birth(DOB)">DOB (Age)</td>
      <td><?=$user->birthdate;?> (<?=$user->Age;?>yrs)</td>
    </tr>
    <tr>
      <td>Registration date</td>
      <td><?=date("M j, Y", strtotime($user->created_at));?></td>
    </tr>
</table>
