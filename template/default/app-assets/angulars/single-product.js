import { FilePreviewer } from "./carousel.js";

app.controller('CarouselController', function($scope, $http, $sce) {

    $http.get(`${$base_url}/shop/get_single_item_on_market/product/${$this_item}/${$preview}`)
    .then(function(response) {
      $scope.$item = response.data.single_good;
        $scope.$carousel = new FilePreviewer($scope.$item.market_details.cover.file, 0, $sce);
    });

});

app.directive("coverDiv", function() {

    return {
        template: `
        <style>
          .backleft{
            position: absolute;
            top: 22%;
            left: 20px;
            cursor: pointer;
          }
          .nextright{
            position: absolute;
            top: 22%;
            right: 20px;
            cursor: pointer;
          }
          
          .carousel-dot{
            position: relative;
            top: -29px;
          }
        </style>
        <div class="cover" ng-cloak>

          <i ng-hide="($carousel.$index==0) || ($carousel.$files.length == 0) " ng-click="$carousel.back()" class="fa fa-chevron-circle-left fa-2x backleft"> </i>  
          <i ng-hide="(($carousel.$index+1)==$carousel.$files.length) || ($carousel.$files.length == 0) " ng-click="$carousel.next()" 
          class="fa fa-chevron-circle-right fa-2x nextright"> </i>  

           <img ng-if="$carousel.$current_file.file_type=='image'" src="{{$carousel.$current_file.safe_file_path}}" 
           class ="d-block w-100 cover-image" alt="">

           <span ng-if="$carousel.$current_file.file_type=='video'">
             
           <iframe class="cover-video" ng-src="{{$carousel.$current_file.safe_file_path}}" allowfullscreen>
           </iframe>
           </span>

          <center class="carousel-dot" ng-if="$carousel.$files.length>1">
            <span ng-repeat="($index, $file) in $carousel.$files">
              <i ng-show="$file==$carousel.$current_file" class="fa fa-circle"></i>
              <i ng-hide="$file==$carousel.$current_file" ng-click="$carousel.setCurrentIndex($index)" class="fa fa-circle-o"></i>
            </span>
          </center>
        </div>
        `,
    };
});



app.filter('replace', [function() {

    return function(input, from, to) {

        if (input === undefined) {
            return;
        }

        var regex = new RegExp(from, 'g');
        return input.replace(regex, to);

    };


}]);




app.directive("contenteditable", function() {
    return {
        restrict: "A",
        require: "ngModel",
        link: function(scope, element, attrs, ngModel) {

            function read() {
                ngModel.$setViewValue(element.html());
            }

            ngModel.$render = function() {
                element.html(ngModel.$viewValue || "");
            };

            element.bind("blur keyup change", function() {
                scope.$apply(read);
            });
        }
    };
});