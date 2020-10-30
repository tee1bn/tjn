<?php 
$page_title = MIS::encode_for_url($course->title);
include 'includes/header.php' ;?>

<?php
    if ($course->IncludedOffersAvailable->isEmpty()) {
        $show_offer = "display:none";
        $show_add_to_cart = "display:block";
    }else{
        $show_offer = "display:block";
        $show_add_to_cart = "display:none";

    }

;?>

<div class="app-content container center-layout mt-2">
  <div class="content-wrapper" style="margin: 0px;">
    <div class="content-header row">
      <div class="content-header-left col-6 mb-2">
        <h3 class="content-header-title mb-0"><?=$course->title;?></h3>
        <div class="row breadcrumbs-top">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="<?=domain;?>/shop">
              See all courses</a>
          </li>
      </ol>
  </div>
</div>
</div>
<div class="content-header-right text-right col-6 ">


    <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
        <?php if (! $course->is_free()) :?>
            <a onclick="add_item_singly();"  style="<?=$show_add_to_cart;?>" title="add to cart" class="btn btn-outline-primary ft ft-shopping-cart" href="Javascript:void(0);">
            Add to Cart </a>

            <a  class="btn btn-outline-primary fa fa-gift" href="#offers" style="<?=$show_offer;?>">
            See Offers </a>
        <?php endif;?>
        <?php if ($course->is_free()) :?>
          <a class="btn btn-outline-primary" href="<?=domain;?>/courses/read/<?=$course->id;?>">
            Start Course
        </a>
    <?php endif;?>
</div>

</div>
</div>
<div class="content-detached content-left">
  <div class="content-body"><section class="row">
    <div class="col-sm-12">

       <!-- What is-->
       <div  class="card">
        <div class="card-header">
            <h4 style="cursor: pointer;" data-toggle="collapse" href="#detail" class="card-title" >
                What will I Achieve ? 
                <a class="float-right" data-toggle="collapse" href="#detail"><i class="ft-chevron-down"></i></a>
            </h4>
           
        </div>
        <div class="card-content collapse show" id="detail">
            <div class="card-body">
                <div class="card-text">
                   <!--                <p>Starter kit is a set of pages with different layouts, useful for your next project to start development process from scratch with no time. </p> -->
                   <ul>
                    <?php foreach ( $course->GoalJson['aims'] as $aim):?>
                        <li><?=$aim;?>
                    </li>
                <?php endforeach ;?>
            </ul>
        </div>
    </div>
</div>
</div>
<!--/ What is-->


<!-- Kick start -->
<div id="kick-start" class="card">
    <div class="card-header">
        <h4 style="cursor: pointer;" data-toggle="collapse" href="#curriculum"   class="card-title">Course Curriculum
            <a data-toggle="collapse" href="#curriculum" class="float-right"><i class="ft-chevron-down"></i></a>
        </h4>
    </div>
    <div class="card-content collapse show" id="curriculum">
        <div class="card-body">
            <div class="card-text">

                <div id="accordionWrap2" role="tablist" aria-multiselectable="true">

                    <?php $i=1;

                    foreach (($course->CurriculumJson) as $section_key => $section):
                        $section = (array) $section;
                        ?>
                        <div class="card collapse-icon accordion-icon-rotate left" style="border:1px solid #00000021; margin: 2px;">
                               <!--  <div id="heading21" class="card-header">
                                    <a data-toggle="collapse" data-parent="#accordionWrap2" href="#accordion<?=$i;?>" aria-expanded="true" aria-controls="accordion<?=$i;?>" class="card-title lead collapsed">
                                        <?=$section['$title'];?></a>

                                <a  class="card-title lead collapsed show pull-right">
                                    <b><?=count((array)$section['$lectures']);?> Lecture(s)</b>
                                </a>

                            </div> -->
                            <div id="accordion<?=$i;?>" role="tabpanel" aria-labelledby="heading21" class="collapse show" style="">
                                <div class="card-content">
                                    <div class="card-body" style="padding: 0px;">
                                        
                                        <?php
                                        foreach ($section['$lectures'] as $lecture_key => $lecture):
                                            $lecture = (array) $lecture;
                                            $data = $lecture['$data'];
                                            $data = (array) $data;                                       
                                            ?>
                                            <div class="card-header" style="border:1px solid #00000021; padding: 10px;">
                                                <i class="ft-check-circle"></i> <?=($section_key+1);?>

                                                <a href="<?=$domain;?>/courses/read/<?=$course->id;?>/<?=($section_key+1);?>" 
                                                 class="card- collapsed" style="text-transform: capitalize; font-weight: 0px !important;"><b><?=$data['$title'];?></b></a>
                                                   
