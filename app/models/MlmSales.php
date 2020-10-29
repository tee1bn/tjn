<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class MlmSales extends Eloquent 
{
	
		protected $fillable = [
						'downline_user_id',
						'transaction_amount',
						'status',
						'bonus_commissions',
						'base_commissions',
						'team_override_commission',
						];
	
	protected $table = 'mlm_sales_table';





public function attached_distributor()
{
	return $this->belongsTo('User', 'downline_user_id');
}




	/**
	 * [leader_users_shares fetches the leaders users shares based on ranks]
	 * @return [array] [with key => user_id and value=>due shares ]
	 */
	public static function leader_users_shares()
	{
//rank required for a user to be considered from db
		$min_rank_required 			 = ((json_decode(
										MlmSetting::where('rank_criteria', 'min_rank_required_for_leaderhip_bonus')
										->first()->settings, true) ));

		$leader_users = 	User::where('rank', '>=', $min_rank_required);
		// print_r($leader_users->get(['rank', 'id'])->toArray());

		foreach ($leader_users->get() as $leader) {
			 $rank_share = MlmSetting::fetch_leadership_pool_bonus($leader->rank)['rank_criteria']
			 															['pool_of_1_percent_NSV'];
			 $shares[$leader->id] = $rank_share;
				}		


		return $shares ;

	}


	

	public static function distribute_leadership_bonus_pool_shares($from, $to)
	{
	$one_share = MlmSales::worth_of_leadership_bonus_pool_share($from, $to);
	
		$leaders_shares =  MlmSales::leader_users_shares();

		// print_r($leaders_shares);

		$date  = date_create($from);
		$month =  date_format($date,"Y-m");

		// print_r($month);

		foreach ($leaders_shares as $user_id => $shares) {
			$amount_earned = $one_share * $shares ;

				try {
	$IncomeReport =	LevelIncomeReport::create([
							'owner_user_id' => $user_id,
							'from_user_id' 	=> $user_id,
							'upline_level' 	=>	0,
							'amount_earned' => $amount_earned,
							'availability' 	=> 1,
							'commission_type' => 'Leadership Bonus Pool ',
							'status' 		=> 'Credit',
							'leadership_bonus_month'=> $month
									]);

						} catch (Exception $e) {
							
						}

		}

	}


	/**
	 * [worth_of_leadership_bonus_pool_share calculates the worth of one share
	 * in the leadership bonus pool from the comapny pool of  net sales]
	 * @param  [type] $from [start date]
	 * @param  [type] $to   [end date]
	 * @return [type]       [float]
	 */
	public static function worth_of_leadership_bonus_pool_share($from, $to)
	{
		$total_leadership_bonus_pool = MlmSales::total_leadership_bonus_pool($from, $to);

		

		$shares =  MlmSales::leader_users_shares();


				$total_shares = array_sum($shares);
				$one_share = $total_leadership_bonus_pool / $total_shares;
		return $one_share;
	}






	public static function total_leadership_bonus_pool($from, $to)
	{
		// fetch_leadership_pool_bonus
$percent = ((json_decode(MlmSetting::where('rank_criteria', 'leadership_bonus_pool_percent_of_company_net_sale')
									->first()->settings, true) ));

$company_net_sales = MlmSales::company_net_sales($from, $to);

$total_pool = $percent * 0.01 * $company_net_sales ;
return $total_pool;

	}





	/**
	 * [company_net_sales calculates the company net sales after subtracting all commissions
	 * paid oon all sales within a time range]
	 * @param  [type] $from [start date]
	 * @param  [type] $to   [end date]
	 * @return [type]       [float]
	 */
	public static function company_net_sales($from , $to)
	{

		$sales = self::whereDate('created_at', '>=' , $from)
					 ->whereDate('created_at', '<=' , $to);
		foreach ($sales->get() as $sale) {
			 $total = $sale->transaction_amount;
			 $commission_paid = LevelIncomeReport::where('mlm_sale_id', $sale->id)->sum('amount_earned');
			 $company_net_sale[$sale->id] = $total - $commission_paid;
		}

		$total_company_net_sale =  array_sum($company_net_sale);

return ($total_company_net_sale);
	}




	public function no_of_qualified_frontline_representative($user_id, $from, $to)
	{
		return	count(self::qualified_frontline_representative($user_id, $from, $to));
	}


	/**
	 * [is_user_qualified check if user is quqlified i.e has sold the mini psv for the time range]
	 * @param  [type]  $user_id [description]
	 * @param  [type]  $from    [start date]
	 * @param  [type]  $to      [end date]
	 * @return boolean          []
	 */
	public static function is_user_qualified($user_id, $from, $to)
	{
	$sales_cut_off = json_decode( MlmSetting::where('rank_criteria', 'min_qualified_personal_sales')->first()->settings, true);


	$sales = self::personal_sales_over_time($user_id, $from, $to);

	if ($sales >= (int)$sales_cut_off) {
				return true;
			}


			return false;

	}


	public static function qualified_frontline_representative($user_id, $from, $to)
	{

	$sales_cut_off = MlmSetting::where('rank_criteria', 'min_qualified_personal_sales')->first()->settings;
	$user = User::find($user_id);
	$frontlines = $user->enroler_referred_members_downlines(1)[1]; //enrolment structure

		foreach ($frontlines as $index => $downline) {
			$leg = $index+1;
			$sales = self::personal_sales_over_time($downline['id'], $from, $to);

			if ($sales >= $sales_cut_off) {
				$downline['leg'] = $leg;
				$qualified_frontlines[] =  $downline;
			}
		}

		return ($qualified_frontlines);
	}

		

	public static  function personal_sales_over_time($user_id, $from , $to)
	{
		$sales = self::user_sales_over_time($user_id, $from , $to);
		return $sales->sum('transaction_amount');
	}



public function minimum_group_sales_of_legs($user_id, $from ,  $to, $sales_criteria=null )
{
	$user = User::find($user_id);
	$user_legs = $user->placement_legs();

		foreach ($user_legs as $leg_index => $user_ids) {
		$sales = MlmSales::group_sales_volumes($user_ids, $from ,  $to);
		$sales_volume[$leg_index] = $sales->sum('transaction_amount');
		}

		return ($sales_volume);


}


	public static  function group_sales_volumes(array $group_ids, $from , $to)
	{

	$sales = self::whereIn('downline_user_id', $group_ids)
			->whereDate('created_at', '>=' , $from)
			->whereDate('created_at', '<=' , $to);

	return ( $sales);


	}



	public static  function sales_over_time( $from , $to)
	{
	$sales = self::whereDate('created_at', '>=' , $from)
			->whereDate('created_at', '<=' , $to);

		return $sales;
	}



	public static  function user_sales_over_time($user_id, $from , $to)
	{
	$sales = self::where('downline_user_id', $user_id)
			->whereDate('created_at', '>=' , $from)
			->whereDate('created_at', '<=' , $to);

		return $sales;
	}



	public function get_base_commissions($subtotal, $base_commissions)
	{

	foreach ($base_commissions->commissions as $commission) {
			if (($commission->lower_limit <= $subtotal) 
				&& ($commission->higher_limit >= $subtotal)) {
				
				$appropriate_commission = $commission;
				break;
			}

		}
	return ($appropriate_commission);
	}




	public function get_bonus_commissions($subtotal, $bonus_commissions)
	{

	foreach ($bonus_commissions->commissions as $commission) {
			if (($commission->lower_limit <= $subtotal) 
				&& ($commission->higher_limit >= $subtotal)) {
				
				$appropriate_commission = $commission;
				break;
			}

		}
	return ($appropriate_commission);
	}



	public function distribute_team_override_commission($from , $to)
	{
		$user  			= $this->user;
		$levels_net = [];
		
		$levels_paid = 1;
		$upline_level = 1;
		do{
			$upline = $user->referred_members_uplines($upline_level)[$upline_level];
			$upline_rank = (int) $upline['rank'];
			// $commission  = MlmSetting::fetch_team_override_commission($upline_rank)['rank_criteria'][$upline_level];


				$ranks_indices =  json_decode(MlmSetting::where('rank_criteria', 'rank_interpreter')->first()->settings, true) ;
				$rank = ($ranks_indices[$upline_rank]);
				// print_r($rank);
				$ranks_criteria =  json_decode($this->team_override_commission, true) ;
				$broad_division = $ranks_criteria[$rank['main_rank']];


				// print_r($broad_division);
				$readable_rank = [
							'class_rank' 	=> $broad_division['rank'] ,
							'main_rank' 	=> $broad_division['sub_ranks'][$rank['sub_rank']]['rank'] ,
							'rank_criteria' => $broad_division['sub_ranks'][$rank['sub_rank']]['criteria'] ,
							];

			
			$commission =  $readable_rank['rank_criteria'][$upline_level];




				//consider compression
				$user_is_qualified = MlmSales::is_user_qualified($upline['id'], $from , $to);
				if ($user_is_qualified) {
					// echo $upline['id']." qualified at upline_level $upline_level<br>";
					// print_r($upline);
					$dynamic_compression = '';
				}else{
					// echo $upline['id']." not qualified upline_level $upline_level<br>";
					$upline_level++;
					$dynamic_compression = ' Dynamic Compression';
					continue;
				}

		

		//get bonus commission
		$bonus_commission 	=	$this->get_bonus_commissions($this->transaction_amount,  $this->bonus_commissions);
	 	$bonus_amount_earned= $bonus_commission->bonus_commission * 0.01 * $this->transaction_amount;

		//get base commission
 		$base_commission 	=	$this->get_base_commissions($this->transaction_amount,  $this->base_commissions);
	 	$base_amount_earned = $base_commission->base_commission * 0.01 * $this->transaction_amount;

	 	//do the net substractions
		$net_total = $this->transaction_amount - $base_amount_earned - $bonus_amount_earned - (array_sum($levels_net));	 


		$current_override_commission_earned = $commission * 0.01 * $net_total;

		$levels_net[$upline_level] = $current_override_commission_earned ;
							
			
				try {

	$IncomeReport =	LevelIncomeReport::create([
							'owner_user_id' => $upline['id'],
							'from_user_id' 	=> $this->user->id,
							'mlm_sale_id' 	=> $this->id,
							'upline_level' 	=>	$upline_level.$dynamic_compression,
							'amount_earned' => $current_override_commission_earned,
							'availability' 	=> 1,
							'commission_type' => 'Team Override Commission '.$dynamic_compression,
							'status' 		=> 'Credit',
							'sale_total' 	=> $net_total,
							'commission' 	=> $commission
									]);

	 	} catch (Exception $e) {
	 		
	 	}



			$levels_paid++;
			$upline_level++;
		}while(
				($levels_paid <= 4) &&
				($upline != '')
			);

	}



	public function distribute_bonus_commission()
	{
		$user  		= $this->user;
	 	$commission =	$this->get_bonus_commissions($this->transaction_amount,  $this->bonus_commissions);
	 	$amount_earned 	= $commission->bonus_commission * 0.01 * $this->transaction_amount;

	 	try {

		LevelIncomeReport::create([
							'owner_user_id' => $this->downline_user_id,
							'from_user_id' 	=> $this->downline_user_id,
							'mlm_sale_id' 	=> $this->id,
							'upline_level' 	=> 0,
							'amount_earned' => $amount_earned,
							'availability' 	=> 1,
							'commission_type' => 'Bonus Commission',
							'status' 		=> 'Credit',
							'sale_total' 	=> $this->transaction_amount,
							'commission' 	=> $commission->bonus_commission
									]);


	 	} catch (Exception $e) {
	 		
	 	}



	}

	public function distribute_base_commission()
	{
		$user  		= $this->user;

	 	$commission 	=	$this->get_base_commissions($this->transaction_amount,  $this->base_commissions);
	 	$amount_earned 	= $commission->base_commission * 0.01 * $this->transaction_amount;

	 	try {

		LevelIncomeReport::create([
							'owner_user_id' => $this->downline_user_id,
							'from_user_id' 	=> $this->downline_user_id,
							'mlm_sale_id' 	=> $this->id,
							'upline_level' 	=> 0,
							'amount_earned' => $amount_earned,
							'availability' 	=> 1,
							'commission_type' => 'Base Commission',
							'status' 		=> 'Credit',
							'sale_total' 	=> $this->transaction_amount,
							'commission' 	=> $commission->base_commission
									]);


	 	} catch (Exception $e) {
	 		
	 	}



	}






	public function distribute_commissions()
	{
		$user  = $this->user;
		$rank_commissions = $this->rank_commissions->commission;
		$uplines = $user->referred_members_uplines(4); //4 is the depth level consideration

		foreach ($rank_commissions as $upline_level => $commission) { //in percentage

			$amount_earned = 0.01 * $commission * $this->transaction_amount; 
			LevelIncomeReport::create([
							'owner_user_id' => $uplines[$upline_level]['id'],
							'from_user_id' 	=> $this->downline_user_id,
							'mlm_sale_id' 	=> $this->id,
							'upline_level' 	=> $upline_level,
							'amount_earned' => $amount_earned,
							'availability' 	=> 1,
							'status' 		=> 'Credit',
							'sale_total' 	=> $this->transaction_amount,
							'commission' 	=> $commission
									]);
		}

		$this->update(['status' => 1]);

	}	




public static function non_distributed_commissions()
	{
		return self::where('status', 0);

	}	



public function user()
{
	return	$this->belongsTo('User', 'downline_user_id');	
}



public function distributed_commissions()
{
	return	$this->hasMany('LevelIncomeReport', 'mlm_sale_id');	
}

public function getbasecommissionsAttribute($value='')
{	
	return 	( json_decode($value) );
}


public function getbonuscommissionsAttribute($value='')
{	
	return 	( json_decode($value) );
}



public function getpropertydetailsAttribute($value='')
{	return 	(json_decode($value));
}





}


















?>