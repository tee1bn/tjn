<?php
$page_title = "Products";
include 'includes/header.php';

$allowed_file_for_cover = ['image/*','video/*'];
;?>
  
  
  <?=$this->view('composed/edit_product', compact('product'));?>


<?php include 'includes/footer.php';?>