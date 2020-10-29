   <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

          <li class=" navigation-header"><span>GENERAL</span><i class="ft-droplet ft-minus" data-toggle="tooltip" data-placement="right" data-original-title="UI"></i>
          </li>          


          <?php

            print_r( $admin->admin_access->AccessesArray);

          ;?>

          

          <li class=" nav-item"><a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n=""> Admins</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/add-admin"> Add Admin</a>
          
              <li><a class="menu-item" href="<?=domain;?>/admin/all-admins">All Admins</a>

              <li><a class="menu-item" href="<?=domain;?>/admin/accesses"> Accesses</a>
              </li>
            </ul>
          </li> 


          <li class=" nav-item"><a href="#"><i class="ft-users"></i><span class="menu-title" data-i18n=""> Users</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/all-users"> All Users</a>
          
              <li><a class="menu-item" href="<?=domain;?>/admin/verified-users">Verified Users</a>
              </li>
            </ul>
          </li> 



          <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n=""> Trading Account</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/all-trading-accounts"> All Trading Accounts</a>
          
              </li>
            </ul>
          </li> 

          
          <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n=""> Manage Leads</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/all-leads"> All Leads</a>
              </li>
            </ul>
          </li> 

          <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n=""> Compliance</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/user-verification"> User Verification</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/bank-verification"> Bank Verification</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/course-verification"> Course Verification</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/blog-verification"> Blog Verification</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/testimonial-verification"> Testimonial Verification</a></li>
            </ul>
          </li> 

          <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n=""> Deposits</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/all_deposits"> All Deposits</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/deposit_initiated"> Initiated Deposit </a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/deposit_pending"> Pending Deposit </a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/deposit_confirmed"> Confirmed Deposit </a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/deposit_completed"> Completed Deposit </a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/deposit_declined"> Declined Deposit </a></li>
            </ul>
          </li> 


          <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n=""> Withdrawals</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/all_withdrawals"> All Withdrawals</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/withdrawal_initiated"> Initiated Withdrawal </a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/withdrawal_pending"> Pending Withdrawal </a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/withdrawal_confirmed"> Confirmed Withdrawal </a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/withdrawal_completed"> Completed Withdrawal </a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/withdrawal_declined"> Declined Withdrawal </a></li>
            </ul>
          </li> 

          

          <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n=""> Bonuses</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/all_bonuses"> All Bonuses</a></li>
            </ul>
          </li> 

          <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n=""> Education</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/all_courses"> All Courses</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/Courses"> Courses Orders</a></li>
            </ul>
          </li> 

          
          <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n=""> Survey</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/survey"> Survey</a></li>
            </ul>
          </li> 

          
          
          <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n=""> Customer Care</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/open-tickets">Open Tickets</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/closed-tickets">Closed Tickets</a></li>
            </ul>
          </li> 

          
          
          <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n=""> Marketing</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/create-campaigns">Create Campaigns</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/all-campaigns">All Campaigns</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/campaigns-categories">Campaigns Categories</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/news">News</a></li>
            </ul>
          </li> 

          
          <li class=" nav-item"><a href="#"><i class="ft-briefcase"></i><span class="menu-title" data-i18n=""> CMS</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?=domain;?>/admin/cms">CMS</a></li>
              <li><a class="menu-item" href="<?=domain;?>/admin/faqs">Faqs</a></li>
            </ul>
          </li> 

      

          <li><a class="menu-item" href="<?=domain;?>/admin/settings"><i class="fa fa-cog"></i>Settings</a></li>
            <li><a class="menu-item" href="<?=domain;?>/admin/packages-settings"><i class="fa fa-briefcase"></i>Packages</a></li>





        </ul>
      </div>
    </div>
    <!-- END: Main Menu-->
