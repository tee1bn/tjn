
    Payout = function($data){

        this.$data   = $data;
      
        this.export_as_pdf = function () {
              

                 window.location.href = $base_url+'/admin/export_payout_to_pdf/'+$month;
        }

    
        this.is_privilege = function ($employee) {

            try{

                if(this.$privilege_employees_ids.indexOf(String($employee.id)) != -1)
                {  
                    return true;
                }
                    return false;
            }catch(e){}
        }
    }

    app.controller('PayoutController', function($scope, $http) {

            $scope.export_as_pdf = function (){
                 window.location.href = $base_url+'/admin/export_payout_to_pdf/'+$month;
            }

            $scope.fetch_page_content = function ($month=null) {
                console.log($month);

                        if ($month==null) {return;}
                        $("#page_preloader").css('display', 'block');

                        $http.get($base_url+'/admin/payouts_view/'+$month)
                            .then(function(response) {
                                $data = response.data;

                                    window.notify();
                                    console.log($data);
                                    $scope.$doc_page = new Payout($data);
                                    console.log($scope.$doc_page);

                                    $("#page_preloader").css('display', 'none');
                        });

                }

            $scope.fetch_page_content();

            $scope.load = function () {
                $month = $('#schedule_period')[0].value;

                $scope.$path = $base_url +"/admin/payouts_html/"+$month;

                // $scope.fetch_page_content($month);
            }


    });           


