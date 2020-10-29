




	app.controller('SchemeController', function($scope, $http) {

		$scope.$schemes=  [];


            $scope.change = function ($job_description) {
                $scope.$jd = JSON.parse($job_description);

                 CKEDITOR.instances['editor1'].destroy(true);
                 CKEDITOR.replace( 'editor1' );

            }




            $scope.fetch_page_content = function () {

                        $http.get($base_url+'/admin/fetch_subscription/')
                            .then(function(response) {
                                $data = response.data;
                                $scope.$schemes = $data;
                                console.log($data);
                        });

                }

            $scope.fetch_page_content();


	});

