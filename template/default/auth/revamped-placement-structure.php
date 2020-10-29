<?php

$user   =  User::find($user_id);
@$upline = $user->referred_members_uplines(1, $tree_key)[1];

$max_uplevel = $user->max_uplevel('enrolment')['max_level'];
// $page_title = $tree['title'];
$page_title = "Team Tree";
include 'includes/header.php';?>


<!-- BEGIN: Content-->
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-2">
        <?php include 'includes/breadcrumb.php';?>

        <h3 class="content-header-title mb-0">Team Tree</h3>
      </div>
      
    </div>


    <datalist id="my_downlines">
      <option value=""></option>
    </datalist>

    <div class="content-body">

      <section id="video-gallery" class="card">
        <div class="card-header">

            <form action="<?=domain;?>/genealogy/showout" method="post" style="display: inline;">
          <div class="input-group col-6">
              <input type="text"  class="form-control" name="username" onkeyup="populate_option(this.value)" list="my_downlines"  placeholder="Search your downline" aria-describedby="button-addon2">
              <input type="hidden" name="tree_key" value="<?=$tree_key;?>">
              <div class="input-group-append" id="button-addon2">
                <button class="btn btn-outline-dark " style="" type="submit">Go</button>
              </div>
          </div>
            </form>



          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
          <div class="heading-elements">
            <div class="dropdown">
              <span type="span" style="cursor: pointer;" class="dropdown-toggle" data-toggle="dropdown">
                Filters
              </span>
              <div class="dropdown-menu">
                <a class="dropdown-item " href="<?=domain;?>/genealogy/placement/<?=$auth->username;?>/binary/2"> 
                  <i class="fa fa-sitemap "></i> My Genealogy </a>
                <a class="dropdown-item " href="<?=domain;?>/genealogy/last/0/<?=$tree_key;?>"> <i class=" ft-chevrons-left"></i> Last Left</a>
                <a class="dropdown-item " href="<?=domain;?>/genealogy/last/1/<?=$tree_key;?>"><i class=" ft-chevrons-right"></i>Last Right</a>
                <a href="#" id="gfilter" class="dropdown-item "  class="text-center">

                  <i class="ft-corner-left-up " ></i>
                  <label class="">Level up</label>
                 <form action="<?=domain;?>/genealogy/up" method="post">
                    <div class="input-group col-12" style="padding: 0px;">
                        <input type="number" min="0"  max="<?=$max_uplevel;?>" required="" class="form-control form-control-sm" 
                        name="level_up" placeholder="x-level up" aria-describedby="button-addon2">
                        <input type="hidden" name="tree_key" value="<?=$tree_key;?>">
                        <input type="hidden" name="user_id" value="<?=$user_id;?>">
                        <div class="input-group-append" id="button-addon2">
                          <button class="btn btn-outline-dark btn-sm" type="submit">Up</button>
                        </div>
                    </div>
                   </form>
                </a>
              </div>
            </div>            
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <style>
              #gfilter:hover{
                background: transparent;
              }

              .mlm_detail > tbody> tr > td{
                padding-top: 0px ;
                padding-bottom: 0px ;
              }


              .drop-down{
                  position:relative !important;
              }

              .label{

                font-size: 12px;
              }
              .label-value{
                font-size: 12px;
              }

              em{
                font-style: normal !important;
              }
            </style>

       

            <center style="overflow-x: scroll; min-height: 400px;">
              <ul class="tree" id="tree" style="width:100%;">
                <li><i class="fa fa-spin fa-spinner fa-4x"></i></li>
              </ul>
            </center>

            <script>
              $('.dropdown-menu').click(function(e) {
                  e.stopPropagation();
              });

              $.ajax({
                type: "POST",
                url: $base_url+"/genealogy/fetch2/<?=$user_id;?>/<?=$tree_key;?>/3",
                data: null,
                    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                    processData: false, // NEEDED, DON'T OMIT THIS
                    cache: false,
                    success: function(data) {
                      $("#tree").html(data.list);
                    },
                    error: function (data) {},
                    complete: function(){}
                  });



              populate_option = function($query){

                if ($query.length < 2) {return;}

                $.ajax({
                    type: "POST",
                    url: "<?=domain;?>/genealogy/search/"+$query+"/<?=$tree_key;?>",
                    data: null,
                    success: function(data) {

                        $('#my_downlines').html(data.line);
                    },
                    error: function (data) {
                    },
                    complete: function(){}
                });


              }


            </script>

          </div>
        </div>
      </section>



    </div>
  </div>
</div>
<!-- END: Content-->

<?php include 'includes/footer.php';?>
