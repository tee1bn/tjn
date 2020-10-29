<?php include 'includes/header.php';?>

  </td></tr></tbody></table>


    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
      <b style="color: #777777; text-transform: lowercase;"></b>

                       <?php
                                $message =  CMS::fetch('user_transfer_receiver_email');
                                $link = "$domain/register/confirm_email/$auth->email_verification/$auth->email";
                                $button = "<a href='$link' style='background:#77b76a; color:white; border: 1px solid green; padding: 10px;'>Confirm</a>";

                                $timestamp = date("M j, Y H:iA", strtotime($debit->paid_at));

                                $message = str_replace("[AMOUNT]", "<b>$debit->amount</b>", $message);
                                $message = str_replace("[SENDER]", "<b>{$debit->user->username}</b>", $message);
                                $message = str_replace("[RECEIVER]", "<b>{$credit->user->username}</b>", $message);
                                $message = str_replace("[FEE]", "<b>{$fee->amount}</b>", $message);
                                $message = str_replace("[TIMESTAMP]", "<b>$timestamp</b>", $message);

                                echo $message;?>
    </div>


  </td></tr></tbody></table>
</td></tr></tbody></table>
    






<?php include 'includes/footer.php';?>