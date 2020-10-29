<?php
$upline = User::where('mlm_id',$user->$user_column)->first();
$page_title = $tree['title'];
 include 'includes/header.php';?>


    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <!-- <h3 class="content-header-title mb-0"><?=$tree['title'];?></h3> -->
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
          <h4 class="card-title"><?=$tree['title'];?></h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
              <div class="heading-elements">
                <?=$note;?>
            </div>
        </div>
         <div class="card-content">
      <div class="card-body">


               <div class="row">
                        <div class="referral col-md-12" align="center">
                            <?php
                              if ($upline['username'] == '') {
                                $upline_link = "#";
                              }else{
                                $upline_link = "$domain/genealogy/placement_list/$upline[username]/1/$tree_key";

                              }

                            ;?>
                            <a href="<?=$upline_link;?>">
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
                          <button onclick="copy_text('<?=$auth->referral_link();?>');" class="btn btn-sm btn-dark">Copy Link</button>
                        <button class="btn btn-dark dropdown-toggle btn-sm" type="button" data-toggle="dropdown"> 
                          Downline Level <span class="badge badge-danger"> <?=$level_of_referral;?> </span>
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu" style="max-height: 200px; overflow-y: scroll;">
                         <?php for ($i=1; $i <=10 ; $i++):?>
                              <li>
                                <a class="dropdown-item" href="<?=domain;?>/genealogy/placement_list/<?=$user->username;?>/<?=$i;?>/<?=$tree_key;?>">
                                Level <?=$i;?>
                                </a>
                              </li>
                         <?php endfor;?>
                        </ul>
                      </div>
                      <br>
                      </div>

                    </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                              <div class="table-responsive">
                                     <table id="myTabl" class="table table-">
                                  <thead>
                                    <th>Sn</th>
                                    <th>Username</th>
                                    <th>Joined</th>
                                    <th>Status</th>
                                  </thead>
                                  <tbody>
                                    <?php $i=1; foreach ($list['list'] as $key => $downline):?>
                                    <tr>
                                      <td><?=$i++;?></td>
                                      <td><a href="<?=domain;?>/genealogy/placement_list/<?=$downline->username;?>/1/<?=$tree_key;?>">
                                      <?=$downline->username;?> </a></td>
                                      <td><?=date("M j, Y h:iA" ,strtotime($downline->created_at));?></td>
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


      </div>
    </div>
      </section>

        <ul class="pagination">
            <?=$this->pagination_links($list['total'] , $per_page) ;?>
        </ul>  



        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
