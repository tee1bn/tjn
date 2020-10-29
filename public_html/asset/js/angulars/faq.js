	function Faqs($sce){
		this.$sce = $sce;
		this.$data;

		this.$current;

		this.add_faq = function(){
			$d = this.$data.faq.push({});
			this.open_editor(this.$data.faq[(this.$data.faq.length -1)]);
		}

		this.remove_faq = function($faq){	

		    for (x in this.$data.faq) {
		        if (this.$data.faq[x] === $faq) {
		        	this.$data.faq.splice(x, 1);
		            return true;
		        }
    		}
    			return false;
		
		}

	
		
		this.open_editor = function($faq){
			this.$current = $faq;
			$('#faq_modal').modal('show'); 
		}
		


		this.scope = function() {

			$scope = angular.element($('#content')).scope();
			return $scope; 
		}



		this.init = function(){
			$this = this;
			 $.ajax({
	            type: "POST",
	            url: $base_url+"/cms_crud/fetch_faqs",
	            cache: false,
	            contentType: false,
	            processData: false,
	            data: {},
	            success: function(data) {
	              console.log(data);
	              $this.$data = data;
	              $this.scope().$apply();
	            },
	            error: function (data) {
	                 //alert("fail"+data);
	            }

	           });
		}


		this.init();
	}
	
	

	app.controller('FaqController', function($scope, $http, $sce) {

		$scope.$faq = [];


		$scope.fetch_page_content = function () {
			    $scope.$faq = new Faqs($sce);
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