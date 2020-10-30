  <?php

    $page_title = "";
    $page_description = "";

    include 'includes/header.php';
 ;?>

  
  <body>
    

    <div class="container-fluid">
        
    </div>

    <style>
      .img-fluid{

        /*height: 450px !important; */
        width: 100%;
        object-fit: cover;
      }

      .price{
        border-bottom: 1px dotted white;
      }

      .cover-video{
        height: 25em !important;
        width: 100%;
        object-fit: contain;
      }

      body{
        overflow-x: hidden;
      }
    </style>

    <!-- BEGIN: Content-->
    <div class="app-content container mt-2">
        <div class="content-wrapper">
           
            <div class="content-body row">
              <div class="row match-height">
                  <div class="col-md-12 col-sm-12">
                    <div class="card" style="">
                      <div class="card-content">

                        <div class="cover">
                              <div class=""><!-- 
                              <iframe class="cover-video"
                                src="https://www.youtube.com/embed/SsE5U7ta9Lw?amp;controls=0&amp;showinfo=0"
                                allowfullscreen></iframe>
                                -->
                                <img src="https://pixinvent.com/stack-responsive-bootstrap-4-admin-template/app-assets/images/carousel/09.jpg" 
                                class="d-block w-100 cover-video"
                                  alt="First slide">
                            </div>
                        </div>

                        <div class="card-body">
                          <h4 class="card-title"><?=$product->name;?></h4>
                          <p class="card-text"><small class="text-muted">By <?=$product->user->username ?? '';?></small></p>

                          <p class="card-text">
                            <?=$product->description;?>
                          </p>
                          <p class="card-text">Cupcake fruitcake macaroon donut pastry gummies tiramisu chocolate bar
                            muffin.</p>
                        </div>
                      </div>
                    </div>
                        
                      <div>
                      <button class="btn btn-dark btn-block">Order Now <span class="price"><?=$product->currency;?><?=$product->price;?></span></button>
                    </div>
<!-- 
                      <div class="card">
                        <div class="card-header">
                          <a class="card-link" data-toggle="collapse" href="#collapseOne">
                            Ratings
                          </a>
                        </div>
                        <div id="collapseOne" class="collapse" data-parent="#accordion">
                          <div class="card-body">
                            Lorem ipsum..
                          </div>
                        </div>
                      </div> -->

                   
                  </div>
                  

                </div>
              <div class="col-md-12">
                <br>
              </div>

            </div>
        </div>
    </div>

  </body>
  <?php include 'includes/footer.php';?>