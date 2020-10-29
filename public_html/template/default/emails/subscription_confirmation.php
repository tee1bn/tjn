<?php include 'includes/header.php';?>

  </td></tr></tbody></table>


    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
      <b style="color: #777777; text-transform: lowercase;"></b>
                       <?php

                                $message =  $subscription->confirmation_message;

                                $message = str_replace("[FIRSTNAME]", "<b>$user->firstname</b>", $message);
                                $message = str_replace("[LASTNAME]", "<b>$user->lastname</b>", $message);
                                $message = str_replace("[FULLNAME]", "<b>$user->fullname</b>", $message);
                                $message = str_replace("[USERNAME]", "<b>$user->username</b>", $message);

                                echo $message;?>
    </div>

  </td></tr></tbody></table>
</td></tr></tbody></table>
    






<?php include 'includes/footer.php';?>