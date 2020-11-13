import { FilePreviewer } from "./carousel.js";


	function Cart(){
		this.$items = [];
		this.$total  = 0;		//total of items selected
		this.$coupon = [];
		this.$shipping_details = [];
		this.$selected_shipping ;
		this.$config ;

		this.contains_object =  function(obj, list) {
		    var i;
		    console.log(obj)
		    for (i = 0; i < list.length; i++) {
		        if ((list[i].market_details.id === obj.market_details.id ) && (list[i].market_details.model === obj.market_details.model )) {
		            return true;
		        }

    		}
			return false;
		}



		this.set_config = function($config){
			this.$config =$config;
			return;
		}

		this.buy_now = function($item){
			this.add_item($item);
			location.href = $base_url+"/shop/cart";
		}

		this.copy = function($text){
			copy_text($text);
		}
		
		this.add_item = function($item){
			let $checkout_url = $base_url+"/shop/cart";

			//ensure item is not added in cart more than once
			if (this.contains_object($item, this.$items)) {
				window.show_notification('<b>'+$item.market_details.name+
					'</b><br> Already in Cart! <br> <a class="btn btn-outline-teal btn-sm" href='+$checkout_url+'>Check out</a>');
				return ;
			}


			$item.qty = 1;
			this.$items.push($item);

			this.update_server();

			window.show_notification('<b>'+$item.market_details.name+'</b><br> Added to cart successfully! <br> <a class="btn btn-outline-teal btn-sm" href='+$checkout_url+'>Check out</a>');
		}


		this.remove_item = function($item){

			var i;
		    for (i = 0; i < this.$items.length; i++) {
		        if (this.$items[i] === $item) {
		        	this.$items.splice(i, 1);

					this.update_server();
		            return true;
		        }
    		}
    			return false;
		}	

	
		this.empty_cart =  function () {
			$this = this;
			$.ajax({
	            type: "POST",
	            url: $base_url+"/shop/empty_cart_in_session",
	            cache: false,
	            contentType: false,
	            processData: false,
	            data: {},
	            success: function(data) {
	              // console.log(data);
	              // $scope.fetch_page_content();
	              window.notify();
					window.location.href = $this.$config.shop_link;
	            },
	            error: function (data) {
	                 //alert("fail"+data);
	            }

	        });
		}

		this.calculate_total = function (){

			let	$total = 0;

			for(let x in this.$items){
				let $item = this.$items[x];
				let $qty = ($item.qty != null) ? $item.qty : 1;

				$total = $total + (parseInt($item.market_details.price) * parseInt($item.qty) );
			}

			 $total = parseInt($total);
			return  $total;
		}
		



		this.update_server = function () {

			this.calculate_total();

			 let $scope = angular.element($('#cart-notification')).scope();
			$scope.$cart = this;
		
			let $form = new FormData ();
			$form.append('cart', JSON.stringify(this));
			
			for(let x in this.$items){
				let $item = this.$items[x];
				// $form.append('selected_shipping', this.$selected_shipping);
				};
					// $("#page_preloader").css('display', 'block');

					 $.ajax({
			            type: "POST",
			            url: $base_url+"/shop/update_cart",
			            cache: false,
			            contentType: false,
			            processData: false,
			            data: $form,
			            async: true,
                        headers: {
                          "cache-control": "no-cache"
                        },
			            success: function(data) {
							$("#page_preloader").css('display', 'none');
			              // console.log(data);
			              // $scope.fetch_page_content();
			              window.notify();
			            },
			            error: function (data) {
			                 alert("fail"+JSON.stringify(data));
			            }

			           });


		}
		
	}


	function Shop($sce) {
		this.$items = [];
		this.$items_page = 1;
		this.$sce = $sce;
		this.$links;

		/**
		 * [$no_more_product true if there is 
		 * more products to fetch from db and false if other wise.
		 * mainly for pagination]
		 * @type {Boolean}
		 */
		this.$no_more_product = false;   
		this.$cart = new Cart();
		this.$quickview ;


		this.add_item = function($new_items= []){
				for(let x in $new_items){
				var $new_item = $new_items[x];
				$new_item.view = $sce.trustAsHtml($new_item.view);
				this.$items.push($new_item);
				}

		}
		
			// this.add_item($items);

		

		this.quickview = function ($item) {
					$('#quick_view_modal').modal('show');			
					this.$quickview = $item;
					// this.$quickview.$carousel = new FilePreviewer($item.market_details.cover.file, 0 , $sce);
					let $scope = angular.element($('#content')).scope();
					$scope.$carousel = new FilePreviewer($item.market_details.cover.file, 0, $sce);
					// $scope.$apply();
					console.log($scope.$carousel);
			}

		this.fetch_products = function () {

				let $this= this;
				$model = ($model != undefined) ? $model : null;
				let $url = $base_url+'/shop/market/'+$this.$items_page+'/'+$model;
				// $("#page_preloader").css('display', 'block');
			 $.ajax({
	            type: "POST",
	            url: $url,
	            cache: false,
	            data: null,
	            success: function(data) {
				$("#page_preloader").css('display', 'none');

	              		if (data.items.length==0) {
	              			$this.$no_more_product = true;
	              			$this.update_angular_scope();
	              			return;
	              		}

	              		// console.log(data.config);

	              	$this.add_item(data.items);
	              	$this.$items_page++;
	              	$this.$config = data.config;
	              	$this.$cart.set_config(data.config);
	              	$this.retrieve_cart_in_session();
	              	$this.update_angular_scope();
				/*
		              console.log(data);
		              console.log($this);*/
									
			
	            },
	            error: function (data) {
	                 //alert("fail"+data);
	            }

	           });
			}

			this.fetch_products();


		this.retrieve_cart_in_session = function () {
			let $this = this;
			// $("#page_preloader").css('display', 'block');
			 $.ajax({
	            type: "POST",
	            url: $base_url+'/shop/retrieve_cart_in_session/',
	            cache: false,
	            data: null,
	            success: function(data) {
				$("#page_preloader").css('display', 'none');

				    // console.log(data);
				    // try{

				    for(let x in data.$items){
				    	var $item = data.$items[x];
				    	$this.$cart.$items.push($item);
				    }

				    try{
				    	$this.$cart.$selected_shipping = data.$selected_shipping;
				    }catch(e){}

				    	// console.log($this.$cart);

				    	$this.$cart.update_server();
							$this.update_angular_scope();
	            },
	            error: function (data) {
	                 //alert("fail"+data);
	            }

	           });
			}

	
			this.update_angular_scope = function () {
					let $scope = angular.element($('#content')).scope().$apply();
					$scope = angular.element($('#cart-notification')).scope();
					$scope.$cart = this.$cart;
					$scope.$apply();
			}




	}




	app.controller('CartNotificationController', function($scope, $http) {

		$scope.no_in_cart="6453";
		$scope.$cart = [];
	});





	app.controller('ShopController', function($scope, $http, $sce) {

		$scope.$shop = [];


		$scope.fetch_page_content = function () {
				// console.log($sce);
				$scope.$shop = new Shop($sce);


		} 

		$scope.fetch_page_content();
});


app.directive("w3TestDirective", function() {

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
        <div class="cover">
          <i ng-hide="$carousel.$index==0" ng-click="$carousel.back()" class="fa fa-chevron-circle-left fa-2x backleft"> </i>  
          <i ng-hide="($carousel.$index+1)==$carousel.$files.length" ng-click="$carousel.next()" 
          class="fa fa-chevron-circle-right fa-2x nextright"> </i>  

           <img ng-if="$carousel.$current_file.file_type=='image'" src="{{$carousel.$current_file.file_path}}" 
           class ="d-block w-100 cover-video" alt="">

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
        `,
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