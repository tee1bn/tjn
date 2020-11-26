<style>
  
  .cover-video{
      height: 25em !important;
      width: 100%;
      object-fit: cover;
  }
</style>

          <div  id="content"  ng-controller="ShopController" ng-cloak>
              
            <section id="image-grid" class="card">


              <div class="card-header">
                <h4 class="card-title col-md-6">Shop ({{$shop.$items.length}})<span class="badge badge-secondary"><?=(@$category);?></span>
                </h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <input type="" placeholder="Search..." class="form-control form-control-sm" ng-model="searchText">
                </div>
              </div>


              <div class="card-content " > 
                <center ng-hide="$shop.$items.length>0" style='margin:30px; '><i class="fa fa-spinner fa-spin fa-2x"></i></center>
                <div class="row" style="padding: 20px;">
                <div class="card-body col-md-3" style="padding: 2px;" ng-repeat ="($index, $item) in $shop.$items  | filter:searchText">
                  
                  <div class="card course-card" style="
    padding: 10px;
    margin: 5px;
    height: 100%;
    border: 1px solid #00000040;">
                    <img class="card-img-top" src="{{$item.market_details.thumbnail}}" alt="Card image cap" style="height: 140px;object-fit: cover;">
                    <div class="card-body">
                      <!-- <hr> -->
                      <a  href="<?=$domain;?>/shop/full_view/{{$item.market_details.id}}"><b>{{$item.market_details.name}}</b></a>
                      <p class="card-text course-subtext">
                         <!-- <small ng-bind-html="$item.market_details.short_description"></small> -->
                      </p>
                    <!-- 
                      <span class="course-subtext">
                        <span class="" ng-bind-html='$item.market_details.star_rating.stars'></span>
                      </span> -->

                      <br>
                      <span class="pull-left course-btn">
                        <!-- <span class="ft-heart"></span> -->
                        <a><span ng-click="$shop.$cart.add_item($item)" class="ft-shopping-cart fa-2x"></span></a>
                        <a><span ng-click="$shop.quickview($item)" class="ft-eye fa-2x"></span></a>
                        <?php if (isset($show_affiliate_link) && ($show_affiliate_link)) :?>

                          <a><span title="copy promotional link" ng-click="$shop.$cart.copy($item.market_details.promotional_link)" class="ft-link fa-2x"></span></a>
                        <?php endif ;?>
                      </span>
                      <span class="pull-right">      
                        <del class="cent" ng-show="$item.market_details.old_price != undefined">
                          <span ng-bind-html="$shop.$config.currency"></span>{{$item.market_details.old_price}} 
                        </del>&nbsp;
                        <b class=""> <span ng-bind-html="$shop.$config.currency"></span>{{$item.market_details.price | number:2}}</b>
                      </span>
                    </div>
                  </div>
                </div>    
                </div>    
              </div>
            </section>

            <center ng-cloak>
              <button ng-show="$shop.$items.length>0" ng-click="$shop.fetch_products()" ng-hide="$shop.$no_more_product" class="btn btn-outline-light">Load More</button>
              <button  ng-show="$shop.$no_more_product" class="btn btn-outline-light">No More Records</button>
            </center>


            <!-- Modal -->
            <div id="quick_view_modal" class="modal fade"  role="dialog">
              <div class="modal-dialog modal-lg" >

              <div class="modal-content">
              <!--     <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">{{$shop.$quickview.title}} </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                </div> -->
                <!-- {{$shop.$quickview.market_details.quickview}} -->
                <w3-test-directive></w3-test-directive>
                <div class="modal-body">
                    <span ng-bind-html="$shop.$quickview.market_details.quickview"></span>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                <button ng-click="$shop.$cart.add_item($shop.$quickview)" type="button" class="btn btn-outline-primary">
                  <i class="ft ft-shopping-cart"></i>
                Add to Cart</button>
                </div>
              </div>
              </div>
            </div>
          </div>
