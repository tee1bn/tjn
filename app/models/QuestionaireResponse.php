<?php

use Illuminate\Database\Capsule\Manager as DB;

use Illuminate\Database\Eloquent\Model as Eloquent;
	
class QuestionaireResponse extends Eloquent 
{
	protected $fillable = [
					'questionaire_id',
					'response',
					'responder_id'
					];
	

	protected $connection = 'default';
	protected $table = 'survey_questionaires_responses';





	public function questionaire()
	{
		return $this->belongsTo('Questionaire','questionaire_id');
	}


	public function getQuizResponseAttribute()
	{

	}


	public function performance()
	{
		$response = $this->decodeResponses;
		$set_questions = $this->questionaire->decodeQuestions;

		$score = [];
		foreach ($response as $key => $res) {
		    $q_key = str_replace('q', '', $key);
		    $question = $set_questions[$q_key];


		    $answers =  array_map(function($item) use ($question){
		            $option_key =  @($item -1);
		            return (  $question['$options'][$option_key]['value']);

		    }, explode(',', $question['$attributes']['answers']));


		    if (in_array($res, $answers)) {
		        $score[$q_key] = 1;
		    }else{
		        $score[$q_key] = 0;
		    }
		}

			$correct = array_filter($score , function($response){
				return $response == 1;
			});

			$no_of_correct_response = count($correct);

			$performance = round(($no_of_correct_response / count($score) ) * 100 , 3);

			$normal_score = "$no_of_correct_response/".count($score);

			$returned_performance = [
					'performance'=>  $score,
					'percentage'=> $performance,
					'score'=> $normal_score,
			];

		return $returned_performance;
	}



	public function getCorrectionsAttribute()
	{
		$performance = $this->performance();
		$failed_questions_indexes = array_filter($performance['performance'], function($answer){
			return $answer == 0;
		});

		$set_questions = $this->questionaire->decodeQuestions;

		$score = $performance['score'];
		$correction = "You scored $score";


		if (count($failed_questions_indexes) > 0) {
			$correction .= "<h4>Correction</h4>";
		}
		foreach ($failed_questions_indexes as $q_index => $answer ) {
			$question = $set_questions[$q_index]['$attributes']['question'];
			$answer_key = $set_questions[$q_index]['$attributes']['answers'] - 1;
			$answer = $set_questions[$q_index]['$options'][$answer_key]['value'];

			$question_no= $q_index + 1;
			$abc = ['A','B','C','D', 'E'];
			$alphabet = $abc[$answer_key];

			$correction .= "$question_no) $question <br><small>Ans <b>$alphabet</b>:</small> $answer <br>";
		}

		return $correction;
	}	


	public function getdecodeResponsesAttribute()
	{	

		if ($this->response == null) {
			return [];			
		}

		return json_decode($this->response , true);
	}
}


















?>