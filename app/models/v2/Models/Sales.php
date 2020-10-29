<?php
namespace v2\Models;

include_once 'app/controllers/home.php';
use v2\Models\Wallet;
use v2\Models\Commission;
use v2\Models\HotWallet;
use v2\Models\HeldCoin;
use v2\Models\PayoutWallet;
use  Filters\Traits\Filterable;

use Illuminate\Database\Capsule\Manager as DB;

use SiteSettings;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Sales extends Eloquent 
{
	use Filterable;
	
	protected $fillable = [
							'user_id',
							'buyer_id',
							'username',
							'amount',
							'currency', //used currency 
							'type',
							'level',
							'points',
							'detail',
							'commission_settled',
							'comment',
							'created_at',
							'updated_at',
							'item_id',
							'priced_amount',
							'priced_currency',
							'is_paid',
							'order_id'
						];
								
	protected $table = 'sales';


	public function scopePaid($query)
	{
		return $query->where('is_paid', 1);
	}


	public function scopeUnPaid($query)
	{
		return $query->where('is_paid', 0);
	}


	public function update_amount_with_conversion($currency_setting=null)
	{	

		if (($this->amount != null) || ($this->commission_settled==1)) {
			return ;
		}


		$currency_setting = $currency_setting ?? SiteSettings::find_criteria('currency_pricing')->settingsArray;

		// priced currency/ used currency --exchange


		$exchange = $currency_setting['pricedcurrency_usedcurrency'];
		$priced_currency = $currency_setting['priced_currency'];
		$priced_amount = $this->priced_amount;

		$currency = $currency_setting['used_currency'];
		$amount = $priced_amount * $exchange;

		$this->update([
						'amount' => $amount,
						'priced_amount' => $priced_amount,
						'priced_currency' => $priced_currency,
						'currency' => $currency,
					]);

	}


	public function give_referral_commissions()
	{


				$today = date("Y-m-d H:i:s");
				$sale = $this->amount;


				$setting = SiteSettings::all()->keyBy('criteria');

				$buyer = $this->buyer;

				$uplines = collect($this->user->referred_members_uplines(10 ,'enrolment'));
				
				$pay_date = $today;


				$ranks_and_gen = collect($setting['rank_and_generation']->settingsArray['ranks'])->toArray();

				// print_r($ranks_and_gen);

				// print_r($uplines->toArray());
				//direct bonus
				$matrix_plan_table_1 = $setting['matrix_plan_table_1']->settingsArray['table'];

				// print_r($matrix_plan_table_1);



				$expected_count = count($matrix_plan_table_1);
				$actual_count = 0;

				foreach ($matrix_plan_table_1 as $level => $bonus) {
					
					$actual_count ++;	



					if (! isset($uplines[$level])) {continue;}

					$receiver = $uplines[$level];


					//ensure receiver is qualified for compensational bonuses on this sale
					if (! $receiver->can_received_compensation($this)) {continue;}


					//ensure user is in rank that can recive this depth commission
					$highest_depth_for_receiver = $ranks_and_gen[$receiver->rank]['generation'] ?? null;
					if (($highest_depth_for_receiver==null) || ($level > $highest_depth_for_receiver)) {continue;}


					$percent = $bonus['commission'];


					if ($percent == 0) {continue;}


					$extra_detail = json_encode([
						'reason' => 'basic_bonus'
					]);


					$commission_earned = $percent * 0.01 * $sale;



					//check for max payout
					//CHECK LIMIT OF BINARYGAIN 
					//already paid binary gain today
					$today  = date("Y-m-d");

					$paid_commissions = Commission::where('user_id', $receiver->id)->Completed()->Paid()->sum('amount');

						$max_payout = $ranks_and_gen[$receiver->rank]['max_payout'];

					    $possible_new_value = $paid_commissions + $commission_earned;

					    if ($possible_new_value > $max_payout) {


					    $offset =  $max_payout - $paid_commissions;

					    $commission_earned = $offset;

					    }else{

					    }




					   if ($commission_earned <= 0) {
					   		continue;
					   }

					$identifier="C#S$this->id#B$buyer->id#L$level#R$receiver[id]";


					DB::beginTransaction();


					try {
						
						//credit Direct Bonus
						$comment = "$percent% of $sale as  Level $level Basic Bonus";
						$basic_bonus =Commission::createTransaction(
							'credit',
							$receiver['id'],
							$buyer['id'],
							$commission_earned,
							'completed',
							'basic_bonus',
							$comment,
							$identifier, 
							$this->id, 
							null,
							$extra_detail,
							$pay_date
						);

						$this->mark_as_settled();
                            
                         

						DB::commit();
					} catch (Exception $e) {
						DB::rollback();
						print_r($e->getMessage());
					}
				}	


				if ($actual_count >= $expected_count) {
					$this->mark_as_settled();
				}


			

	}


	public function getPaymentStatusAttribute()
	{

		switch ($this->is_paid) {
			case 1:
			return "<span class='badge badge-sm badge-success'>Paid</span>";
			break;

			default:
			return "<span class='badge badge-sm badge-warning'>Pending</span>";
			break;            
		}

	}

	public function getdisplayedStatusAttribute()
	{

		switch ($this->commission_settled) {
			case 1:
			return "<span class='badge badge-sm badge-success'>Settled</span>";
			break;

			default:
			return "<span class='badge badge-sm badge-warning'>Pending</span>";
			break;            
		}

	}

	public function mark_as_settled()
	{
		return $this->update(['commission_settled' => 1]);

	}


	public function set_point()
	{


		$settings = SiteSettings::all()->keyBy('criteria');


		$points_value = $settings['points_value']->settingsArray;
		$course_point_value = collect($points_value['courses'])->keyBy('level');


		$points = $course_point_value[$this->level]['points'];
		if ($points == 0) {return;}

		$this->update([
		    'points'=>$points
		]);


	}
	
	//the referral
	public function user()
	{
		return $this->belongsTo('User', 'user_id');

	}
		
	//the buyer
	public function buyer()
	{
		return $this->belongsTo('User', 'buyer_id');

	}
	





}
?>
