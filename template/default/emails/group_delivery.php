<?php include 'includes/delivery_header.php';?>


  <div style='background-color: #F3F1F2'>
                  <div style='max-width: 95%; margin: 0 auto; padding: 10px; font-size: 14px; font-family: Verdana;'>
                      <br>
                        <center style="font-size: 20px;"><?=$order->delivery_heading();?></center>
                      <br>
                      <div style='background-color: #FFFFFF; padding: 15px; margin: 5px 0 5px 0;'>



  </td></tr></tbody></table>


    <div style="font-family: Arial, sans-serif; line-height: 20px; color: #444444; font-size: 13px;">
      <b style="color: #777777; text-transform: lowercase;"></b>
      <p>Your order  is here! </p>
      Order ID:<?=$order->TransactionID;?>
      <p>Please click <a href="<?=$order->after_payment_url();?>">View Content</a></p>

      <p></p>
      <br>
      <br>
      <!-- <div>Share the word!
        <p>
          <a><button class="btn btn-twitter">Twitter</button></a>
          <a><button class="btn btn-facebook">Facebook</button></a>
        </p>
      </div> -->

                       
    </div>

  </td></tr></tbody></table>
</td></tr></tbody></table>
    






<?php include 'includes/footer.php';?>