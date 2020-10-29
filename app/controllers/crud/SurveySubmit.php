<?php

/**
 *
 */
class SurveySubmit extends controller
{


    public function score($response_id)
    {
        $response = QuestionaireResponse::find($response_id);

        echo "<pre>";
        print_r($response->performance());
    }


    public function submit_quiz()
    {

                    $posted = $_REQUEST;
                    unset($posted['url']);
                    unset($posted['action']);
                    unset($posted['code']);

                    $response = $posted;

                    $code = $_REQUEST['code'];

                    $questionaire = Questionaire::where('code', $code)->first();

                    if ($questionaire == null) {
                        die();
                    }


                    $client = $this->auth();

                    if ($questionaire->is_quiz() && ($client==null)) {
                        Session::putFlash('info', 'Please sign in to complete this quiz');
                        Redirect::back() ;
                    }


                    if ($questionaire->is_quiz()) {
                         $client_id = $client->id;
                    }else{
                        $client_id = null;
                    }

                    if ($this->admin()) { //process if admin is logged in
                            $client_id = null;
                    }

                    $set_questions = $questionaire->decodeQuestions;


                    try {
                        
                        $new_response =     QuestionaireResponse::create(
                                            [
                                                'questionaire_id' => $questionaire->id,
                                                'response' => json_encode($response),
                                                'responder_id' => $client_id
                                            ]);



                        if ($new_response->Corrections != false) {

                            Session::putFlash('dark', $new_response->Corrections);
                            $correction = $new_response->Corrections;
                            header("content-type:application/json");
                            echo json_encode(compact('correction'));
                        }

                        if ($questionaire->success_response_note != '') {

                            // Session::putFlash('success', $questionaire->success_response_note);
                        }

                    } catch (Exception $e) {
                        print_r($e->getMessage());
                        
                        Session::putFlash('danger', 'This response already exist');
                    }


                    // Redirect::back();
            
    }



    public function submit_survey()
    {

        $posted = $_REQUEST;
        unset($posted['url']);
        unset($posted['action']);
        unset($posted['code']);

        $response = $posted;

        $code = $_REQUEST['code'];

        $questionaire = Questionaire::where('code', $code)->first();

        if ($questionaire == null) {
            die();
        }


        $client = $this->auth();

        if ($questionaire->is_quiz() && ($client == null)) {
            Session::putFlash('info', 'Please sign in to complete this quiz');
            Redirect::back();
        }


        if ($questionaire->is_quiz()) {
            $client_id = $client->id;
        } else {
            $client_id = null;
        }

        $set_questions = $questionaire->decodeQuestions;
        foreach ($set_questions as $key => $ques) {
            $unique = $ques['$attributes']['unique'];
            $question_key = "q$key";
            if ($unique == true) {

                $resp = trim($response[$question_key]);

                $submitted_responses = QuestionaireResponse::where('questionaire_id', $questionaire->id)->get();


                foreach ($submitted_responses as $key => $submitted_response) {
                    $s_response = $submitted_response->decodeResponses;

                    $actual_response = $s_response[$question_key];

                    if ($resp == $actual_response) {

                        Session::putFlash('danger', 'This response already exist');
                        Redirect::back();
                    }
                }
            }
        }

        try {

            $new_response = QuestionaireResponse::create(
                [
                    'questionaire_id' => $questionaire->id,
                    'response' => json_encode($response),
                    'responder_id' => $client_id
                ]);
            Session::putFlash('success', $questionaire->success_response_note);

        } catch (Exception $e) {

            Session::putFlash('danger', "Response already exists");
        }


        Redirect::back();

    }


}