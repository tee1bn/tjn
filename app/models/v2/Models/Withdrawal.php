<?php


namespace v2\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Config, MIS;

use  Filters\Traits\Filterable;
use  v2\Models\AdminComment;


class Withdrawal extends Eloquent 
{

	use Filterable;
	
	protected $fillable = [
							'id',	
							'trans_id',	
							'broker_id',	
							'user_id',	
							'account_number',	
							'bank_account_id',	
							'amount',	
							'breakdown',	
							'amount_payable',	
							'status',	
							'admin_id'	
						];
	

	protected $table = 'user_withdrawals';
	public static $statuses = [
								1=> 'initialized',
								2 => 'pending',
								3=> 'confirmed',
								4=> 'completed',
								5=> 'declined'
							];




	public function trading_account()
	{
		return $this->belongsTo('v2\Models\TradingAccount', 'account_number', 'account_number');
	}


	public static function get_status($status)
	{
		$order = new self();
		$order->status = $status;

		return $order->DisplayStatus;
	}


	public function is_completed(){

		return (bool) ($this->status == 4);
	}




	public function encrypt_id()
	{
		return \MIS::dec_enc('encrypt', $this->id);
	}



	public function adminComments()
	{       
	     $comments =   AdminComment::where('model_id', $this->id)->where('model', 'withdrawal')->get();
	     return $comments;
	}



	public function user()
	{

		return $this->belongsTo('User', 'user_id');
	}



	public function broker()
	{
		return $this->belongsTo('v2\Models\Broker','broker_id');
	}



	public function bank()
	{

		return $this->belongsTo('v2\Models\UserBank', 'bank_account_id');
	}




	public function generateOrderID(){

		$substr = substr(strval(time()), 7 );
		$order_id = "9g{$this->id}W{$substr}";

		return $order_id;
	}


	public function setBreakdown()
	{
		$breakdown = $this->getBreakdown();

		$this->update([
			'breakdown' => json_encode($breakdown),
			'amount_payable' => $breakdown['amount_payable']['value']
		]);

		return $this;
	}



	public function service_fee()
	{
		$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;


		$service_fee_percent = $setting['withdrawal_service_charge_percent'];

		$subtotal =  $this->amount_in_naira()  ;
		$service_fee = $service_fee_percent * .01 * $subtotal;
		$service_fee = $service_fee + MIS::calculate_vat($service_fee)['value'];

		$result =[
			'value' => $service_fee,
			'percent' => $service_fee_percent,
		];

		return $result;
	}






	public function amount_in_naira()
	{
		$setting = \SiteSettings::find_criteria('site_settings')->settingsArray;

		$exchange = $setting['withdraw_at'];

		$amount = $this->amount;
		$amount_in_naira = $amount * $exchange;
		return $amount_in_naira;
	}


	public function getBreakdown()
	{
		$amount = $this->amount;
		$amount_in_naira = $this->amount_in_naira();
		$currency = Config::currency();
		$service_fee = $this->service_fee();

		$amount_payable = $amount_in_naira - $service_fee['value'];
		$breakdown = [
			'amount' => [
							'value'=> $amount,
							'name' => 'Amount($)',
							],


			'amount_in_naira' => [
							'value'=> $amount_in_naira,
							'name' => "Amount($currency)",
							],


			'service_fee' => [
							'value'=> $service_fee['value'],
							'name' => "Service Charge ($service_fee[percent]%)",
							],

		
			'subtotal_payable' => [
							'value'=> $subtotal_payable,
							'name' => 'Grand Total',
							],

			'gateway_fee' => [
							'value'=> $gateway_fee,
							'name' => ucfirst($gateway_name)." Fee",
							],

			'amount_payable' => [
							'value'=> $amount_payable,
							'name' => "Total Payable($currency)",
							],
							
		];
		return $breakdown;


	}

	public function fetchBreakdown()
	{
		

		$breakdown = $this->getBreakdown();
		$currency = Config::currency();
		$line= '';
		foreach ($breakdown as $key => $value) {
			if ($value['value'] == 0) {
				continue;
			}
			$amt =  MIS::money_format($value['value']);
			$size='';
			if ($value == end($breakdown)) {
				$size= 'font-size:20px;font-weight:700;';
			}

			$line .= "                                   
                                    <tr>
                                        <th style='padding: 5px;'>{$value['name']}</th>
                                        <td class='text-right' style='padding: 5px;$size'>$amt
                                         
                                        </td>  
                                    </tr>
					";

		}


		$breakdown['line'] =$line;

		return $breakdown;
			

	}



	public function getDisplayStatusAttribute()
	{

		switch ($this->status) {
			case 1:
				$status = '<span class="badge badge-dark"> initialized</span>';
				break;
			
			case 5:
				$status = '<span class="badge badge-danger"> Declined</span>';
				break;
			
			case 2:
				$status = '<span class="badge badge-warning"> Pending</span>';
				break;
			
			case 3:
				$status = '<span class="badge badge-info"> Confirmed</span>';
				break;
			
			case 4:
				$status = '<span class="badge badge-success"> Completed</span>';
				break;
			
			default:
				$status = '<span class="badge badge-warning"> Unknown</span>';
				break;
		}

		return $status;
	}





}


















?>