<?php include 'includes/header.php';?>

  </td></tr></tbody></table>


    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
      <b style="color: #777777; text-transform: lowercase;"></b>

                       <?php

                                $message =  CMS::fetch('welcome_email');

                                $message = str_replace("[FIRSTNAME]", "<b>$auth->firstname</b>", $message);
                                $message = str_replace("[LASTNAME]", "<b>$auth->lastname</b>", $message);
                                $message = str_replace("[FULLNAME]", "<b>$auth->fullname</b>", $message);
                                $message = str_replace("[USERNAME]", "<b>$auth->username</b>", $message);

                                echo $message;?>
    </div>

  </td></tr></tbody></table>
</td></tr></tbody></table>
    






<?php include 'includes/footer.php';?>