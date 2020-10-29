
	function CourseTargetForm($course) {
			if ($course.goal ==null) {

				$course.goal = {};
			};

		this.$requirements 		= ($course.goal.requirements != null) ? $course.goal.requirements : [''];
		this.$target_students 	= ($course.goal.target_students != null)?$course.goal.target_students : [''];
		this.$aims 				= ($course.goal.aims != null)?$course.goal.aims : [''];


		this.new_requirement = function () {

			this.$requirements.push('');
		}

		this.delete_requirement = function ($index) {
			this.$requirements.splice($index, 1);
		}


		this.new_target_student = function () {
			this.$target_students.push('');
		}


		this.delete_target_student = function ($index) {
			this.$target_students.splice($index, 1);
		}



		this.new_aim = function () {
			this.$aims.push('');
		}

		this.delete_aim = function ($index) {
			this.$aims.splice($index, 1);
		}



	}


app.controller('CourseTargetController', function($scope, $http) {

	// $scope.$course_target = new CourseTargetForm;

$scope.$course = [];


	$scope.change_view_to = function ($view) {
			$scope.$current_view = $view;

		}








	$scope.fetch_page_content = function () {

			$http.get($base_url+'/course_api/find/'+$COURSE_ID)
			    .then(function(response) {

				    $scope.$course = response.data;
				    console.log($scope.$course)
				    	$scope.$course_target = new CourseTargetForm(response.data);

			          });



	} 

$scope.fetch_page_content();
});
