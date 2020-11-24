<?php 
$page_title = 'Delivery';
$page_description = "";

include 'includes/header.php';?>


<div class="app-content container center-layout mt-2 ">
  <div class="content-wrapper">

    <div class="content-body">

      <div class="" >

        <div class="">
          <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
              <h3 class="content-header-title mb-0">Delivery</h3>

            </div>
            <div class="content-header-right text-md-right col-md-6 col-12">

            </div>
          </div>
          <div class="content-body">
            <style>
              .courses-in-cart ul li{
                list-style-type: none;
              }

              .courses-in-cart{
                border: 1px solid #00000014;
                padding: 5px;
              }

              .form-group{
                margin-bottom: 2px !important;
              } 
            </style>
            <div id="content"  ng-controller="ShopController" ng-cloak>
              <div class="content-detached content-lef" >
                <div class="content-body">
                  <section class="row">
                    <div id="" class="card col-md-7">
                      <div class="card-header">
                        <h4 class="card-title"><?=$order->total_item();?> Item(s)</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                      </div>


                      <div class="card-content collapse show">
                        <div class="card-body">
                          <div class="card-text">
                            <?php foreach ($order->order_detail() as $key => $item) :
                              $product = v2\Models\Market::where('item_id', $item['market_details']['id'])
                              ->latest()
                              ->OnSale()
                              ->first()
                              ->good();

                              $download_link = MIS::dec_enc('encrypt', "$order->id/$product->id/single");

                              ;?>
                              <div class="media courses-in-cart">
                               <div class="media-body">
                                <h4 class="media-heading"><b><?=$product->name;?></b></h4>
                                <span> <?=$product->ShortDescription;?> </span>
                              </div><br>

                              <ul>
                                <li class="text-"><a href="<?=$product->user->PageLink;?>">by <?=$product->user->DisplayTradeName;?></a></li>
                                <li><a class="btn btn-sm btn-outline-dark" onclick="location.href= `<?=domain;?>/s/d/<?=$download_link;?>` " >Download</a></li>
                              </ul>                                 

                            </div>
                          <?php endforeach;?>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class=" col-md-3" >
                    <div class=" card ">
                      <div class="card-body">
                        <h6>Delivered to:</h6>
                        <p>
                         <?=$order->Buyer->fullname;?> <br>
                         <?=$order->Buyer->email;?> <br>
                         <?=$order->Buyer->phone;?> <br>
                         Date: <?= date("M j, Y" , strtotime($order->paid_at));?>
                       </p>

                       <form>
                          <div class="form-group">
                            <label>Your rating:</label>
                            <select class="form-control">
                                <?php foreach ([1,2,3,4,5] as $rating) :?>
                                  <option value="<?=$rating;?>" ><?=$rating;?></option>
                                <?php endforeach  ;?>
                            </select>
                          </div>

                       </form>

                     </div>
                   </div>

                 </div>

               </section>

             </div>
           </div>

         </div>


       </div>
     </div>
   </div>


 </div>
</div>
</div>




<?php include 'includes/footer.php';?>