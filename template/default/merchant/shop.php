<?php 

$page_title = $user->DisplayTradeName;
$page_description= "";

include 'includes/header.php';?>



          <?php
          echo $this->buildView("composed/shop/shop", compact('user', 'request_url'));?>
	     <br>

        </div>

      </div>



      <?php include 'includes/footer.php';?>
