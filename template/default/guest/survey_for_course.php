<?php 
$page_title = 'Survey/Quiz on forex trading';
?>

<link rel="stylesheet" type="text/css" href="<?=$asset;?>/css/bootstrap.min.css">
<script src="<?=asset;?>/js/jquery1.12.min.js"></script>

<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
    </div>
    <div class="content-body">

      <div class="row">

        <div class="card col-md-12" >
          <div class="card-content">
           <div class="card-body">


             <div class="container" style="margin-top: 20px;">

               <?=$questionaire->html_form()->form;?>

             </div>
          </div>
        </div>
      </div>

    </div>


  </div>
</div>
</div>
