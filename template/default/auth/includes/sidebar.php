<?php
$icon = "$asset/images/logo/icons";

?>
<style>

</style>

<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
  <div class="main-menu-content">
    <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

      <li class=" navigation-header menu-item"><span>GENERAL</span><i class="ft-droplet ft-minus" data-toggle="tooltip"
          data-placement="right" data-original-title="UI"></i>
      </li>

      <li>
        <a class="menu-item" href="<?=domain;?>/user/dashboard">
          <i class="fa fa-dashboard"></i>
          Dashboard</a>
      </li>



      <li class=" nav-item">

        <a href="#"><i class="fa fa-list"></i><span class="menu-title" data-i18n="">Transactions</span></a>
        <ul class="menu-content">
          <!-- <li><a class="menu-item" href="<?=domain;?>/user/user-transfers">User Transfer</a> -->
          <li><a class="menu-item" href="<?=domain;?>/user/make-withdrawal">Make Withdrawal</a>
          </li>
        </ul>
      </li>






      <!--              <li class=" nav-item"><a href="#">
                            <span class="menu-title" data-i18n="">Purchases</span></a>
              <ul class="menu-content">
                <li><a class="menu-item" href="<?=domain;?>/user/purchase-investment"> Packages</a>
                <li><a class="menu-item" href="<?=domain;?>/user/products"> Products</a>

                  <li><a class="menu-item" href="<?=domain;?>/user/your_packs">Your Packs</a>
                  </li>
                </ul>
              </li>


 -->

      <li class=" nav-item"><a href="#"><i class="fa fa-sitemap"></i><span class="menu-title"
            data-i18n="">Team</span></a>
        <ul class="menu-content">
          <!-- <li><a class="menu-item" href="<?=domain;?>/genealogy/placement_list"> List</a> -->
          <li><a class="menu-item"
              href="<?=domain;?>/genealogy/placement_list/<?=$auth->username;?>/1/enrolment/1">Referrals</a></li>
          <li><a class="menu-item" href="<?=domain;?>/genealogy/placement/<?=$auth->username;?>/enrolment/2">Team
              Tree</a>

          </li>
          <!--
                     <li><a class="menu-item" href="<?=domain;?>/user/direct-ranks">Direct Ranks</a>
                     </li>                    -->

        </ul>
      </li>


      <li class=" nav-item"><a href="#">
          <i class="fa fa-list"></i><span class="menu-title" data-i18n="">Purchases</span></a>
        <ul class="menu-content">
          <li><a class="menu-item" href="<?=domain;?>/user/courses"> Courses</a>
          <li><a class="menu-item" href="<?=domain;?>/user/products-orders"> Orders</a>
          </li>
        </ul>
      </li>







      <li class=" nav-item"><a href="#"><i class="ft-clock"></i><span class="menu-title" data-i18n="">History</span></a>
        <ul class="menu-content">

          <li><a class="menu-item" href="<?=domain;?>/user/commission-history"> Commission History</a>

            <!-- <li><a class="menu-item" href="<?=domain;?>/user/transfer-history"> Transfer History</a> -->

            <!-- <li><a class="menu-item" href="<?=domain;?>/user/payout-wallet"> Payout Wallet</a> -->


          <li><a class="menu-item" href="<?=domain;?>/user/withdrawals">Withdrawals</a>
          </li>
        </ul>
      </li>

      <!--
                <li class=" nav-item"><a href="#"><i class="ft-folder"></i><span class="menu-title" data-i18n="">
                Resources & Downloads</span></a>
                <ul class="menu-content">

                  <li><a class="menu-item" href="<?=domain;?>/user/resources/business-presentations"> Business Presentations</a>


                    <li><a class="menu-item" href="<?=domain;?>/user/resources/tutorials">Tutorials</a>
                    </li>

                    <li><a class="menu-item" href="<?=domain;?>/user/resources/promotional-items">Promotional Items</a>
                    </li>

                    <li><a class="menu-item" href="<?=domain;?>/user/resources/digital-marketing">Digital Marketing</a>
                    </li>

                    <li><a class="menu-item" href="<?=domain;?>/user/faqs">FAQ</a>
                    </li>
                  </ul>
                </li>
 -->

      <li class=" nav-item">
        <a href="#"><i class="ft-user"></i><span class="menu-title" data-i18n="">Account lan</span></a>
        <ul class="menu-content">
          <li><a class="menu-item" href="<?=domain;?>/user/account-plan"> Account Plan</a>
          <li><a class="menu-item" href="<?=domain;?>/user/account-plan"> Account Plan</a>

        </ul>
      </li>

      <li class=" nav-item">
        <a href="#"><i class="ft-user"></i><span class="menu-title" data-i18n="">My Account</span></a>
        <ul class="menu-content">

          <!-- <li><a class="menu-item" href="<?=domain;?>/user/account-plan"> Account Plan</a> -->

          <li><a class="menu-item" href="<?=domain;?>/user/profile"> My Profile</a>


            <!--<li>
                        <a class="menu-item" href="<?=domain;?>/user/two-factor-authentication">2FA
                         <span class="float-right">

                           <?=$auth->TwofaDisplay;?>
                         </span>
                       </a>
                     </li> -->

          <li><a class="menu-item" href="<?=domain;?>/user/testimony">Testimonial</a>
          </li>


          <li><a class="menu-item" href="<?=domain;?>/user/my-wallet">My Wallet</a>
          </li>

          <li><a class="menu-item" href="<?=domain;?>/user/change-password">Change Password</a>
          </li>

      </li>
    </ul>
    </li>



    <li class=" nav-item"><a href="#">
        <i class="ft-life-buoy"></i>
        <span class="menu-title" data-i18n="">Support</span></a>
      <ul class="menu-content">
        <li><a class="menu-item" href="<?=domain;?>/user/support"> Support Tickets</a>
        <li><a class="menu-item" href="<?=domain;?>/user/contact-us"> Contact us</a>
          <!-- <li><a class="menu-item" href="<?=domain;?>/user/broadcast">News</a></li> -->

      </ul>
    </li>


    </ul>
  </div>
</div>
<!-- END: Main Menu-->