<!--                                                 <a  class="card- collapsed" style="text-transform: capitalize; font-weight: 0px !important;"><b>
                                                    <?=$data['$title'];?></b></a>
 -->                                                    
                                        </div>
                                            <?php   endforeach ;?>

                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <?php $i++; endforeach ;?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Kick start -->
        <!-- Kick start -->
        <div id="kick-start" class="card">
            <div class="card-header">
                <h4 style="cursor: pointer;" data-toggle="collapse" href="#course_requirement"  class="card-title">Course Requirements
                    <a class="float-right" data-toggle="collapse" href="#course_requirement"><i class="ft-chevron-down"></i></a>
                </h4>
            </div>
            <div class="card-content collapse show" id="course_requirement">
                <div class="card-body">
                    <div class="card-text">
                      
                     <!--  <p>Getting start with your project custom requirements using a ready template which is quite difficult and time taking process, Stack Admin provides useful features to kick start your project development with no efforts !</p> -->
                     <ul>
                        <?php foreach ( $course->GoalJson['requirements'] as $requirement):?>
                            <li><?=$requirement;?>
                        </li>
                    <?php endforeach ;?>

                    
                </ul>
            </div>
        </div>
    </div>
</div>
<!--/ Kick start -->

<div  class="card">
    <div class="card-header">
        <h4 style="cursor: pointer;" data-toggle="collapse" href="#course_is_for"  class="card-title">Who this Course is for
            <a data-toggle="collapse" href="#course_is_for"> <i class="ft-chevron-down" class="float-right"></i></a>
        </h4>
        
    </div>
    <div class="card-content collapse show" id="course_is_for">
        <div class="card-body">
            <div class="card-text">
               <ul>
                <?php foreach ( $course->GoalJson['target_students'] as $target_student):?>
                    <li><?=$target_student;?>
                </li>
            <?php endforeach ;?>
        </ul>
    </div>
</div>
</div>
</div>


<!-- How to-->
<div id="how-to" class="card">
    <div class="card-header">
        <h4 style="cursor: pointer;" data-toggle="collapse" href="#course_description"  class="card-title">Description
            <a data-toggle="collapse" href="#course_description"><i class="ft-chevron-down" class="float-right"></i></a>
        </h4>
        
    </div>
    <div class="card-content collapse show" id="course_description">
        <div class="card-body">
            <div class="card-text">
                <p><?=$course->description;?></p>
            </div>
        </div>
    </div>
</div>



<style type="text/css">
    .testimonial-image{

        height: 200px !important;
        width: 100%  !important;
        object-fit: cover !important;
        opacity: 0;
    }

    .attester{

         height: 45px; 
        width: 50px;
        object-fit: cover;
        border-radius: 60%;
        border: 1px solid #00000026;
        /* position: relative; */
        margin-top: 32px!important;
        /* top: 43px; */
        padding: 5px;
    }
}

