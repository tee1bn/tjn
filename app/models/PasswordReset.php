<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class PasswordReset extends Eloquent 
{
	
	protected $fillable = [ 'email', 'token'];
	
	protected $table = 'password_reset';




}


















?>