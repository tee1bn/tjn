    World = function(){
        this.$countries = [];
        this.$states = [];
        this.$cities = [];
        this.$country = ""; 
        this.$state = ""; 
        this.$city = ""; 
        this.$auth = {}; 


        this.fetch_cities = function (){
            $this = this;


            $.ajax({
                 type: "POST",
                 contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                 processData: false, // NEEDED, DON'T OMIT THIS
                 url: $base_url+"/world/cities?state_id="+$this.$state,
                 cache: false,
                 success: function(data) {

                    $this.$cities = data.cities;
                    if ($this.$auth != {}) {
                        $this.$city = $this.$auth.city;
                    }



                    angular.element($('#registration_form')).scope().$apply();                         
                       
                 },
                 error: function (data) {
                 },
                 complete: function(){
                  

                 }
             });

        }


        this.fetch_states = function (){
            $this = this;
            $this.$country = 160;

            $.ajax({
                 type: "POST",
                 contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                 processData: false, // NEEDED, DON'T OMIT THIS
                 url: $base_url+"/world/states?country_id="+$this.$country,
                 cache: false,
                 success: function(data) {

                    $this.$states = data.states;


                    if ($this.$auth != {}) {
                        $this.$state = $this.$auth.state;
                        $this.fetch_cities();
                    }
                    angular.element($('#registration_form')).scope().$apply();                         
                       
                 },
                 error: function (data) {
                 },
                 complete: function(){
                  

                 }
             });

        }

        this.fetch_states();

        this.init = function(){
            $this = this;

            $.ajax({
                 type: "POST",
                 contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                 processData: false, // NEEDED, DON'T OMIT THIS
                 url: $base_url+"/world/countries",
                 cache: false,
                 success: function(data) {

                    $this.$auth = data.auth;
                    $this.$countries = data.countries;

                    if ($this.$auth != {}) {
                        $this.$country = $this.$auth.country;
                        $this.fetch_states();
                    }


                    angular.element($('#registration_form')).scope().$apply();                         
                    console.log($this.$auth) ;
                 },
                 error: function (data) {
                 },
                 complete: function(){
                  

                 }
             });

        }

        this.init();
    }



    app.controller('RegisterationController', function($scope, $http) {

            $scope.$world = new World;

           

            // $scope.$apply();



    });           


