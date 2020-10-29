<?php
$upline = User::where('mlm_id',$user->referred_by)->first();
$page_title = "Placement Team List";
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Placement Team List</h3>
          </div>
          
         <!--  <div class="content-header-right col-md-6 col-12">
            <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
              <div class="btn-group" role="group">
                <button class="btn btn-outline-primary dropdown-toggle dropdown-menu-right" id="btnGroupDrop1" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ft-settings icon-left"></i> Settings</button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1"><a class="dropdown-item" href="card-bootstrap.html">Bootstrap Cards</a><a class="dropdown-item" href="component-buttons-extended.html">Buttons Extended</a></div>
              </div><a class="btn btn-outline-primary" href="full-calender-basic.html"><i class="ft-mail"></i></a><a class="btn btn-outline-primary" href="timeline-center.html"><i class="ft-pie-chart"></i></a>
            </div>
          </div> -->
        </div>
        <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">Placement Team List</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
         <div class="card-content">
      <div class="card-body">


               <div class="row">
                        <div class="referral col-md-6" align="center">
                            <a href="<?=domain;?>/genealogy/placement_list/<?=$upline['username'];?>">
                                <img src="<?=domain;?>/<?=$user->profilepic;?>" style="border-radius: 70%;height: 50px;"
                                 data-toggle="tooltip" title="Upline: <?=ucfirst($upline['lastname']);?> <?=ucfirst($upline['firstname']);?>">
                                <?php if($user->id == $this->auth()->id):?>
                                    <h4>Me</h4>
                                <?php else:?>
                                <h4><?=$user->lastname;?> <?=$user->firstname;?>
                                 </h4>
                                <?php endif;?>
                          </a>
                      
                      <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle btn-sm" type="button" data-toggle="dropdown"> 
                          Downline Level <span class="badge badge-danger"> <?=$level_of_referral;?> </span>
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                         <?php for ($i=1; $i <=$this->settings['mlm_depth'] ; $i++):?>
                              <li>
                                <a class="dropdown-item" href="<?=domain;?>/genealogy/placement_list/<?=$user->username;?>/<?=$i;?>">
                                Level <?=$i;?>
                                </a>
                              </li>
                         <?php endfor;?>
                        </ul>
                      </div>
                      <br>
                      </div>
                      <div class="referral col-md-6" align="center">
                                                    <?=$ref_link =$this->auth()->referral_link();?>
                            <button onclick="copy_text('<?=$ref_link;?>');" class="btn btn-success">Copy Link</button>


                      </div>

                    </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                              <div class="table-responsive">
                                     <table id="myTable" class="table table-hover">
                                  <thead>
                                    <th>Full Name (username)</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Joined</th>
                                    <th>Status</th>
                                  </thead>
                                  <tbody>
                                    <?php foreach ($list['list'] as $key => $downline):?>
                                    <tr>
                                      <td><a href="<?=domain;?>/genealogy/placement_list/<?=$downline->username;?>">
                                       <?=$downline->fullname;?> (<?=$downline->username;?>) </a></td>
                                      <td><?=$downline->email;?></td>
                                      <td><?=$downline->phone;?></td>
                                      <td><?=$downline->created_at->toFormattedDateString();?></td>
                                      <td><?=$downline->activeStatus;?></td>
                                    </tr>
                                  <?php endforeach;?>
                                  </tbody>
                                </table>
                              </div>


                            </div>
                        </div>
                    </div>
                </div>
                  <ul class="pagination">
                      <?=$this->pagination_links($list['total'] , $per_page) ;?>
                  </ul>  



      </div>
    </div>
      </section>


    <!--   <section id="video-gallery" class="card">
        <div class="card-header">
          <h4 class="card-title">blank</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                </ul>
            </div>
        </div>
      </section> -->


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
