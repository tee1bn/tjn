<div class="card">
  <div class="card-content">
    <img class="card-img-top img-fluid" src="<?=domain;?>/<?=$post->mainimage;?>" 
    style="height: 270px; width: 100%; object-fit: cover;" alt="<?=$post->url_title();?>">
    <div class="card-body">
      <h4 class="card-title"><a href="<?=domain;?>/<?=$post->url();?>"><?=$post->title;?> </a></h4>
      <p class="card-text">
        <small class="text-muted"><b> <i class="ft-clock"></i> </b><?=date("M j Y h:iA" , strtotime($post->created_at));?>
        <!-- <b>          <i class="ft-user"></i></b> <?=$post->author->firstname;?>  -->
          <!-- <b><i class="ft-eye"></i> </b>3232 -->
        </small>
      </p>
      <p style="color:#009c9f !important;"><?=$post->content;?></p>


      <hr>

      <div id="disqus_thread"></div>
      <script>

      /**
      *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
      *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/
      /*
      var disqus_config = function () {
      this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
      this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
      };
      */
      (function() { // DON'T EDIT BELOW THIS LINE
      var d = document, s = d.createElement('script');
      s.src = 'https://9gforex.disqus.com/embed.js';
      s.setAttribute('data-timestamp', +new Date());
      (d.head || d.body).appendChild(s);
      })();
      </script>
      <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

    </div>



  </div>
</div>