h4>a {
    float:right !important;
}
</style>

     
        
        <div id="offers" class="card" style="<?=$show_offer;?>">
            <div class="card-header">
                <h4 style="cursor: pointer;" data-toggle="collapse" href="#course_offer"  class="card-title">Offers 
                    <a data-toggle="collapse" href="#course_offer"><i class="ft-chevron-down"></i></a>
                </h4>
            </div>
            <div class="card-content collapse show" id="course_offer">
                <div class="card-body">
                    <p>Get more value for your money by selecting one of the offers. This offer is closing soonest.</p>
                    <br>
                    <div class="card-text">
                        <style>
                            .small-padding {
                                padding: 3px;
                            }

                            .xm-padding {
                                padding: 1px;
                            }

                            .popular {

                                text-align: center;
                                position: absolute;
                                top: -12px;
                                padding: 0px 10px 0px 10px;
                                border-radius: 4px;
                            }


                        </style>

                                <div class="row match-height">
                          

                        <?php
                            use v2\Shop\Shop;
                            $shop = new Shop;

                            foreach ($course->IncludedOffersAvailable as $offer):
                                $offer_details = $offer->DetailsArray;
                                ?>

                                   

                                        <div class=" col-md-4" style="padding: 0px;">
                                            <div class="card" style="border: 1px solid #0000002e;">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <?php if (true) : ?>
                                                            <!-- <h4 class="popular bg-primary text-white">Most Popular</h4> -->
                                                        <?php endif; ?>

                                                        <h6 class="card-subtitle text-muted"><b class="float-right">
                                                                <?= $currency; ?><?= MIS::money_format($offer_details['price']); ?></b><br>
                                                            <span class="float-left" style="font-size: 15px;font-weight: 900;"><?= $offer->name; ?>
                                                            </span>
                                                   </h6>
                                                    </div>




                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">
                                                            <?php foreach ($offer->ListsArray as $key => $benefit): ?>

                                                                <li class="list-group-item use-bg xm-padding">
                                                                        <span class="badge badge-primary float-left"><i
                                                                                    class="fa fa-check-circle"></i></span>
                                                                    &nbsp; &nbsp; <i class="text-muted"><?= $benefit; ?></i>

                                                                </li>

                                                            <?php endforeach; ?>

                                                            <?php foreach ($offer->BenefitsArray as $key => $benefit): ?>

                                                                <li class="list-group-item use-bg xm-padding">
                                                                    <?php if (isset($benefits) && $benefits == 1) : ?>
                                                                        <span class="badge badge-primary float-left"><i
                                                                                    class="fa fa-check-circle"></i></span>
                                                                    <?php else : ?>
                                                                        <span class="badge bg-danger float-left"><i
                                                                                    class="fa fa-times-circle"></i></span>
                                                                    <?php endif; ?>
                                                                    &nbsp; &nbsp; <i class="text-muted"><?= $benefit; ?></i>

                                                                </li>

                                                            <?php endforeach; ?>
                                                        </ul>
                                                        <br>

                                                        <?php if (! $course->is_free()) :?>
                                                            <a href="javascript:void;" class="form-control text-center btn-primary"
                                                            onclick="add_item_singly(<?=$offer->id;?>);" ><i class="ft ft-shopping-cart"></i> Choose Offer</a>
                                                        <?php endif;?>

                                                        <?php if (true): ?>
                                                            <form style="display: none;"
                                                                    id="upgrade_form<?= $offer->id; ?>"
                                                                    method="post"
                                                                    class="ajax_form"
                                                                    data-overlay="in"
                                                                    data-function="initiate_payment"
                                                                    action="<?= domain; ?>/user/create_upgrade_request">


                                                               
                                                                <br>
                                                                <div class="form-group">
                                                                    <select class="form-control payment_method_selection" required="" name="payment_method">
                                                                        <option value="">Select Payment method</option>
                                                                        <?php foreach ($shop->get_available_payment_methods() as $key => $option): ?>
                                                                            <option value="<?= $key; ?>"><?= $option['name']; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                               <!--  <div class="form-group">
                                                                    <label>
                                                                        <input type="checkbox" name="" required="">
                                                                        Accept the terms & conditions.
                                                                    </label>
                                                                </div> -->

                                                                <input type="hidden" name="subscription_id"
                                                                       value="<?= $offer->id; ?>">

                                                                <div class="form-group">
                                                                    <button href="#" type="" class="btn btn-outline-teal">Buy</button>
                                                                </div>
                                                            </form>
                                                        <?php endif; ?>

                                                        <?php if (@$auth->subscription->payment_plan['id'] == $offer->id): ?>
                                                            <div class="form-group text-center">
                                                                <button type="button" class="btn btn-primary btn-sm">Current <i
                                                                            class="fa fa-check-circle"></i></button>
                                                                <small><?= $auth->subscription->NotificationText; ?></small>
                                                            </div>

                                                        <?php endif; ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                        <?php endforeach;?>
                        
                                </div>
                    
                    </div>
                </div>
            </div>
        </div>


        <?php

            $testimonials = Testimonials::approved()->take(6)->get();

            if ($testimonials->isEmpty()) {
                $show_testimonials ="display:none;";
            }else{

                $show_testimonials ="display:block;";
            }
        ;?>


        <div class="card" style="<?=$show_testimonials;?>">
            <div class="card-header">
                <h4 class="card-title" style="cursor: pointer;" data-toggle="collapse"  href="#course_testimonials" >Testimonials</h4>
            </div>



            <div class="card-content collapse show" id="course_testimonials">
                <div class="card-bod">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators" style="background: #151515;">
                            <?php 
                            $i=0;
                            foreach ($testimonials as $key => $value) :?>
                            <li data-target="#carousel-example-generic" data-slide-to="<?=$i;?>" class="<?=($i==0)? 'active':"";?>"></li>
                            <?php endforeach  ;?>
                        </ol>
                        <div class="carousel-inner" role="listbox">


                              <?php 

                                $i = 0;
                               foreach ($testimonials as $key => $testimonial):?>

                                <div data-interval="500000" class="carousel-item <?=($i==0)? 'active':"";?>">
                                    <img src="<?=asset;?>/images/carousel/11.jpg" class="testimonial-image" alt="First slide">
                                    <div class="carousel-caption text-dark">
                                        <img src="<?=domain;?>/<?=$testimonial->attester_pic;?>" class="attester">
                                        <br>
                                        <h4 style="display: inline;"><?=$testimonial->attester;?></h4>
                                        <small class="text-muted">
                                            <?=$testimonial->bio;?>
                                        </small>
                                        <p><?=$testimonial->content;?></p>
                                    </div>

                                </div>

                            <?php $i++; endforeach;?>





                           <!--  <div data-interval="500000" class="carousel-item">
                                <img src="<?=asset;?>/images/carousel/11.jpg" class="testimonial-image" alt="<?=project_name;?> Testimonials">

                                <div class="carousel-caption text-dark">
                                    <img src="<?=domain;?>/<?=Config::default_profile_pix();?>" class="attester">
                                    <h3>Opeyemi</h3>
                                    <p>The courses are explained in a very relatable terms and straight to the point. I'm happy I enrolled.</p>
                                </div>

                            </div>
                            -->

                        </div>
                        

                    </div>
                </div>
            </div>
        </div>




