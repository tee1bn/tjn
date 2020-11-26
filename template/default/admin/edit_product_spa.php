<?php
$page_title = "Products";
include 'includes/header.php';

$allowed_file_for_cover = ['image/*','video/*'];
;?>
  
  
  
  <?php
  $user_type= 'admin';
  $this->view('composed/edit_product', compact('product','user_type'));?>


<?php include 'includes/footer.php';?>