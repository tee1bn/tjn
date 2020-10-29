



app.controller('Settings', function($scope, $http) {


	
	$scope.fetch_payment_gateway_settings = function () {
		$http.get($base_url+"/settings/fetch_payment_gateway_settings/")
		.then(function(response) {
			$scope.$payment_gateway_settings= response.data;
		});

	};
	$scope.fetch_payment_gateway_settings();



	$scope.fetch_site_settings = function () {
		$http.get($base_url+"/settings/fetch_site_settings/")
		.then(function(response) {
			$scope.$site_settings= response.data;
		});

	};
	$scope.fetch_site_settings();


	



	
	$scope.matrix_plan_table_1 = function () {
		$http.get($base_url+"/settings/fetch/matrix_plan_table_1")
		.then(function(response) {
			$scope.$matrix_plan_table_1= response.data;
		});

	};
	$scope.matrix_plan_table_1();


	
	$scope.points_value = function () {
		$http.get($base_url+"/settings/fetch/points_value")
		.then(function(response) {
			$scope.$points_value= response.data;
		});

	};
	$scope.points_value();

	

		
	$scope.rank_and_generation = function () {
		$http.get($base_url+"/settings/fetch/rank_and_generation")
		.then(function(response) {
			$scope.$rank_and_generation= response.data;
		});

	};
	$scope.rank_and_generation();

	
		
	$scope.currency_pricing = function () {
		$http.get($base_url+"/settings/fetch/currency_pricing")
		.then(function(response) {
			$scope.$currency_pricing= response.data;
		});

	};
	$scope.currency_pricing();

	

		
	$scope.currencies_and_codes = function () {
		$http.get($base_url+"/settings/fetch/currencies_and_codes")
		.then(function(response) {
			$scope.$currencies_and_codes= response.data;
		});

	};
	$scope.currencies_and_codes();

	

	

	

	$scope.leadership_ranks = function () {
		$http.get($base_url+"/settings/fetch/leadership_ranks")
		.then(function(response) {
			$scope.$leadership_ranks= response.data;
		});

	};
	$scope.leadership_ranks();

	

	

	$scope.rules_settings = function () {
		$http.get($base_url+"/settings/fetch/rules_settings")
		.then(function(response) {
			$scope.$rules_settings= response.data;
		});

	};
	$scope.rules_settings();

	



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

