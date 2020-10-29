<?php
  $user_meta = $user->user_meta->keyBy('meta_key')->toArray();
;?>

<center>Student Detail</center>
<table class="table table-striped table-sm">
 
    <tr>
      <td>Last Name </td>
      <td><?=$user_meta['last_name']['meta_value'];?></td>
    </tr>
    <tr>
      <td>First Name </td>
      <td><?=$user_meta['first_name']['meta_value'];?></td>
    </tr>
    <tr>
      <td>Email</td>
      <td><?=$user['user_email'];?></td>
    </tr>

    <tr>
      <td>Registration date</td>
      <td><?=date("M j, Y", strtotime($user['user_registered']));?></td>
    </tr>
</table>
