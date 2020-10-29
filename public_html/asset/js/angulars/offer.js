	function Offer($sce){
		this.$sce = $sce;
		this.$data;



		this.change_detail_options  = function(){


			$selected_context = this.$data.offer.selected_context  ;

		

			if (($selected_context == this.$data.offer.context ) ) {

				this.$data.details = this.$data.offer.details ;
				this.$data.benefits = this.$data.offer.benefits ;

			}else{

				this.$data.details = this.$data.offer_class.perks[$selected_context].properties ;
				this.$data.benefits = this.$data.offer_class.perks[$selected_context].benefits ;
			}

		}

		this.scope = function() {
			$scope = angular.element($('#content')).scope();
			return $scope; 
		}



		this.init = function(){
			$this = this;

			 $.ajax({
	            type: "POST",
	            url: $base_url+`/offer/fetch_offers/${$offer_id}`,
	            cache: false,
	            contentType: false,
	            processData: false,
	            data: {},
	            success: function(data) {

	              $this.$data = data;

	              if (typeof($this.$data.offer.details) == 'object' ) {
	              	$this.$data.offer.selected_context = $this.$data.offer.context;
	              }
	              $this.change_detail_options();
	              $this.scope().$apply();
	            },
	            error: function (data) {
	                 //alert("fail"+data);
	            }

	           });
		}


		this.init();
	}
	
	

	app.controller('OfferController', function($scope, $http, $sce) {

		$scope.$offer = [];


		$scope.fetch_page_content = function () {
			    $scope.$offer = new Offer($sce);
		} 

		$scope.fetch_page_content();
});


	app.directive('ckEditor', function () {
	    return {
	        require: '?ngModel',
	        link: function (scope, elm, attr, ngModel) {
	            var ck = CKEDITOR.replace(elm[0]);
	 
	            if (!ngModel) return;
	 
	            ck.on('pasteState', function () {
	                scope.$apply(function () {
	                    ngModel.$setViewValue(ck.getData());
	                });
	            });
	 
	            ngModel.$render = function (value) {
	                ck.setData(ngModel.$viewValue);
	            };
	        }
	    };
	});


	app.directive("compileHtml", function($parse, $sce, $compile) {
	    return {
	        restrict: "A",
	        link: function (scope, element, attributes) {
	 
	            var expression = $sce.parseAsHtml(attributes.compileHtml);
	 
	            var getResult = function () {
	                return expression(scope);
	            };
	 
	            scope.$watch(getResult, function (newValue) {
	                var linker = $compile(newValue);
	                element.append(linker(scope));
	            });
	        }
	    }
	});