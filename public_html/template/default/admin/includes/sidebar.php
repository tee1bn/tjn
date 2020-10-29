   <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

          <li class=" navigation-header"><span>GENERAL</span><i class="ft-droplet ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="UI"></i>
          </li>          


         


<!-- 
          <li class=" nav-item"><a href="#"><i class="ft-circle"></i><span class="menu-title" data-i18n="" style="text-transform: capitalize;"> Blog</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/blogs" style="text-transform: capitalize;"> Blogs </a>
              </li>
            </ul>
          </li> 
 -->

<!-- 

          <li class=" nav-item"><a href="<?=domain;?>/admin/offers"><i class="ft-circle"></i>
            <span class="menu-title" data-i18n="" style="text-transform: capitalize;">Offers</span></a>
          </li>

          
          <li class=" nav-item"><a href="<?=domain;?>/admin/offers"><i class="ft-circle"></i>
            <span class="menu-title" data-i18n="" style="text-transform: capitalize;">Offers</span></a>
          </li>

          <li class=" nav-item"><a href="<?=domain;?>/admin/testimonials"><i class="ft-circle"></i>
            <span class="menu-title" data-i18n="" style="text-transform: capitalize;">Testimonials</span></a>
          </li>
 -->

          <?php 

            $sidebar_menus =  Access::where('url', '!=', null)->where('sidenav',1)
            ->orderBy('category')
            ->orderBy('name')
            ->get()
            ->groupBy('category')->toArray();
          
            
            
          ;?>
          <?php foreach ($sidebar_menus as $category => $menu) :
                $collect_menu_ids = collect($menu)->pluck('id')->toArray();
                $category_access = count(array_intersect($collect_menu_ids, $admin->admin_access->AccessesArray)) > 0;
            ?>
              <?php if ($category_access):?>
              <li class=" nav-item"><a href="#"><i class="ft-circle"></i><span class="menu-title" data-i18n="" style="text-transform: capitalize;"> <?=$category;?></span></a>
                <ul class="menu-content">
                <?php foreach ($menu as $key => $submenu) :
                    if (!in_array($submenu['id'], $admin->admin_access->AccessesArray)) {continue;}
                  ?>
                  <li><a class="menu-item" href="<?=domain;?>/<?=$submenu['url'];?>" style="text-transform: capitalize;"> <?=$submenu['name'];?></a>
                  </li>
                <?php endforeach;?>
                </ul>
              </li> 
            <?php endif;?>
          <?php endforeach;?>


        </ul>
      </div>
    </div>
    <!-- END: Main Menu-->
