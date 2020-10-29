<?php

namespace v2\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use v2\Models\FinancialBank;
use \SiteSettings;

class UserWithdrawalMethod extends Eloquent 
{
	
	protected $fillable = [

		'user_id',	'method',	'details'
	];
	
	protected $table = 'users_withdrawals_methods';


	
	public  static $method_options = [
/*		'bitcoin'=> [
			'name' => 'Bitcoin',
			'class' => 'Bitcoin',
			'view' => 'withdrawal_methods/bitcoin',
			'display' => [
							'bitcoin_address'=> 'Bitcoin Address'
						],
		],

		'skrill'=> [
			'name' => 'Skrill',
			'class' => 'Skrill',
			'view' => 'withdrawal_methods/skrill',
			'display' => [

							'email_address'=> 'Email Address'
					],
		],

		'payeer'=> [
			'name' => 'Payeer',
			'class' => 'Payeer',
			'view' => 'withdrawal_methods/payeer',
			'display' => [

							'payeer_id'=> 'Payeer ID'
			],
		],
*/
		'local_bank'=> [
			'name' => 'Local Bank',
			'class' => 'LocalBank',
			'view' => 'withdrawal_methods/local_bank',
			'display' => [

						'bank_id'=> 'Bank ID',
						'account_number'=> 'Account Number',
			],
		],
	];




	public function getAccountHolderAttribute()
	{

		$settings = SiteSettings::find_criteria('paystack_keys')->settingsArray;


		if ($this->method != 'local_bank' ) {
			return"";
		}

		$details = $this->DetailsArray;

		$financial_bank = FinancialBank::find($details['bank_id']);

	    $params = http_build_query([
	        'account_number'=>  $details['account_number'],
	        'bank_code'=>   $financial_bank->code
	    ]); 

			    
		$secret_key = $settings['test']['secret_key'];

	    $url = "https://api.paystack.co/bank/resolve?$params";
	    $header = [
	        "Authorization: Bearer $secret_key"
	    ];
	    $response = \MIS::make_get($url, $header);

	    $response = json_decode($response, true);

	    $account_name = $response['data']['account_name'];
	    return $account_name;
	}


	public function getMethodDetailsAttribute()
	{
		$details = $this->DetailsArray;

		$settings = SiteSettings::find_criteria('paystack_keys')->settingsArray;


		switch ($this->method) {
			case 'local_bank':

				$financial_bank = FinancialBank::find($details['bank_id']);



		    $compact = [
			    	'bank' => $financial_bank->bank_name,
			    	'bank_code' => $financial_bank->code,
			    	'bank_id' => $financial_bank->id,
			    	'account_name' => $details['account_name'],
			    	'account_number' => $details['account_number'],
			    ];

			    $show = [
			    	'bank' => 'Bank',
			    	'account_name' => 'Account Holder',
			    	'account_number' => 'NUBAN',
			    ];

			    $line ='';
			    foreach ($show as $key => $label) {
			    	$value = $compact[$key];
			    	$line .= "<li>
			    				$label:
			    				$value
			    			</li>";
			    }


			    $compact['display'] = $line;


			    return ($compact);

				break;
			
			default:
				# code...
				break;
		}




	}



	public static function scopeForUser($query, $user_id)
	{
		return  $query->where('user_id', $user_id);
	}

	

	public static function for($user_id, $method)
	{
		$return  = self::where('user_id', $user_id)->where('method', $method)->first();

		return $return;
	}



	public function getDetailsArrayAttribute()
	{
		if ($this->details == null) {
			return [];
		}

		return json_decode($this->details, true);
	}




	
	public function user()
	{
		return $this->belongsTo('User', 'user_id');

	}



}
?>