</div>
<!--/ How to-->


</div>
</section>

</div>
</div>
<div id="sticky-wrapper" class="sticky-wrapper" style="float: right; height: 1133.75px;"><div class="sidebar-detached sidebar-right sidebar-sticky" ,="," style="float: none;">
  <div class="sidebar"><div class="sidebar-content card">
    <div class="card-body" id="content" ng-controller="ShopController">
        <div class="category-title pb-1">
            <h6>By <?=$course->instructor->firstname;?> </h6>
            <small>Updated <?=date("M j, Y h:iA" , strtotime($course->updated_at));?></small>
        </div>
        <!-- Card sample -->
        <div class="text-center">
            <img style="width: 260px; height: 170px; object-fit: cover;" class="card-img-top mb-1 img-fluid" data-src="holder.js/100px180/" src="<?=domain;?>/<?=$course->imageJson;?>" alt="Card image cap">
        </div>
        <hr>
        <span style="color: #00b5b8;">
            <?=($course->market_details()['star_rating']['stars']);?>
        </span>
        <h4 class="card-title">

            <?php  if ($course->old_price != '') :?>
                <del class="cent" style="color: grey;">
                    <?=$currency;?><?=$this->money_format((int)$course->old_price);?>
                </del>&nbsp;
            <?php  endif  ;?>
            
            <?=$currency;?><?=$this->money_format($course->price);?>

        </h4>



        <!-- <p class="card-text">content.</p> -->

        <?php if (! $course->is_free()) :?>
            <a href="javascript:void;" class="form-control text-center btn-primary"
            onclick="add_item_singly();"  style="<?=$show_add_to_cart;?>"><i class="ft ft-shopping-cart"></i> Add to Cart</a>

            <a  class="btn btn-outline-primary text-center fa fa-gift" href="#offers" style="<?=$show_offer;?>">
            See Offers </a>

        <?php endif;?>

        <script>
            try{
                $this_item = <?=$course->id;?>;
            }catch(e){}
            
            add_item_singly = function ($with_offer_id=null) {

                $.ajax({
                    type: "POST",
                    url: $base_url+'/shop/get_single_item_on_market/course/'+$this_item,
                    data: null,
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT THIS
                cache: false,
                success: function(data) {
                    $item = data.single_good;
                    $scope = angular.element($('#content')).scope();
                    $scope.$shop.$cart.add_item($item, $with_offer_id);
                    $scope.$apply();

                    console.log($scope.$shop.$cart);
                },
                error: function (data) {
                },
                complete: function(){}
            });
            }

            
        </script>
        
        <?php if (($this->admin())  &&  ($course->status != 'Approved') ):?>
        <a href="<?=domain;?>/admin/toggle_course/<?=$course->id;?>" 
            class="form-control text-center btn-primary" ><i class="ft ft-check-circle"></i> Approve </a>
        <?php endif;?>

        
        <?php if (($this->admin())  &&  ($course->status == 'Approved') ):?>
        <a href="<?=domain;?>/admin/toggle_course/<?=$course->id;?>" 
            class="form-control text-center btn-secondary" ><i class="fa fa-times"></i> Disapprove </a>
        <?php endif;?>

        <?php if ($course->is_free()) :?>
            <a href="<?=domain;?>/courses/read/<?=$course->id;?>" 
                class="form-control text-center btn-secondary" ><i class="fa fa-check-circle"></i> Start Course </a>
            <?php endif  ;?>




            <!-- /Card sample -->
            <hr>

            <span id="to_find_scope"></span>
            
            <script>
                add_item = function ($course_id) {

                    $form = new FormData();
                    $.ajax({
                        type: "POST",
                        url: $base_url+"/course_api/find/"+$course_id,
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: $form,
                        success: function(data) {

                // show_notification(data);
                console.log(data);
                $scope = angular.element($('#to_find_scope')).scope();
                $scope.$shop.$cart.add_item(data);
                $scope.$apply();
                
              // $scope.fetch_page_content();
          },
          error: function (data) {
                 //alert("fail"+data);
             }

         });




    }


                
            </script>
            
            
        </div>
    </div>

</div>
</div></div>
</div>
</div>







<?php// include'includes/theme-customizer.php' ;?>
<?php include'includes/footer.php' ;?>