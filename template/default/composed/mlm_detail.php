<?php
$sponsor = User::where('mlm_id' , $user->referred_by)->first();
$today = date("Y-m-d");

$week = MIS::date_range($today, 'week', true);

/*$daterange = SiteSettings::binary_daterange();
extract($daterange);
*/



// $already_paid = v2\Models\Commission::where('user_id', $user->id)->Completed()->Paid()->sum('binary_points');


$life_personal_volume =  ($user->total_volumes('all', 'enrolment', [], 'volume', 'personal'));
$life_group_volume =  ($user->total_volumes('all', 'enrolment', [], 'volume', 'group'));



$life_group_points =  ($user->total_volumes('all', 'enrolment', [], 'points', 'group'));
$life_personal_points =  ($user->total_volumes('all', 'enrolment', [], 'points', 'personal'));



$membership_status = $user->MembershipStatusDisplay;
$binary_status = $user->BinaryStatusDisplay;
;?>


<a class="dropdown-item text-sm" href="#" style="padding: 0px;">
  <table class="mlm_detail table table-borderless " style="border: none;margin: 0px;margin-bottom: 3px;">
    <tr>
      <td colspan ="2" style="text-align: center; color:#073f2dc7; border-bottom: 1px solid #073f2dc7;"> <b><?=$user->fullname;?> </b></td>
    </tr>

    <tr>
      <td>
        <small class="label">User</small><br>
        <em class="label-value">- <?=$user->username;?></em>

      </td>
      <td>

        <small class="label">Sponsor</small><br>
        <em class="label-value">- <?=$sponsor->username ?? 'Nil';?></em>
      </td>
    </tr>


<!-- 
    <tr>
      <td>
        <small class="label">Membership</small> <br>
        <em class="label-value">- <b><?=$membership_status;?></b></em>
      </td>


      <td>
        <small class="label">Pack</small><br>
        <em class="label-value">- <?=$pack->ExtraDetailArray['investment']['name'] ?? 'Nil';?></em></td>

      </tr>
 -->
      <tr>
        <td>

        </td>

        <td>

         <em>
          <small class="label">Rank</small><br>
          <em class="label-value">- <?=$user->TheRank['name'];?>
        </em>
      </em>
    </td>
  </tr>
  


</table>


<table class="mlm_detail table table-borderless " style="border: none;margin: 0px;margin-bottom: 3px; margin-top: 7px;margin-bottom: 10px;">
    <tr>
      <td colspan ="2" style="text-align: center; color:#073f2dc7;"> <b>VOLUMES </b></td>
    </tr>


  <tr>
    <td title="Life Personal Volume">
      <small class="label">
         LPV
      </small> <br> <em class="badge badge-sm bg-secondary">
        <?=$currency;?><?=MIS::money_format($life_personal_volume);?>
      </em>
    </td>

    <td>
      <small class="label">
       LGV

     </small><br>
     <em class="badge badge-sm bg-secondary">
      <?=$currency;?><?=MIS::money_format($life_group_volume);?>
    </em>
  </td>
</tr>
<tr>
  <td>
    <small class="label">LPP</small><br>
    <em class="badge badge-sm bg-secondary"><?=($life_personal_points);?></em>
  </td>
  <td>
    <small class="label">LGP</small><br> 
    <em class="badge badge-sm bg-secondary"><?=($life_group_points);?></em>
  </td>
</tr>

</table>
</a>