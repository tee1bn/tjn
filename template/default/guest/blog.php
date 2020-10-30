<?php 
$page_title = 'Trade forex market easily from Nigeria';
$page_description = "";

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

             <?php if($posts->isNotEmpty()):?>
                 <?php foreach ($posts as $live_post): 
                  $post = $live_post->good();
                  ?>
                     <div class="card">
                       <div class="card-content">
                         <img class="card-img-top img-fluid" src="<?=domain;?>/<?=$post->mainimage;?>" alt="<?=$post->title;?>"
                         style="height: 180px;width: 100%;object-fit: cover;">
                         <div class="card-body">
                           <h4 class="card-title"><a href="<?=domain;?>/<?=$post->url();?>"><?=$post->title;?></a></h4>

                           <p class="card-text">
                             <small class="text-muted"><b><i class="ft-clock"></i> </b><?=date("M j Y h:iA" , strtotime($post->created_at));?>
                              <!-- <i class="ft-user"></i> <?=$post->author->firstname;?>
                              <b>views: </b><?=$post->views;?> -->
                            </small>
                           </p>
                           <p><?=$post->intro();?></p>
                         </div>
                       </div>
                     </div>


                 <?php endforeach ;?>
            <?php else :?>

                 <div class="post card" style="margin: auto;margin-bottom: 15px;" >
                     <center class="card-body">No Posts Found</center>
                 </div>
                 <br>

             <?php endif ;?>


            <div class="col-xl-12 col-md-12 col-sm-12">
                  <div class="pagination" style="margin-left: 10px; ">
                    <?=$this->pagination_links($for_pages, $this->per_page);?>
                  </div>
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