   <!-- BEGIN: Main Menu-->
   <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

        <li class=" navigation-header"><span>GENERAL</span><i class="ft-droplet ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="UI"></i>
        </li>          

        <li>
          <a class="menu-item" href="<?=domain;?>/user/dashboard"><i class="ft-clipboard"></i>Dashboard</a>
        </li>



        <li class=" nav-item"><a href="#"><i class="ft-user"></i><span class="menu-title" data-i18n="">Profile</span></a>
          <ul class="menu-content">

            <li><a class="menu-item" href="<?=domain;?>/user/profile"> Profile</a>

              <li><a class="menu-item" href="<?=domain;?>/user/verification">Verification</a>
              </li>

              <li><a class="menu-item" href="<?=domain;?>/user/bank-account">Bank Account</a>
              </li>
            </ul> 
          </li>


          <li class=" nav-item"><a href="#"><i class="ft-bookmark"></i><span class="menu-title" data-i18n="">Education</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/user/courses"> My Courses</a>

                <?php if ($auth->is_instructor()) :?>
                  <li><a class="menu-item" href="<?=domain;?>/user/instructor"> Instructor Dashboard</a>
                  </li>
                <?php endif;?>


                <?php if ($auth->is_blogger()):?>
                  <li><a class="menu-item" href="<?=domain;?>/user/blogger"> Blogger Dashboard</a>
                  </li>
                <?php endif;?>


              </ul>
            </li>

            <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n="">Accounts</span></a>
              <ul class="menu-content">                 
                <li><a class="menu-item" href="<?=domain;?>/user/all-trading-accounts">All Accounts</a>
                </li>
              </ul> 
            </li>

            <li class=" nav-item"><a href="#"><i class="ft-trending-up"></i><span class="menu-title" data-i18n="">Deposits</span></a>
              <ul class="menu-content">
                <li><a class="menu-item" href="<?=domain;?>/user/make-deposit"> Make Deposit</a>

                  <li><a class="menu-item" href="<?=domain;?>/user/deposit-history">Deposit History</a>
                  </li>
                </ul> 
              </li>


              <li class=" nav-item"><a href="#"><i class="ft-trending-down"></i><span class="menu-title" data-i18n="">Withdrawals</span></a>
                <ul class="menu-content">
                  <li><a class="menu-item" href="<?=domain;?>/user/make-withdrawal"> Make Withdrawal</a>

                    <li><a class="menu-item" href="<?=domain;?>/user/withdrawal-history">Withdrawal History</a>
                    </li>
                  </ul> 
                </li>


                <li class=" nav-item"><a href="#"><i class="ft-phone-call"></i><span class="menu-title" data-i18n="">Support</span></a>
                  <ul class="menu-content">
                    <li><a class="menu-item" href="<?=domain;?>/user/support"> Support Tickets</a>
                      <li><a class="menu-item" href="<?=domain;?>/user/contact-us"> Contact us</a>

                      </ul> 
                    </li>

<!-- 
              <li>
                <a class="menu-item" href="<?=domain;?>/user/earnings"><i class="icon-wallet"></i> Wallet</a>
              </li>

              <li>
                <a class="menu-item" href="<?=domain;?>/user/withdrawals"><i class="fa fa-credit-card"></i> Withdrawals</a>
              </li> -->



         <!--  <li class=" navigation-header"><span>COMMUNICATION</span><i class="ft-droplet ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="UI"></i>
          </li>
              
            <li><a class="menu-item" href="<?=domain;?>/user/testimony"><i class="fa fa-certificate"></i>Testimonials</a></li>

            <li><a class="menu-item" href="<?=domain;?>/user/broadcast"><i class="fa fa-bullhorn"></i>News</a></li>

            <li><a class="menu-item" href="content-grid.html"><i class="fa fa-certificate"></i>Support</a></li>

          -->

        </ul>
      </div>
    </div>
    <!-- END: Main Menu-->
