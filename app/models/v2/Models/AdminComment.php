<?php


namespace v2\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;


class AdminComment extends Eloquent 
{
	
	protected $fillable = [
							'admin_id',
							'model',
							'model_id',
							'comment',
							'status'
						];
	

	protected $table = 'admin_comments';
	

	public static $commentables = [
		'user_document' => [
			'model' => 'v2\Models\UserDocument'
		],
		'bank' => [
			'model' => 'v2\Models\UserBank'
		],
		'deposit' => [
			'model' => 'v2\Models\DepositOrder'
		],
		'withdrawal' => [
			'model' => 'v2\Models\Withdrawal'
		],

	];


	


	public function admin()
	{
		return $this->belongsTo('Admin', 'admin_id');
	}



	public function item()
	{
		$model = self::$commentables[$this->model]['model'];
		return $this->belongsTo($model, 'model_id');
	}




}


















?>