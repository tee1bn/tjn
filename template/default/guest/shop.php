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



          <?php// include_once 'template/default/merchant/banner.php';?>

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
                        <!-- <button type="button" class="btn btn-outline-light ">Store</button> -->
                        <button type="button" class="btn btn-outline-light " data-toggle="modal" data-target="#myModal">Contact</button>
                      </div>
                    </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>


              <!-- The Modal -->
              <div class="modal" id="myModal">
                <div class="modal-dialog">
                  <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Modal Heading</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">

                      <?php if ($auth) :?>
                      <!-- Contact FORM -->
                      <form class="contact-form" id="contact" method="post" action="<?=domain;?>/ticket_crud/create_ticket">
                          <div class="row">
                              <div class="col-md-12 col-lg-12">

                                  <div class="form-field">
                                      <input  class="form-control"
                                      value="<?=$auth->full_name;?>" 
                                      readonly="readonly"
                                      id="name" type="hidden" required="" name="full_name" placeholder="Your Name">

                                      <input  class="form-control" id="email"
                                      value="<?=$auth->email;?>" 
                                      readonly="readonly"
                                       type="hidden" required="" name="email" placeholder="Email">
                                  </div>
                                  <div class="form-field">
                                      <input  class="form-control" id="sub"
                                      value="<?=$auth->phone;?>" 
                                      readonly="readonly"
                                       type="hidden" required="" name="phone" placeholder="Phone">
                                  </div>

                                  <input type="hidden" name="from_client" value="true">

                              </div>
                              <div class="col-md-12 col-lg-12">
                                  <div class="form-field">

                                      <textarea class="form-control" id="message" rows="7" name="comment" required=""
                                       placeholder="Your Message"></textarea>
                                  </div>
                              </div>
                              <div class="col-md-6 col-offset-md-2">
                                  <br>
                                  <?=MIS::use_google_recaptcha();?>
                              </div>


                              <div class="col-md-12 col-lg-12 mt-30">
                                  <button class=" btn" type="submit" id="submit" name="button">
                                      Send Message
                                  </button>
                              </div>
                          </div>
                      </form>
                      <!-- END Contact FORM -->
                      <?php else:?>
                        <form class="form ajax_form" id="contact" method="post" action="<?=domain;?>/home/contact_us">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">

                                    <div class="form-group">
                                        <input class="form-control" id="name" type="text" required="" name="full_name" placeholder="Your Name">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" id="email" type="text" required="" name="email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" id="sub" type="text" required="" name="phone" placeholder="Phone">

                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <div class="form-group">

                                        <textarea class="form-control" id="message" rows="4" name="comment" required=""
                                         placeholder="Your Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <br>
                                    <?=MIS::use_google_recaptcha();?>
                                </div>


                                <div class="col-md-12 col-lg-12 mt-30">
                                    <button class="btn-dark btn" type="submit" id="submit" name="button">
                                        Send Message
                                    </button>
                                </div>
                            </div>
                        </form>                     
                      <?php endif;?>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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