
      
           <div id="how-to" class="card">
             <div class="card-content collapse show" id="course_description">
                 <div class="card-body">
                  <div class="cover">
                    <div class="">
                     <?php if ($product->CoverLinkArray['type'] == 'video'):?>
                         <iframe class="cover-video" src="<?=$product->CoverLinkArray['link'];?>?amp;controls=0&amp;showinfo=0" allowfullscreen></iframe>
                        <?php elseif ($product->CoverLinkArray['type'] == 'image'):?>
                         <img src="<?=$product->CoverLinkArray['link'];?>" class="d-block w-100 cover-video" alt="<?=$product->name;?>">
                     <?php endif;?>
                 </div>
              </div>
              <hr>
              <h4 class="card-title"><?=$product->name;?></h4>
              <!-- <p class="card-text"><small class="text-muted">By <?=$product->user->username ?? '';?></small></p> -->
              <p class="card-text"> <?=$product->description;?> </p>


        </div>
    </div>
 </div>