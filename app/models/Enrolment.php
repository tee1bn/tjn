<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class Enrolment extends Eloquent 
{
	
	protected $fillable = [ 'student_id','course_id', 'instructor_id'];
	
	protected $table = 'course_enrolments';





		public function instructor()
		{
			return $this->belongsTo('User', 'instructor_id');
		}


		public function student()
		{
			return $this->belongsTo('User', 'student_id');
		}

		public function course()
		{
			return $this->belongsTo('Course', 'course_id');
		}

}


















?>