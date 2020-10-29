function get_random_int(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function unique_and_occurence(arr) {
    var a = [], b = [], prev;
    
    arr.sort();
    for ( var i = 0; i < arr.length; i++ ) {
        if ( arr[i] !== prev ) {
            a.push(arr[i]);
            b.push(1);
        } else {
            b[b.length-1]++;
        }
        prev = arr[i];
    }
    
    $result = {};
    for(x in a){

        $input =  a[x],
        $occurence =  b[x],
        $font_size =  ($occurence / arr.length) * 20;
        $font_size += 7;
        $color = "#"+ get_random_int(100000, 999999);



        $result[x] = {
            'input':$input,
            'occurence': $occurence,
            'font_size': $font_size,
            'colour': $color,
        }
    }   

    return $result;
}
    
    Questionaire = function ($data){

        this.$data = $data;
        this.$questions = [];
        this.$question_pad = new QuestionPad();

        this.$booleans = ['true','false'];


        this.init = function  (){

            for(x in $data.questionaire.questions){
                $question = $data.questionaire.questions[x];

                switch($question.$form_field) {
                  case 'input':
                        this.$questions.push(new Input($question));
                    break;

                  case 'select':
                        this.$questions.push(new Select($question));
                    break;


                  case 'textarea':
                        this.$questions.push(new Textarea($question));
                    break;



                  default:
                        console.log("nothin is an input field");
                    break;
                }

            }
        }

        this.init();

        this.remove_question = function ($question){

              for(x in this.$questions){
                
                if ($question == this.$questions[x]) {
                    this.$questions.splice(x, 1);
                }
            }

        }


        this.edit_question = function ($question){
            //open modal for editing question
        }

        this.add_question = function($form_field){



            switch($form_field) {
              case 'input':
                    this.$questions.push(new Input());
                break;

              case 'select':
                    this.$questions.push(new Select());
                break;



              case 'textarea':
                    this.$questions.push(new Textarea());
                break;



              default:
                    console.log("nothin is an input field");
                break;
            }
        }


        this.set_question = function(){
            this.$question_pad.open_edit_pad();
        }


        
        this.get_question = function($type) {
               $sorted_questions = {};

               for(x in this.$questions){
                    $question = this.$questions[x];

                    if ($question.$form_field == $type) {
                        $question_no = 'q'+x;
                        $sorted_questions[$question_no] = ($question);
                    }
               } 
               return $sorted_questions;
        }    


        this.see_response = function($answer){

                $('#single_response').modal('show');
                if (typeof($answer.response) != 'object') {
                    $answer.response = JSON.parse($answer.response);
                }

                $response={'response': {}};

                for(x in this.$questions){
                    $question = this.$questions[x].$attributes.question;
                    $question_no = 'q'+x;

                    $response['response'][$question_no] = {
                            'question': $question,
                            'response': $answer.response[$question_no],
                    }
                }

                $response['detail'] = $answer;

                this.$see_response = $response; 

        }

        this.show_response = function($answer){


                if (typeof($answer) == 'object') {
                    $return = '';
                    for(x in $answer){
                        $ans =$answer[x];
                        $return += ` <label class="label label-danger">${$ans}</label> `;
                    }

                    return $return;
                }else{


                    return $answer;
                }

             

        }


    }




    Input = function ($data=null) {

        this.$form_field = 'input';
        this.$types = ['text','email','number', 'password', 'url', 'date'];
        this.$unique_options = [true, false];
        this.$attributes = {};

        this.init = function($data) {
            if ($data != null) {
                this.$form_field = $data.$form_field;
                this.$attributes = $data.$attributes;
            }
        }

        this.init($data);



        this.$shown_attributes = ['type','question','placeholder','required','min','max', 'minlength','maxlength','unique'];


        this.is_shown = function($attribute){
            $boolean = this.$shown_attributes.indexOf($attribute) != -1; 
            return ($boolean);

        }


        this.get_stat = function ($question_no) {
                $scope = angular.element($('#respon')).scope();
                $responses = $scope.$response;

                $ans = [];

             $count = 0;
                for(x in $responses){
                    $response = $responses[x];
                    $answers = JSON.parse($response.response);

                    $ans.push($answers[$question_no]);
                   
                }


                $unique_answers = $ans.filter(function($value, $index, self){
                     return self.indexOf($value) === $index;

                });



                $unique_and_occurence = unique_and_occurence($ans);    

                return $unique_and_occurence;

        }



    }

    Select = function ($data=null) {
        this.$form_field = 'select';
        this.$types = ['text','email','number', 'password', 'url', 'date'];
        this.$attributes = {};
        this.$options = [];

        this.$shown_attributes = ['option', 'question','options_button','required', 'multiple','answers'];



        this.init = function($data) {
            if ($data != null) {
                this.$form_field = $data.$form_field;
                this.$attributes = $data.$attributes;

                for(x in $data.$options){
                    $option = $data.$options[x];
                    this.$options.push($option);
                }

            }
        }

        this.init($data);





        this.is_shown = function($attribute){
            $boolean = this.$shown_attributes.indexOf($attribute) != -1; 
            return ($boolean);

        }


        this.add_option = function(){
            $option = {};
            this.$options.push($option);

        }


        this.delete_option = function ($option){

              for(x in this.$options){
                
                if ($option == this.$options[x]) {
                    this.$options.splice(x, 1);
                }
            }

        }

        this.$filtered_option=[] ;

        this.options_stat =  function(){

                $filtered_option = this.$filtered_option;
                $options = this.$options;

                  if ($filtered_option.length ==0) {
                    return this.$options;
                  }  



                 $filtered_options =    $options.filter(function($option){
                        if ($filtered_option.indexOf($option.value) != -1) {
                            return true;
                        }
                    });

            return $filtered_options;
        }


        this.no_of_selections = function($option, $question_no){

                $scope = angular.element($('#respon')).scope();
                $responses = $scope.$response;

                $count = 0;
                for(x in $responses){
                    $response = $responses[x];
                    $answers = JSON.parse($response.response);

                    if ($answers[$question_no] == $option.value) {
                        $count++;
                    }

                    $selections = $answers[$question_no];

                    if (typeof($selections) == 'object') {

                        if ($selections.indexOf($option.value) != -1)  {
                            $count++;
                        }
                    }
                }

                return $count;
        }
    }

    Textarea = function ($data=null) {
        this.$form_field = 'textarea';
        this.$types = ['text','email','number', 'password', 'url', 'date'];
        this.$attributes = {};


        this.$shown_attributes = ['rows','question','placeholder','required', 'min','max', 'minlength','maxlength'];

        this.init = function($data) {
            if ($data != null) {
                this.$form_field = $data.$form_field;
                this.$attributes = $data.$attributes;
            }
        }

        this.init($data);


        this.is_shown = function($attribute){
            $boolean = this.$shown_attributes.indexOf($attribute) != -1; 
            return ($boolean);
        }
    }






    QuestionPad = function () {
        this.$question;

        this.open_edit_pad = function ($question) { 
            if ($question != undefined) {
                this.$question= $question;
            }

            $("#question_setter").modal('show');            
        }


        this.set_form_field =  function ($form_field){

            switch($form_field) {
              case 'input':
                    this.$question = new Input();
                break;

              default:
                    // console.log("nothin is an input field");
                break;
            }



        }
    }


    app.controller('QuestionaireResponseController', function($scope, $http) {

            $scope.fetch_page_content = function () {

                        $("#page_preloader").css('display', 'block');
                        $http.get($base_survey_url+'?url=survey_crud/fetch_response/'+$questionaire_id)
                            .then(function(response) {
                                $data = response.data;
                                    // console.log($data);
                                    $scope.$response = ($data.questionaire_response);
                                    $scope.$questionaire = new Questionaire($data.questionaire);
                                  /*  
                                    console.log($data);
                                    console.log($scope.$response);*/
                                    $("#page_preloader").css('display', 'none');
                        });

                }

            $scope.fetch_page_content();




    });           




    app.controller('QuestionaireController', function($scope, $http) {



            $scope.fetch_page_content = function () {

                        $("#page_preloader").css('display', 'block');
                        $http.get($base_survey_url+'?url=survey_crud/fetch_questions/'+$questionaire_id)
                            .then(function(response) {
                                $data = response.data;

                                    // console.log($data);
                                    $scope.$questionaire = new Questionaire($data);
                                    
                                    console.log($data);
                                    console.log($scope.$questionaire);
                                    $("#page_preloader").css('display', 'none');
                        });

                }

            $scope.fetch_page_content();




    });           


    


app.filter('replace', [function () {

    return function (input, from, to) {
      
      if(input === undefined) {
        return;
      }
  
      var regex = new RegExp(from, 'g');
      return input.replace(regex, to);
       
    };


}]);


