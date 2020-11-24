<?php 

$page_title = $user->DisplayTradeName;
$page_description= "";

include 'includes/header.php';?>



          <?php
          $show_affiliate_link = $auth ? $auth->is('affiliate') : false;
          echo $this->buildView("composed/shop/shop", compact('show_affiliate_link'));?>
	     <br>

        </div>

      </div>



      <?php include 'includes/footer.php';?>
