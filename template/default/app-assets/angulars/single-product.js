import { FilePreviewer } from "./carousel.js";

app.controller('CarouselController', function($scope, $http, $sce) {

    let $files =[{
            "file_path": "http://localhost/tjn/uploads/products/LHo3_i6G.jpg-largebGpud2k5RGd1d1U5OE1lbjh3anN5dz09.jpg",
            "file_type": "image"
        },
        {
            "file_path": "http://localhost/tjn/uploads/products/Screen-Shot-2019-08-12-at-16.20.33bGpud2k5RGd1d1U5OE1lbjh3anN5dz09.png",
            "file_type": "image"
        },
        {
            "file_path": "https://poolscompilers.com.ng/public/files/site_images/logo.png",
            "file_type": "image"
        },
        {
            "file_path": "https://www.youtube.com/embed/hLzDBVqAsbo",
            "file_type": "video",
        }
    ];

    $files.map(function($file){
         $file.file_path  = $sce.trustAsResourceUrl($file.file_path);
         return $file;
    });


    $scope.$carousel = new FilePreviewer($files, 0);


    $scope.ui = "ok";
});

app.directive("w3TestDirective", function() {

    return {
        template: "<h1>Made by a directive! {{user}}f {{ui}}</h1>",
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