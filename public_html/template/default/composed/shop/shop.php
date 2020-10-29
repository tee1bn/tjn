
          <div  id="content"  ng-controller="ShopController">
              
            <section id="image-grid" class="card">


              <div class="card-header">
                <h4 class="card-title col-md-6">Items <span class="badge badge-secondary"><?=(@$category);?></span>
                </h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <input type="" placeholder="Search..." class="form-control" ng-model="searchText">
                </div>
              </div>

              <div class="card-content row" ng-cloak>
                <div class="card-body col-md-4" ng-repeat ="($index, $item) in $shop.$items  | filter:searchText">
                  
                  <div class="card course-card" >
                    <img class="card-img-top" src="{{$item.market_details.thumbnail}}" alt="Card image cap" style="height: 210px;width: 100%;object-fit: cover;">
                    <div class="card-body">
                      <a href="{{$item.market_details.single_link}}"><b>{{$item.market_details.short_name}}...</b></a>
                      <p class="card-text course-subtext">
                         {{$item.market_details.by}}
                      </p>
                    
                      <span class="course-subtext">
                        <span class="" ng-bind-html='$item.market_details.star_rating.stars'></span>
                      </span>

                      <br>
                      <span class="pull-left course-btn">
                        <!-- <span class="ft-heart"></span> -->
                        <a><span ng-click="$shop.$cart.add_item($item)" class="ft-shopping-cart fa-2x"></span></a>
                        <a>&nbsp;</a>
                        <a><span ng-click="$shop.quickview($item)" class="ft-eye fa-2x"></span></a>
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
            </section>

<!--             <center ng-cloak>
              <button ng-click="$shop.fetch_products()" ng-hide="$shop.$no_more_product" class="btn btn-secondary">Load More</button>
              <button  ng-show="$hide_more_btn" class="btn btn-secondary">No More Records</button>
            </center>

 -->
            <!-- Modal -->
            <div id="quick_view_modal" class="modal fade" role="dialog">
              <div class="modal-dialog modal-lg">

              <div class="modal-content">
              <!--     <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel17">{{$shop.$quickview.title}} </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                </div> -->
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
