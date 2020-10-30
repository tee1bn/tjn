          <div class="col-md-2">




            <div class="card" style="">
              <div class="card-content">

              <!--   <div class="card-body">
                  <h4 class="card-title">Categories</h4>

                  <ul class="list-group list-group-flush">
                    <?php foreach (Category::all()->sortBy('category') as $category) :

                    if ((@$this->post->category->id == $category->id) || (@$this->category->id == $category->id)) {
                     $active = 'active';
                   }else{
                    $active ='';
                  }
                  ?>
                  <li class="<?=$active;?> list-group-item" style="padding: 5px; color: white;" >
                    <span class="badge badge-pill bg-primary float-right">4</span>
                    <a style="color:#8a8a8a  !important" href="<?=domain;?>/<?=$category->url_link();?>">
                      <?=ucfirst($category->category);?>
                    </a>
                  </li>
                <?php endforeach ;?>


              </ul>
            </div> -->


            <div class="card-body">
              <h4 class="card-title">Recent Posts</h4><hr>
            </div>

            <div class="card-content">
              <?php foreach (Post::recent_posts(3) as $live_post ):
                $recent_post  = $live_post->good();
                ?>

                <img class="card-img-top img-fluid" src="<?=domain;?>/<?=$recent_post->mainimagesmall;?>" style="height: 80px;width: 100%;object-fit: cover;" alt="<?=$recent_post->url_title();?>">
                <div class="card-body" style="padding-top: 5px;">
                  <h6 class="card-titl" style="margin-bottom: 5px;">
                    <a href="<?=domain;?>/<?=$recent_post->url();?>"><?=$recent_post->ShortTitle;?></a>
                  </h6>
                  <small class="text-muted"><b> <i class="ft-clock"></i></b> <?=date("M j Y h:iA" , strtotime($recent_post->created_at));?>
                   <!-- <b><i class="ft-user"></i></b> <?=$recent_post->author->firstname;?>  -->
                   <br>
                    <a href="<?=domain;?>/<?=$recent_post->url();?>" class="">Read more</a>
                  </div>

                <?php endforeach;?>

              </div>



            </div>
          </div>

        </div>

