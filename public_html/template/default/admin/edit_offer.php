<?php
$page_title = "Edit Offers";
 include 'includes/header.php';

 use v2\Models\Offer;


 ;?>

    <script>
      $offer_id = <?=$offer->id;?>;
    </script>
    <script src="<?=general_asset;?>/js/angulars/offer.js"></script>
    <!-- BEGIN: Content-->
    <div class="app-content content" id="content" ng-controller="OfferController" ng-cloak>
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-6 mb-2">
            <?php include 'includes/breadcrumb.php';?>

            <h3 class="content-header-title mb-0">Edit Offers</h3>
          </div>
          
          <div class="content-header-right col-6 ">
            <div class="btn-group float-right" role="group" aria-label="Button group with nested dropdown">
              <a class="btn btn-outline-primary" href="<?=Offer::create_offer();?>"><i class="ft-plus"></i> Offer</a>
              <a class="btn btn-outline-primary" href="<?=domain;?>/admin/offers">All Offers</a>
            </div>
          </div>
        </div>
        <div class="content-body">



      <section id="video-gallery" class="card">
        <div class="card-header">


          <h4 class="card-title" style="display: inline;">Offers</h4>
          <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>


             
        </div>
         <div class="card-content">
          <div class="card-body">

            <form method ="post" action="<?=domain;?>/offer/update_offer" class="row ajax_form">

              <div class="form-group col-md-8">
                <label>Name</label>
                <input type="" name="name" class="form-control" ng-model="$offer.$data.offer.name">                
              </div>


              <div class="form-group col-md-4">
                <label>Available
                <input type="checkbox" name="availability" class="" value="1" ng-checked="$offer.$data.offer.availability==1"
                 ng-model="$offer.$data.offer.availability">                
                </label>
              </div>


              <div class="form-group col-md-12">
                <label>Context</label>
                <select class="form-control" name="context" ng-model="$offer.$data.offer.selected_context" ng-change="$offer.change_detail_options()">
                  <option value="">Select</option>
                  <option  ng-repeat="(key,  $perk) in $offer.$data.offer_class.perks" 
                  ng-selected="key==$offer.$data.offer.selected_context">{{key}}</option>

                </select>
              </div>

              <input type="hidden" name="id" value="<?=$offer->id;?>">

              <div class="form-group col-md-12">

                <label>Details</label>
                <hr>
                <div class="row col-12">
              <div class="form-group col-md-3" ng-repeat="(key, $detail) in $offer.$data.details" >
                <label>{{key}}</label>
                <input type="" name="details[{{key}}]" class="form-control" value="{{$detail}}">                
                </div>
              </div>
              </div>

              <div class="form-group col-md-12">
                <label>Benefits</label>
                <hr>
                <div class="row col-12">
                <div class="form-group col-md-3" ng-repeat="(key, $benefit) in $offer.$data.offer_class.perks[$offer.$data.offer.selected_context]['benefits']" >
                  <label>{{$benefit.title}}
                  <input type="checkbox" name="benefits[{{key}}]" class="" value="1" ng-checked="$offer.$data.offer.benefits[key] ==1">                
                  </label>
                  </div>
                </div>
                </div>



                <div class="form-group col-md-12">
                  <label>Lists</label>
                  <textarea class="form-control"  ng-model="$offer.$data.offer.lists" name="lists"></textarea>
                </div>





                <div class="form-group col-md-12">
                  <label>Description</label>
                  <textarea class="form-control"  ng-model="$offer.$data.offer.description" name="description"></textarea>
                </div>







              <div class="form-group col-md-12">
                  <button class="btn btn-outline-primary" type="submit">Save</button>

              </div>





              </div>
              


            </form>

              
          </div>
        </div>
      </section>


        </div>
      </div>
    </div>
    <!-- END: Content-->

<?php include 'includes/footer.php';?>
