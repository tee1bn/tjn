<?php

namespace v2\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as DB;
use  Filters\Traits\Filterable;
use  v2\Models\AdminComment;


class UserBank extends Eloquent 
{
    use Filterable;
	
	protected $fillable = [
		'user_id', 
		'account_name',
		'account_number',
		'bank_id',
		'remark',
		'status',
	];
	

	protected $table = 'users_banks';
	public static $statuses = ['pending'=> 'In Review','approved'=> 'Approved', 'declined'=> 'Declined'];


    public function getAccountHolderAttribute()
    {

        $params = http_build_query([
            'account_number'=>  $this->account_number,
            'bank_code'=>   $this->financial_bank->code
        ]); 

        

        $secret_key = "sk_live_a92dd4f36c81677ea1e02b7b9c0257bb86230e45";

        $url = "https://api.paystack.co/bank/resolve?$params";
        $header = [
            "Authorization: Bearer $secret_key"
        ];
        $response = \MIS::make_get($url, $header);

        $response = json_decode($response, true);

        $account_name = $response['data']['account_name'];
        return $account_name;
    }

    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    
    public static function get_status($status)
    {
        $order = new self();
        $order->status = $status;

        return $order->DisplayStatus;
    }



    public function adminComments()
    {       
         $comments =   AdminComment::where('model_id', $this->id)->where('model', 'bank')->get();
         return $comments;
    }



    public function is_approved()
    {
        return $this->status == 'approved';
    }


    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }


    public static function create_or_update($bank_detail)
    {
        DB::beginTransaction();

        try {

                $detail =    self::create([
                                    'user_id' => $bank_detail['user_id'],
                                    'account_name'  => $bank_detail['account_name'],
                                    'account_number'    => $bank_detail['account_number'],
                                    'bank_id'   => $bank_detail['bank_id'],
                                    'remark'    => $bank_detail['remark'],
                                ]);
                    
            DB::commit();

            return $detail;
        } catch (Exception $e) {
            DB::rollback();
            
            return false;
        }

    }





    public function getDisplayStatusAttribute()
    {
    	switch ($this->status) {
    		case 'approved':
    			$status = '<span class="badge badge-success"> Approved</span>';
    			break;
    		
    		case 'declined':
    			$status = '<span class="badge badge-danger"> Declined</span>';
    			break;
    		
    		case 'pending':
    			$status = '<span class="badge badge-warning"> Pending</span>';
    			break;
    		
    		default:
    			$status = '<span class="badge badge-warning"> Pending</span>';
    			break;
    	}

    	return $status;
    }


    public function financial_bank()
    {
    	return $this->belongsTo('v2\Models\FinancialBank', 'bank_id');
    }



}


















?>