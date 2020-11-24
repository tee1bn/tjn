<?php 

include 'includes/header.php';?>




<div class="app-content container center-layout mt-2">
  <div class="content-wrapper">
    <div class="content-header row">
          <!-- <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title mb-0"> Shop</h3>
            <div class="row breadcrumbs-top">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?=domain;?>">Home</a></li>
                  <li class="breadcrumb-item active"><a href="#">All Shop</a></li>
                </ol>
              </div>
            </div>
          </div> -->

          <div class="content-header-right col-md-6 col-12">

          </div>

          <?php if (isset($show_personal)) :?>
            <style>
              .shop-logo{

                width: 100px;
                height: 100px;
                border-radius: 100%;
                object-fit: contain;
                border: 2px solid #eeeff5;
                padding: 2px;
              } 

              .socials{

                position: absolute;
                top: 10px;
                right: 40px;
              }
              
              .banner{

                border: 2px solid #eeeff5;
                text-align: center;
                padding: 2px;
              }
            </style>
            <div class="col-md-12 ">
              <div class="banner" style="text-align: center;">
                    <img class="shop-logo" src="<?=$logo;?>">
                    <br><h3><?=$user->DisplayTradeName;?></h3>
                    <div class="btn-group btn-group-sm socials">
                      <button type="button" class="btn btn-outline-light ">Store</button>
                      <button type="button" class="btn btn-outline-light ">Posts</button>
                    </div>


                <div class="card-content">
                  <div class="card-body">
                    <p class="card-text">Jelly beans sugar plum cheesecake cookie oat cake soufflé.Tootsie roll bonbon liquorice
                    tiramisu pie powder.Donut sweet roll marzipan pastry cookie cake tootsie roll oat cake cookie.</p>
                    <div class="row">
                      
                    <fieldset class="col-7">
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Button on right" aria-describedby="button-addon4">
                        <div class="input-group-append" id="button-addon4">
                          <button class="btn btn-outline-light" type="button"><i class="fa fa-skyatlas"></i></button>
                        </div>
                      </div>
                    </fieldset>                      
                    <div class="col-5">
                      <div class="btn-group">
                        <button type="button" class="btn btn-outline-light ">Store</button>
                        <button type="button" class="btn btn-outline-light ">Posts</button>
                      </div>
                    </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif ;?>
          </div>

          <?php
          $show_affiliate_link = $auth ? $auth->is('affiliate') : false;
          echo $this->buildView("composed/shop/shop", compact('show_affiliate_link'));?>

        </div>
        <br>

      </div>

      <?php //include 'includes/cutomiser.php';?>


      <?php include 'includes/footer.php';?>