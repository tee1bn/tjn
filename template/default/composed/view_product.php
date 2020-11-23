

           <div id="how-to" class="card" ng-cloak>
             <div class="card-content collapse show" id="course_description">
                 <div class="card-body">

                  <cover-div></cover-div>

              <h4 class="card-title" ><?=$product->name;?></h4>
              <p class="card-text"><small class="text-muted">By <?=$product->user->tradename ?? '';?></small></p>
              <p class="card-text"> <?=$product->description;?> </p>


        </div>
    </div>
 </div>