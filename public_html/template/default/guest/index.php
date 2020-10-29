<?php 
$page_title = 'OctaFx in Nigeria -Trade with OctaFx from Nigeria';
$page_description = "";

include 'includes/header.php';?>



    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
    
        <div class="row">

          <?php include 'includes/sidebar.php';?>

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


          <div class="col-md-9">

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
                        <div class="carousel-inner" role="listbox">
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
                          <a href="https://my.octafx.com/signup/?refid=ib2547685"><h4 class="card-title">OctaFx in Nigeria</h4></a>
                          <p class="card-text"><a href="<?=domain;?>">9gforex.com</a> is a fast-paced channel through which 
                            <a href="https://my.octafx.com/signup/?refid=ib2547685">OctaFx</a> is serving forex to Nigerians in the most convenient way!
                           </p>
                           <p class="card-text">
                            With us, you are able to enjoy seamless forex services from Brokers that are worth it. This is what we mean in 3 simple steps
                            <ul>
                              <li>Create a profile with us <a href="<?=domain;?>/register">here</a></li>
                              <li>Don't know much about forex? Take the <a href="<?=domain;?>/shop/full-view/1/course/Forex-101">Forex 101</a> beginner course and set yourself up for raining pips. It is FREE!</li>
                                 <li class="nav-item">
                                  <a href="javascript:void(0);" class=" -link dropdown-toggle" data-toggle="dropdown">Open a trading account </a>with any listed broker of your choice.
                                  <div class="dropdown-menu">
                                    <?php foreach ($brokers_in_header as $key => $broker_in_header) :?>
                                     <a class="dropdown-item" target="_blank" href="<?=domain;?>/forex-account/open-live-account/<?=MIS::dec_enc('encrypt',$broker_in_header->id);?>"><small>Open <b><?=$broker_in_header->name;?></b> Live Account</small></a>
                                    <?php endforeach;?>
                                  </div>
                                </li>

                              <li><a href="<?=domain;?>/user/make-deposit">Fund your account</a>, trade, make profit, <a href="<?=domain;?>/user/make-withdrawal">withdraw</a>. Rinse and repeat</li>
                                
                               <li class="nav-item">
                                Are you too busy to trade? you can
                                <a href="javascript:void(0);" class=" -link dropdown-toggle" data-toggle="dropdown">copy successful traders </a>.
                                <div class="dropdown-menu">
                                  <?php foreach ($brokers_in_header as $key => $broker_in_header) :?>
                                    <a class="dropdown-item" target="_blank" href="<?=$broker_in_header->DetailsArray['copy_trading'];?>">
                                     <small><b><?=$broker_in_header->name;?></b> Copy Trading</small></a>
                                  <?php endforeach;?>
                                </div>
                              </li>


                              <br>
                              <a href="<?=domain;?>/register" class="btn btn-outline-success">Sign me up</a>
                              <a href="<?=domain;?>/login" class="btn btn-outline-success">Log in</a>
                            </ul>
                              


                           </p>
                           <div class="card-text">
                           </div>
                        </div>
                    </div>




                  </div>

                  <div class="card text-white border-0 box-shadow-0">
                            <div class="card-content">
                              <img class="card-img img-fluid" style="height:260px; width: 100%; object-fit: cover;" src="<?=general_asset;?>/img/image1.jpg" alt="Forex Profit Academy">
                              <div class="card-img-overlay overlay-cyan">
                                <h4 class="card-title">Fx Academy</h4>

                              
                                <p class="">
                                  The educational tutorials are intended to take beginners from their level to the professional and profitable trader level using definite step by step and actionable plans. 
                                </p>

                             <blockquote class="blockquote">
                               <p class="mb-0">The more you learn, the more you earn.</p>
                               <footer class="blockquote-footer">Warren Buffett <cite title="">Reknowned Investor</cite></footer>
                             </blockquote>

                                  <a href="<?=domain;?>/fx-academy" class="btn btn-dark">Learn more</a>
                              </div>
                            </div>
                          </div>


                  <hr>
                  <h4 style="text-align: center; display: ;">Blogs</h4>
                  <hr>

                                            
                  <div class="card text-white border-0 box-shadow-0" style="display: ;">
                           
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