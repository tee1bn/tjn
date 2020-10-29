<?php include 'includes/header.php';?>

  </td></tr></tbody></table>


    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
      <b style="color: #777777; text-transform: lowercase;"></b>

                       <?php
                                $message =  CMS::fetch('email_verification');
                                $link = "$domain/register/confirm_email/$auth->email/$auth->email_verification";
                                $button = "<a href='$link' style='background:#77b76a; color:white; border: 1px solid green; padding: 10px;'>Confirm</a>";

                                $message = str_replace("[FIRSTNAME]", "<b>$auth->firstname</b>", $message);
                                $message = str_replace("[LASTNAME]", "<b>$auth->lastname</b>", $message);
                                $message = str_replace("[FULLNAME]", "<b>$auth->fullname</b>", $message);
                                $message = str_replace("[USERNAME]", "<b>$auth->username</b>", $message);
                                $message = str_replace("[LINK]", "$link", $message);
                                $message = str_replace("[EMAIL_CODE]", "$auth->email_verification", $message);

                                echo $message;?>
    </div>

  </td></tr></tbody></table>
</td></tr></tbody></table>
    






<?php include 'includes/footer.php';?>