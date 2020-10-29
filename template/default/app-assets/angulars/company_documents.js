    List = function($data = []){
        this.$active_list = [];
        this.$edit_list = [];
        this.$lists = $data;

        this.add_component = function ($hospital = {}) {
            this.$active_list.unshift($hospital);
        }


        this.add_to_edit_list = function ($hospital = {}) {
            this.$edit_list.unshift($hospital);
            $('#edit_data').modal('show');
        }



        this.delete_component = function($hospital) {

            for(x in this.$active_list){
                
                if ($hospital == this.$active_list[x]) {
                    this.$active_list.splice(x, 1);
                }
            }
        }


        this.delete_edit_list = function($hospital) {

            for(x in this.$edit_list){
                
                if ($hospital == this.$edit_list[x]) {
                    this.$edit_list.splice(x, 1);
                }
            }
        }

        this.edit_hospital = function($hospital){
            this.add_to_edit_list($hospital);
        }   


        this.remove_hospital_from_table = function($hospital) {

            for(x in this.$lists){
                
                if ($hospital == this.$lists[x]) {
                    this.$lists.splice(x, 1);
                }
            }
        }


        this.attempt_request_for_review = function(){
                window.$confirm_dialog = new DialogJS(this.request_for_review, [], 'Are you sure all forms are filled accuratedly');
        }

        this.request_for_review =  function(){

                $("#page_preloader").css('display', 'block');
                   $.ajax({
                        type: "POST",
                        contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                        processData: false, // NEEDED, DON'T OMIT THIS
                        url: $base_url+"/company/request_for_review",
                        cache: false,
                        success: function(data) {

                                angular.element($('#document_form')).scope().fetch_page_content();                         
                                
                                window.notify();
                              
                        },
                        error: function (data) {
                        },
                        complete: function(){
                         
                            $("#page_preloader").css('display', 'none');

                        }
                    });
        }





        this.attempt_delete = function($hospital, $key){
                window.$confirm_dialog = new DialogJS(this.delete, [$hospital,$key, this], 'Are you sure to delete <b>'+$hospital.label+'</b> ?' );
        }


        this.delete =  function($hospital,$key, $this){
            $hospital_id = $hospital.id;

                            console.log($hospital, $key);

                $("#page_preloader").css('display', 'block');
                   $.ajax({
                        type: "POST",
                        contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                        processData: false, // NEEDED, DON'T OMIT THIS
                        url: $base_url+"/company/delete_document/"+$key,
                        cache: false,
                        success: function(data) {

                            console.log($this);
                            console.log(data);
                         
                                window.notify();
                                if (data.response == true) {
                                    angular.element($('#document_form')).scope().fetch_page_content();                         
                                }
                              
                        },
                        error: function (data) {
                        },
                        complete: function(){
                         
                            $("#page_preloader").css('display', 'none');

                        }
                    });
        }


}



    app.controller('CompanyController', function($scope, $http) {

            $scope.$active_list = [];
            $scope.fetch_page_content = function () {

                        $("#page_preloader").css('display', 'block');

                        $http.get($base_url+'/company/fetch_company_list')
                            .then(function(response) {
                                $data = response.data;

                                    // console.log($data);
                                    
                                    $scope.$data = $data; 

                                    $scope.$list = new List($data.documents);  

                                    // console.log($scope.$list);

                                    if ($data.disable_btn=='true') {
                                         $('button').hide();
                                         $("form :input").prop("disabled", true);                  
                                    }

                                    $("#page_preloader").css('display', 'none');
                        });

                }

            $scope.fetch_page_content();



    });           


