<?php
error_reporting(E_ERROR | E_WARNING );

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Questionaire extends Eloquent 
{
	
	protected $fillable = [
							'title',
							'success_response_note',
							'description',
							'code',
							'questions',
							'is_published',
							'questions_served',
							'alotted_time',
							'link',
							'start_time',
							'end_time'	
						];
	

	protected $connection = 'default';
	protected $table = 'survey_questionaires';
	



	public function scopeQuizes($query)
	{
		return $query->where('questions_served', '>' , 1);
	}

	public function scopePublished($query)
	{
		return $query->where('is_published', 1);
	}


	public function is_quiz()
	{
		return $this->questions_served > 0; 
	}



	public function getpublishedStatusAttribute()
	{
			switch ($this->is_published) {
				case 1:
				$status = '<span class="badge badge-xs badge-primary">Published</span>';
					break;
				
				case 0:
				$status = '<span class="badge badge-xs badge-danger ">Not Published</span>';
					break;
				
				default:
					# code...
					break;
			}

			return $status;
	}



	public function html_form($redirect=null)
	{
		switch ($this->is_quiz()) {
			case true:
				$action = Config::domain().'/survey_submit/submit_quiz';
				$alotted_time =  "<span class='float-right'>
									<i class='ft-clock'></i> <span id='demo'>{$this->alotted_time}</span>
								</span>";

				break;
			
			default:
				$action = Config::domain().'/survey_submit/submit_survey';
				$alotted_time ="";
				break;
		}

			$alotted_time ="";



// / <input type='hidden' name='actions' value='submit_survey'>

		$form= "<form id='survey_form' class='ajax_form' action='$action' data-function='go_to_next' data-toggle='validator' method='POST'>

                                    <h5 class='text-uppercase text-center signup-header'>{$this->title}
                                    	$alotted_time
                                    </h5>
                                    <p class='text-center'><small>{$this->description}</small></p>
                                    <input type='hidden' name='code' value='{$this->code}'>
		";

		$form_fields= "";

		$questions_array = json_decode($this->questions , true);


				//use only select if quiz
				if (($this->is_quiz())) {
					$questions_array = collect($questions_array)->filter(function($question){
						return $question['$form_field'] == 'select';
					});

					if ($questions_array->count() >= $this->questions_served) {
						$questions_array = $questions_array->random($this->questions_served);
					}
				}


			foreach ($questions_array as $key => $question) {

				$question_no = $key+1;
				$form_fields .= "<div class='form-group'>
								$question_no) <label>{$question['$attributes']['question']}</label>
								";
				$required = '';
				if ($question['$attributes']['required'] == true) {
					$required = "required='required'";
				}



				$name = 'q'.$question['$index'];
					switch ($question['$form_field']) {
						case 'input':

							$form_fields .= "<input 
											name ='$name' 
											type='{$question['$attributes']['type']}'
											placeholder='{$question['$attributes']['placeholder']}'
											{$required}
											min='{$question['$attributes']['min']}'
											max='{$question['$attributes']['max']}'
											minlength='{$question['$attributes']['minlength']}'
											maxlength='{$question['$attributes']['maxlength']}'
											 class='form-control' />";

							break;
						case 'select':
								$options = "<option value=''>Select</option>";
							foreach ($question['$options'] as $key => $option) {
								$options .= "<option value='{$option['value']}'>{$option['value']}</option>";
							}

							$multiple='';
							if ($question['$attributes']['multiple'] == true) {
								$multiple = "multiple='multiple'";
								 $name .='[]';
							}


							if ($this->is_quiz()) {
								$abc = ['A','B','C','D', 'E'];
									$options = "";
								foreach ($question['$options'] as $key => $option) {
									$alphabet = $abc[$key];
									$options .= "<label style='display:block; margin-left:20px;'>$alphabet)   <input type='radio' {$required}  name='$name' value='{$option['value']}'>{$option['value']}</label>";
								}

								$form_fields .= $options;


							}else{


								$form_fields .= "
								<select  class='select2Multiple form-control' {$required}  {$multiple} name='$name'>
									$options
								</select>
								";
							}


							break;

						case 'textarea':

							$form_fields .= "<textarea 
											name ='$name' 
											placeholder='{$question['$attributes']['placeholder']}'
											{$required}
											rows='{$question['$attributes']['rows']}'
											min='{$question['$attributes']['min']}'
											max='{$question['$attributes']['max']}'
											minlength='{$question['$attributes']['minlength']}'
											maxlength='{$question['$attributes']['maxlength']}'
											 class='form-control'></textarea>";
							break;
						
						default:
							# code...
							break;
					}



				$form_fields .= "</div>";


			}



			$form .= $form_fields. " 
			<button class='btn btn-secondary' type='submit'>Submit</button>
			</form>";

			$this->form = $form;

		return $this;
	}



	public function geteditLinkAttribute()
	{
		$domain = Config::domain();

		$link = "$domain/survey/edit-questionaire/{$this->id}";
		$link2 = Config::domain()."/admin/admin.php?url=survey/edit-questionaire/{$this->id}";
		return $link2;
	}


	public function getPreviewLinkAttribute()
	{
		$domain = Config::domain();

		$link = "$domain/home/survey/?survey_id={$this->code}";
		return $link;
	}


	public function getviewResponsesAttribute()
	{
		$domain = Config::domain();


		$link2 = Config::domain()."/survey/questionaire-responses/{$this->id}";
		return $link2;
	}


	public function getdeleteLinkAttribute()
	{
		$domain = Config::domain();

		$link = "$domain/survey/delete-questionaire/{$this->id}";



		$link2 = Config::domain()."/admin/admin.php?url=survey/delete-questionaire/{$this->id}";
		return $link2;

	}


	public function getviewResponsesTableAttribute()
	{
		$domain = Config::domain();

		$link = "$domain/survey/questionaire-responses-table/{$this->id}";


		$link2 = Config::domain()."/admin/admin.php?url=survey/questionaire-responses-table/{$this->id}";
		return $link2;


		return $link;
	}


	public static function createLink()
	{
		$domain = Config::domain();

		$link2 = Config::domain()."/survey/create-questionaire";
		return $link2;



		return $link;
	}



	public function getdecodeQuestionsAttribute()
	{	



		if ($this->questions == null) {
			return [];			
		}

		return json_decode($this->questions , true);
	}



}


















?>