<?php


namespace v2\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;


class FinancialBank extends Eloquent 
{
	
	protected $fillable = [
							'bank_name',
							'code',
						];
	

	protected $table = 'bank';

}


















?>