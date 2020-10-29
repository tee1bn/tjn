
<table class="table table-striped table-sm">
  
    <tr>
      <td style="width:20px !important;">Sex(Verification)</td>
      <td><?=$user->DisplayGender;?> </td>
    </tr>
    <tr>
      <td style="width:20px !important;">Name  (L M F)</td>
      <td><?=$user->DisplayTitle;?> <?=$user->fullname;?></td>
    </tr>
    <tr>
      <td style="width:20px !important;">Email</td>
      <td><?=$user->email;?> <?=$user->emailVerificationStatus;?></td>
    </tr>
    <tr>
      <td style="width:20px !important;">Phone</td>
      <td><?=$user->phone;?> <?=$user->phoneVerificationStatus;?></td>
    </tr>
    <tr>
      <td style="width:20px !important;">Address</td>
      <td><?=$user->address;?></td>
    </tr>
   
    <tr>
      <td style="width:20px !important;">State, Country</td>
      <td><?=$user->decoded_state->name;?>, <?=$user->decoded_country->name;?></td>
    </tr>
    <tr>
      <td title="date of birth(DOB)">DOB (Age)</td>
      <td><?=$user->DOB;?></td>
    </tr>
    <tr>
      <td style="width:20px !important;">Reg date</td>
      <td><?=date("M j, Y H:iA", strtotime($user->created_at));?></td>
    </tr>
</table>
