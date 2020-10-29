	
	function Cart(){
		this.$items = [];
		this.$total  = 0;

		this.contains_object =  function(obj, list) {
		    var i;
		    for (i = 0; i < list.length; i++) {
		        if ((list[i] === obj ) || (list[i]['id'] == obj.id)) {
		            return true;
		        }

    			}
    			return false;
				}


			this.add_item = function($item){

				//ensure item is not added in cart more than once
				if (this.contains_object($item, this.$items)) {
					window.show_notification('<b>'+$item.title+'</b><br> already in cart !');
					return ;
				}

				this.$items.push($item);

				this.update_server();
				window.show_notification('<b>'+$item.title+'</b><br> added to cart successfully!');
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
					this.$items = [];
					this.update_server();

					}

		
			this.update_server = function () {
				$scope = angular.element($('#cart-notification')).scope();
				$scope.$cart = this.$items;
				$total = 0;

					for(x in $scope.$cart){
						$total += $scope.$cart[x].price;
						this.$total = $total;
					}

				$scope.$total = $total;

				$form = new FormData ();
				for(x in this.$items){
					$item = this.$items[x];
					$form.append('items[]', JSON.stringify($item));
					};
		
		 $.ajax({
            type: "POST",
            url: $base_url+"/course_api/update_cart",
            cache: false,
            contentType: false,
            processData: false,
            data: $form,
            success: function(data) {
              console.log(data);
              // $scope.fetch_page_content();
              window.notify();
            },
            error: function (data) {
                 //alert("fail"+data);
            }

           });

				

			}

	}


	function Shop($items) {
		this.$items = [];
		this.$cart = new Cart();
		this.$quickview ;


		this.add_item = function($new_items= []){
				for(x in $new_items){
				var $new_item = $new_items[x];
				this.$items.push($new_item);
				}

			}
		
		this.add_item($items);

		this.quickview = function ($item) {
					this.$quickview = $item;
					$('#quick_view_modal').modal('show');			
			}



	}




app.controller('CartNotificationController', function($scope, $http) {

	$scope.no_in_cart="6453";
	$scope.$cart = [];
});





app.controller('ShopController', function($scope, $http) {


	// $scope.$course_target = new CourseTargetForm;

$scope.$course = 'lll course';

$scope.$shop = [];







	$scope.fetch_page_content = function () {
			$page = 1;
			
			$category = $category_id = 0;

			$http.get($base_url+'/course_api/fetch_courses/'+$page+'/'+$category)
			    .then(function(response) {

				    // console.log(response.data);
				    $scope.$shop = new Shop(response.data);

				    console.log($scope.$shop);
		
		$http.get($base_url+'/course_api/retrieve_cart_in_session/')
			    .then(function(response) {

				    // console.log(response.data);
				    	 for(x in response.data){
				    	var $item = response.data[x];
				    	$scope.$shop.$cart.$items.push($item);
				    }
				    	$scope.$shop.$cart.update_server();

				    			          });
				    			          });





	} 

$scope.fetch_page_content();
});
