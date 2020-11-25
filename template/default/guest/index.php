<?php 
$page_title = '';
$page_description = "";

include 'includes/header.php';?>



    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
    
        <div class="row">


          <style>
            
            img.d-block{

              height: 250px;
              object-fit: cover;
            }
            .slider-text{
              
              position: absolute;
              background: #00b5b840;
              z-index: 9;
              top: 101px;
              color: white;
              left: 101px;
            }
          </style>


          <div class="col-md-12">

            <div class="col-md-12 col-sm-12">
                  <div class="card" style="">
                    <div class="card-content">
                      <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                          <li data-target="#carousel-example-generic" data-slide-to="0" class=""></li>
                          <li data-target="#carousel-example-generic" data-slide-to="1" class="active"></li>
                          <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                        </ol>
                        <!-- <div class="slider-text">We are The best</div> -->
                        <div class="carousel-inner" role="listbox" style="display: none;">
                          <div class="carousel-item">
                            <img src="<?=general_asset;?>/img/image1.jpg" class="d-block w-100" alt="<?=project_name;?> trading slide">
                          </div>
                          <div class="carousel-item active">
                            <img src="<?=general_asset;?>/img/image1.jpg"  class="d-block w-100" alt="<?=project_name;?> trading slide">
                          </div>
                          <div class="carousel-item">
                            <img src="<?=general_asset;?>/img/image1.jpg"  class="d-block w-100" alt="<?=project_name;?> trading slide">
                          </div>
                        </div>
                        <a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
                          <span class="fa fa-angle-left icon-prev" aria-hidden="true"></span>
                          <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
                          <span class="fa fa-angle-right icon-next" aria-hidden="true"></span>
                          <span class="sr-only">Next</span>
                        </a>
                      </div>
                        <div class="card-body">
                          <h4 class="card-title">What is Salesra</h4>
                          <p class="card-text">
                           1)  Salesra is a simple solution for <b>creators</b> like you looking to sell fast/more digital products/services
                            without worrying about all the technical headache. 
                           </p>



                            <p class="card-text">
                            2)  Salesra is a stop for quality digital products by experts you can be proud to recommend as an <b>afilliate</b>. We pay affiliates every Friday. 
                           </p>
                           
                           <br>
                           <b> Registration is currently Free</b>                     


                            <br>  
                            <br>  
                            <a href="<?=domain;?>/register" class="btn btn-outline-light">Sign up</a>
                            <a href="<?=domain;?>/login" class="btn btn-outline-light">Log in</a>
                            <a href="<?=domain;?>/login" class="btn btn-outline-light"><i class="fa fa-telegram"></i> Learn More</a>

                            
                        </div>
                    </div>




                  </div>

              

                  <!-- <h4 style="text-align: center;">Blogs</h4> -->

                                            
                 <!--  <div class="card text-white border-0 box-shadow-0" style="">


                  </div>

                  <hr>
                  <hr>
                  <h4 style="text-align: center; display:none;">Blogs</h4>
                  <hr> -->

                  <div class="card text-white border-0 box-shadow-0" style="display:none ;">
                           
                           <div class="row">
                           <?php foreach (Post::recent_posts(3) as $live_post ):
                            $other_post  = $live_post->good();
                            ?>

                               <div class="col-md-4">
                                 <div class="card" style="border: 1px solid #00000012;padding: 5px;">
                                     <div class="card-content">
                                       <img class="card-img-top img-fluid" src="<?=domain;?>/<?=$other_post->mainimage;?>" 
                                       style="height: 80px; width: 100%; object-fit: cover;" alt="<?=$other_post->url_title();?>">
                                       <div class="card-body" style="color: #000000ad !important;">
                                         <h4 class="card-title"><a href="<?=domain;?>/<?=$other_post->url();?>"><?=$other_post->shortTitle;?> </a></h4>
                                         <p style=""><?=$other_post->shortIntro;?></p>
                                         <small class="text-muted"><b> <i class="ft-clock"></i></b> <?=date("M j Y h:iA" , strtotime($other_post->created_at));?>
                                          
                                         <b>
                                            <i class="ft-user"></i></b> <?=$other_post->author->fullname;?>
                                           </small>
                                          <!-- <b><i class="ft-eye"></i> </b>3232 -->
                                       </div>
                                     </div>
                                   </div>
                                 </div>
                             <?php endforeach;?>

                           </div>



                </div>



          

          </div>

          <div class="col-md-12">
            
          </div>



        </div>


        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?php //include 'includes/cutomiser.php';?>


<?php include 'includes/footer.php';?>