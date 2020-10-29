<?php

namespace v2\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;
use  Filters\Traits\Filterable;
use  v2\Models\AdminComment;


class UserDocument extends Eloquent 
{
    use Filterable;
	
	protected $fillable = [
		'user_id', 
		'document_type',
		'path',
		'status',
	];
	

	protected $table = 'users_documents';

    
    public static $statuses = [1=> 'In Review',2=> 'Approved', 3=> 'Declined'];
    public static $document_types = [
     /*   1 => [
                'name'=> 'Passport Photo',
                'instruction'=> 'Passport Photo',
            ],*/

        2 => [
                'name'=> 'ID Card',
                'instruction'=> 'Please upload a clear government issued ID card e.g Driver License, Passport, PVC (Permanent voters card).
                <br>suported format are: .jpg, .png',
            ],

        3 => [
                'name'=> 'Address ',
                'instruction'=> 'Please upload a clear proof of residence e.g Utility bill, Waste Bill, Electricity bill, Water bill, Bank statement (having your fullname and address as filled during registration) <br> suported format are: .jpg, .png',
            ],

     
    ];	 

    
    public static function get_status($status)
    {
        $order = new self();
        $order->status = $status;

        return $order->DisplayStatus;
    }


    public function adminComments()
    {       
         $comments =   AdminComment::where('model_id', $this->id)->where('model', 'user_document')->get();
         return $comments;
    }


    public function getTypeAttribute()
    {
        return self::$document_types[$this->document_type];
    }


    public function is_status($status)
    {
        return $this->status == $status;
    }
    public function is_approved()
    {
        return $this->status == 2;
    }


    public function scopeApproved($query)
    {
        return $query->where('status', 2);
    }


    public function getDisplayStatusAttribute()
    {
    	switch ((string)($this->status)) {
    		case 2:
    			$status = '<span class="badge badge-success"> Approved</span>';
    			break;
    		
    		case 1:
    			$status = '<span class="badge badge-warning"> In review</span>';
    			break;
    		
    		case 3:
    			$status = '<span class="badge badge-danger"> Declined</span>';
    			break;
    		
    		default:
    			$status = '<span class="badge badge-warning"> Unknown</span>';
    			break;
    	}

    	return $status;
    }


    public function user()
    {
    	return $this->belongsTo('User', 'user_id');
    }



}


















?>