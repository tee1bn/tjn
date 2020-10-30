<?php 
    $page_title = $post->title;
    $page_description = $post->intro();
include 'includes/header.php';?>



    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
          <!-- <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index-2.html">Home</a>
                </li>
                <li class="breadcrumb-item"><a href="#">Gallery</a>
                </li>
                <li class="breadcrumb-item active">Gallery Media Grid
                </li>
              </ol>
            </div>
          </div>

 -->
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


          <div class="col-md-7">

            <div class="col-xl-12 col-md-12 col-sm-12">
             
                  <?php $this->view('composed/single_post', compact('post')); ?>

                </div>

                <hr>
                <h4 style="text-align: center;">Other Posts</h4>
                <hr>
                <div class="row">
                <?php foreach ($post->other_posts() as $live_post ):

                     $other_post  = $live_post->good();
                   ?>


                    <div class="col-md-4">
                      <div class="card" style="">
                          <div class="card-content">
                            <img class="card-img-top img-fluid" src="<?=domain;?>/<?=$other_post->mainimage;?>" 
                            style="height: 80px; width: 100%; object-fit: cover;" alt="<?=$other_post->url_title();?>">
                            <div class="card-body">
                              <h4 class="card-title"><a href="<?=domain;?>/<?=$other_post->url();?>"><?=$other_post->shortTitle;?> </a></h4>
                              <p class="card-text"><?=$other_post->shortIntro;?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                  <?php endforeach;?>

                </div>


          </div>

          <?php include 'includes/blog_sidebar.php';?>

        </div>


        </div>
      </div>
    </div>
    <!-- END: Content-->

    <?php //include 'includes/cutomiser.php';?>


<?php include 'includes/footer.php';?>