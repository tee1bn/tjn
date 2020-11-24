<?php 

$page_title = $user->DisplayTradeName;
$page_description= "";

include 'includes/header.php';?>



          <?php
          $show_affiliate_link = $auth ? $auth->is('affiliate') : false;
          $request_url = "$domain/shop/market/?seller_id=$user->id";
          echo $this->buildView("composed/shop/shop", compact('show_affiliate_link','user', 'request_url'));?>
	     <br>

        </div>

      </div>



      <?php include 'includes/footer.php';?>
