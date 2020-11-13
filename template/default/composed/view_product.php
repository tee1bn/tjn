

           <div id="how-to" class="card" ng-cloak>
             <div class="card-content collapse show" id="course_description">
                 <div class="card-body">

                  <!-- {{$carousel.$current_file}} -->

                  <cover-div></cover-div>

<!--                   <div class="cover">
                    <i ng-hide="$carousel.$index==0" ng-click="$carousel.back()" class="fa fa-chevron-circle-left fa-2x backleft"> </i>  
                    <i ng-hide="($carousel.$index+1)==$carousel.$files.length" ng-click="$carousel.next()" 
                    class="fa fa-chevron-circle-right fa-2x nextright"> </i>  

                     <img ng-if="$carousel.$current_file.file_type=='image'" src="{{$carousel.$current_file.file_path}}" 
                     class ="d-block w-100 cover-video" alt="<?=$product->name;?>">

                     <span ng-if="$carousel.$current_file.file_type=='video'">
                       
                     <iframe class="cover-video" ng-src="{{$carousel.$current_file.file_path}}" allowfullscreen>
                     </iframe>
                     </span>

                    
                    <center class="carousel-dot">
                      <span ng-repeat="($index, $file) in $carousel.$files">
                        <i ng-show="$file==$carousel.$current_file" class="fa fa-circle"></i>
                        <i ng-hide="$file==$carousel.$current_file" ng-click="$carousel.setCurrentIndex($index)" class="fa fa-circle-o"></i>
                      </span>
                    </center>
                  </div>
 -->

              <h4 class="card-title" ><?=$product->name;?></h4>
              <!-- <p class="card-text"><small class="text-muted">By <?=$product->user->username ?? '';?></small></p> -->
              <p class="card-text"> <?=$product->description;?> </p>


        </div>
    </div>
 </div>