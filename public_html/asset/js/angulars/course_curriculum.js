
	function Lecture($lecture) {

		this.$data = $lecture;
/*		this.$content = $content;
		this.$title = $title;

*/		this.add_content = function ($content) {
								this.$content = ($content);
							}

		this.remove_content = function ($content) {
								this.$content = null;
							}

	}




	function Section($lectures=[], $title = '' ) {
		this.$lectures = $lectures;
		this.$title = $title;


		this.add_lecture = function () {

				this.$lectures.push(new Lecture);

		}

		this.remove_lecture = function ($lecture) {

		// let $index = this.$lectures.indexOf($lecture);
		this.$lectures.splice($lecture,  1);

		}



	}
	

	function Curriculum($sections = []) {
		this.$sections = [];

		this.init = function () {

			if ( ($sections == null) ) {

				let $lecture = new Lecture;
				let $section = new Section([$lecture]);
				this.$sections.push($section);
				return;
			}

			for(x in $sections){
				$section = $sections[x];
				var	$lecture_objs = []; 
						for(y in $section.$lectures){
						var	$lecture 		= $section.$lectures[y];
						var	$lecture_obj 	= new Lecture ($lecture.$data);

						$lecture_objs.push($lecture_obj);
						console.log($lecture_objs);
						}
						
				$section_obj = new Section ($lecture_objs, $section.title)
				// console.log($section);

				this.$sections.push($section_obj);

			}
		}
		this.init();


		this.add_section = function () {
			this.$sections.push(new Section);
		}


		this.remove_section = function ($index) {

		// let $index = this.$sections.indexOf($section);
		this.$sections.splice($index,  1);
		}

			this.build_form = function () {
					$form = new FormData();

				for(x in this.$sections){
					$section = this.$sections[x];

			$form.append('sections['+x+'][title]' ,   $section.$title );

					for(y in $section.$lectures){
						$lecture = $section.$lectures[y];

						$form.append('sections['+x+'][lectures]['+y+'][title]' , $lecture.$title   );
						$form.append('sections['+x+']['+y+']' , $lecture.$content   );
					}

				}

				// console.log($form);

		$form.append('course_id',  $COURSE_ID);

		 $.ajax({
            type: "POST",
            url: $base_url+"/courses/add_course_curriculum",
            cache: false,
            contentType: false,
            processData: false,
            data: $form,
            success: function(data) {
              // console.log(data);
              // $scope.fetch_page_content();
              window.notify();

           var   $scope = angular.element($('#course-curriculum')).scope();
              $scope.fetch_page_content();

            },
            error: function (data) {
                 //alert("fail"+data);
            }

            

        });


			}


	}

add_content = function ($lecture, $element) {
	$lecture.add_content($element.files[0]) ;
	// console.log($lecture, $element);
}



app.controller('CourseCurriculumController', function($scope, $http) {

	// $scope.$course_target = new CourseTargetForm;



	$scope.change_view_to = function ($view) {
			$scope.$current_view = $view;

		}








	$scope.fetch_page_content = function () {

			$http.get($base_url+'/course_api/find/'+$COURSE_ID)
			    .then(function(response) {

				    $scope.$course = response.data;
				    console.log($scope.$course);

					$scope.$curriculum =  new Curriculum(response.data.curriculum);
					$scope.$quizes =  	(response.data.quizes);



			          });



	} 

$scope.fetch_page_content();
});



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



app.directive('ckEditor', function () {
    return {
        require: '?ngModel',
        link: function (scope, elm, attr, ngModel) {

        
            var ck = CKEDITOR.replace(elm[0],{

                filebrowserBrowseUrl: '/uploads/media',
                filebrowserImageBrowseUrl: '/uploads/media?type=Images',
                filebrowserUploadUrl: '/media/upload/files',
                filebrowserImageUploadUrl: '/media/upload/images'
            });
 
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




app.directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    scope.$apply(function () {
                        scope.fileread = loadEvent.target.result;
                    });
                }
                reader.readAsDataURL(changeEvent.target.files[0]);
            });
        }
    }
}]);