  function FilePreviewer($files, $index) {
      this.$files = $files;
      this.$index = $index;
      this.$current_file = $files[$index];


      this.next = function(){

        if ((this.$index + 1) == this.$files.length) {
          this.$index = -1 ;
          return;
        }

        this.$index++;
        this.update_current_file();
      };

      this.back = function(){

        if ((this.$index ) == 0 ) {
          this.$index = this.$files.length ;
          return;
        }

        this.$index--;
        this.update_current_file();
      };

        this.update_current_file = function(){
         this.$current_file = this.$files[this.$index];
          // console.log(this);
        };


  }



app.controller('ProductController', function($scope, $http) {

	$scope.ui = "ola";
	
	$scope.fetch_payment_gateway_settings = function () {
		$http.get($base_url+"/settings/fetch_payment_gateway_settings/")
		.then(function(response) {
			$scope.$payment_gateway_settings= response.data;
		});
	};


	$scope.fetch_payment_gateway_settings();



});


app.directive("w3TestDirective", function() {

  return {
    template : "<h1>Made by a directive! {{user}}f {{ui}}</h1>",
  };
});


 app.component('greetUser', {
    template: 'Hello, {{$ctrl.user}}!',
    controller: function GreetUserController() {
      this.user = 'world';
    }
  });






app.filter('replace', [function () {

	return function (input, from, to) {

		if(input === undefined) {
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

