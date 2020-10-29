<?php


use Illuminate\Database\Eloquent\Model as Eloquent;

class MlmSetting extends Eloquent 
{
	
	protected $fillable = [
							'rank_criteria',
							'settings'
							];
	
	protected $table = 'ranks_criteria';



	public static function registration_fee()
	{
		return self::compensation_breakdown()[1]['join_fee'];

	}



	public static function compensation_breakdown()
	{
		$settings = json_decode(self::where('rank_criteria', 'compensation_breakdown')->first()->settings, true);
		return $settings;

	}




	public static function company_account_details()
	{
		$settings = json_decode(self::where('rank_criteria', 'admin_bank_details')->first()->settings, true);
		return $settings;

	}




	public static function distribute_executive_leader_bonus($user_id, $new_rank)
	{
		$user = User::find($user_id);
	
		//ensure it is a newly achieved rank
		if ( !($user->life_rank() < $new_rank)) {
			return;	
			}



		$commission = (self::fetch_executive_leader_bonus($new_rank));
		$amount_earned = $commission['criteria']['MCBFAR'];

		print_r($commission);
		print_r($amount_earned);




	//give perrsonal advancement bonus
	try {
	$PRAB =	LevelIncomeReport::create([
							'owner_user_id' => $user_id,
							'from_user_id' 	=> $user_id,
							'upline_level' 	=>	0,
							'amount_earned' => $amount_earned,
							'availability' 	=> 1,
							'commission_type' => 'Executive Leader Bonus',
							'rank_achieved' => $new_rank,
							'status' 		=> 'Credit',
							'executive_leader_bonus_rank' => $new_rank 

									]);

	 	} catch (Exception $e) {
	 		
	 	}








	}
	public static function distribute_rank_advancement_bonus($user_id, $new_rank)
	{
	
		
		$user = User::find($user_id);


		//ensure it is a newly achieved rank
		if ( !($user->life_rank() < $new_rank)) {
			return;	
			}




		$upline = $user->enroler_referred_members_uplines(1)[1];
		$commission = (self::fetch_rank_advancement_commission($new_rank));



	try {
	$PRAB =	LevelIncomeReport::create([
							'owner_user_id' => $user_id,
							'from_user_id' 	=> $user_id,
							'upline_level' 	=>	0,
							'amount_earned' => $commission['criteria']['PRAB'],
							'availability' 	=> 1,
							'commission_type' => 'Personal Rank Advancement Bonus',
							'rank_achieved' => $new_rank,
							'status' 		=> 'Credit',
									]);

	 	} catch (Exception $e) {
	 		
	 	}

//give upline matching advancement bonus

	if ($upline['rank'] >= $new_rank ) {

		try {
			$MRAB =	LevelIncomeReport::create([
									'owner_user_id' => $upline['id'],
									'from_user_id' 	=> $user_id,
									'upline_level' 	=>	1,  
									'amount_earned' => $commission['criteria']['MRAB'],
									'availability' 	=> 1,
									'commission_type' => 'Matching Rank Advancement Bonus',
									'rank_achieved' => $new_rank,
									'status' 		=> 'Credit',
											]);

			 	} catch (Exception $e) {
			 		
			 	}

			 }
			}


	public static function  no_of_qualified_leadership_legs($user_id) //enrolment structure
	{		
			$MOQLLES = json_decode( MlmSetting::where('rank_criteria', 'MOQLLES')->first()->settings); //from db


			$min_rank = $MOQLLES->min_rank ; // default i.e Leader in leaders rank
			$min_no_of_min_rank = $MOQLLES->min_no_of_min_rank;
			$user  = User::find($user_id);
			$user_legs =	$user->enroler_legs();

			// print_r($user_legs);
			$qualified_reps=[];
			foreach ($user_legs as $leg => $user_ids) {
				foreach ($user_ids as $user_id) {
				$_user = User::find($user_id);
					if ($_user->rank >= $min_rank) {  //check for atleast min_rank
						$qualified_reps[$leg] += 1;
					}

				}

			}

			$no_of_qualified_leadership_legs = 0 ;
			foreach ($qualified_reps as $leg_index => $no_qualified_reps) {
				if ($no_qualified_reps >= $min_no_of_min_rank) { //check for atleast min_no_of_min_rank
					$no_of_qualified_leadership_legs += 1;
				}
			}

// print_r($qualified_reps);
return($no_of_qualified_leadership_legs);
	}


	/**
	 * [get_user_rank calculates a users rank over time range]
	 * @param  [type] $user_id [user id]
	 * @param  [type] $from    [start date]
	 * @param  [type] $to      [end date]
	 * @return [type]          [description]
	 */
	public function get_user_rank($user_id, $from ,  $to)
	{
			$user 						= User::find($user_id);
			//40percent may come from personal orders ##not implement
			$min_personal_sales_volume 	= MlmSales::personal_sales_over_time($user_id, $from ,  $to);
			$no_of_qualified_reps 		= MlmSales::no_of_qualified_frontline_representative($user_id, $from , $to);
			$MOQLLES 					= self::no_of_qualified_leadership_legs($user_id) ;
			$min_group_sales_volume 	= self::minimum_group_sales($user_id, $from ,  $to);
/*
			echo $min_personal_sales_volume." min_personal_sales_volume<br>";
			echo $min_group_sales_volume." min_group_sales_volume<br>";
			echo $no_of_qualified_reps." no_of_qualified_reps<br>";
			echo $MOQLLES."no_of_qualified_leadership_legs<br><br><br>";*/

return MlmSetting::determine_rank($user_id, $min_personal_sales_volume, $min_group_sales_volume, $no_of_qualified_reps, $MOQLLES );

// MlmSetting::determine_rank($user_id, 390, 150000, 8, 4 );
// determine_rank
	}

	/**
	 * [is_leadership_leg checks whether a leg is a leadership leg or not]
	 * @param  [type]  $user_id   [user id in question]
	 * @param  [type]  $leg_index [leg index]
	 * @return boolean            [true if yes and false is no]
	 */
	public static function is_leadership_leg($user_id, $leg_index)
	{	
	$is_leadership_leg_criteria = json_decode(MlmSetting::where('rank_criteria', 'is_leadership_leg')
														->first()->settings, true) ;
		$min_rank_criteria = $is_leadership_leg_criteria['min_rank_criteria'];
		$leg_rank_summary  = self::legs_rank($user_id);
		$leg_in_question = $leg_rank_summary[$leg_index];

			foreach ($leg_in_question as $rank => $frequency) {
				if ($rank >= $min_rank_criteria) {
					return true ;
				}
			}
	return false;
	}


public function maximum_legs_ranks($user_id)
{
			$leg_rank_summary = self::legs_rank($user_id);
			foreach ($leg_rank_summary as $key => $value) {

				$maximum_legs_ranks[$key] =max(array_keys($value));
			}
		return ($maximum_legs_ranks);
}



/**
 * [legs_rank returns on each legs the numbers of various ranks present]
 * @param  [type] $user_id [the user id in question]
 * @return [type]          [array with keys as leg index and array 
 * values(keys =>ranks and values=>frequency of the ranks) ]
 */
public static function legs_rank($user_id)
{
$user = User::find($user_id);
		$enroler_legs = $user->enroler_legs();
		foreach ($enroler_legs as $leg_index => $user_ids) {
				foreach ($user_ids as $user_id) {
				$_user = User::find($user_id);
					$user_rank = (int)$_user->rank;
					$leg_rank_summary[$leg_index][$user_rank] += 1;

				}

		}

return $leg_rank_summary;
}



public function check_for_advanced_rank($user_id, $rank_index)
{
				$criteria = MlmSetting::fetch_rank($rank_index);        
				$LLRES = $criteria['criteria']['LLRES'];
				krsort($LLRES);		//to start checks from highest rank in criteria

		$user = User::find($user_id);
		$leg_rank_summary = self::legs_rank($user_id);
		$maximum_legs_ranks = self::maximum_legs_ranks($user_id);
		$directly_enrolled_user = $user->enroler_referred_members_downlines(1)[1];

// print_r($maximum_legs_ranks);
			foreach ($LLRES as $rank_index => $criteria) {
					if ($criteria != 0) { //whether criteria is given at all, if so, check
						
						foreach ($maximum_legs_ranks as $leg_index => $max_rank) {
							// echo "$rank_index maxrank $max_rank ";
								if($max_rank >= $rank_index){
									unset($maximum_legs_ranks[$leg_index]); //remove leg from further checks
									$checks[$leg_index] = $rank_index;
									break;					//stop checking for this criteria since it is met here
								}else{

								}

					}

				}
			}


			foreach ($LLRES as $rank_index => $criteria) {
					if ($criteria != 0) {
						if (! in_array($rank_index, $checks)) {
							$final_check =  false;
							break;
						}
					}

					$final_check =  true;
				}

/*
print_r($LLRES);
print_r($checks);
print_r($leg_rank_summary);
*/

return ($final_check);

}


public static  function determine_rank(
										$user_id,
										$min_personal_sales_volume,
										$min_group_sales_volume,
										$no_of_qualified_reps,
										$MOQLLES )
{
	$ranks_indices 	= json_decode(MlmSetting::where('rank_criteria', 'rank_interpreter')->first()->settings, true) ;
		 $determined_rank = 0  ;

		
		// print_r(func_get_args());

		foreach ($ranks_indices as $rank_index => $rank_indices) {
			$rank = MlmSetting::fetch_rank($rank_index);
			  // monthly min personal sales volume criteria
			$MPSV = $rank['criteria']['MPSV'];

            // monthly	Minimum Group Sales Volume criteria
            $MMGSV = $rank['criteria']['MMGSV']; 

            // Minimum # of Qualified Frontline Representatives (Enrollment Structure) criteria 
            $MMNQPES = $rank['criteria']['MMNQPES'];

            //Minimum # of qualified Leadership Legs in Enrollment Structure criteria
            $MQLLES = $rank['criteria']['MQLLES'];

            //	Leadership Leg Requirements in the Enrollment Structure 
            $LLRES = $rank['criteria']['LLRES'];

            /*advanced rank*/

            $MPSV_condition 	=  ($min_personal_sales_volume >= $MPSV );
            $MMGSV_condition 	=  ($min_group_sales_volume >= $MMGSV );
            $MMNQPES_condition 	=  ($no_of_qualified_reps >= $MMNQPES );
            $MQLLES_condition 	=  ($MOQLLES >= $MQLLES );
          	$llres_condition =  MlmSetting::check_for_advanced_rank($user_id, $rank_index);
          	// echo "advancement $llres_condition";

      	if (
      		$MPSV_condition 	&& 
      		$MMGSV_condition 	&& 
      		$MMNQPES_condition 	&& 
      		$MQLLES_condition	&&
      		$llres_condition
      		) {

      		$determined_rank = $rank_index;
      	}


				// print_r($rank);

		}


				// print_r($determined_rank);
				// print_r(MlmSetting::fetch_rank($determined_rank));
				
			return $determined_rank ;


}



/**
 * [minimum_group_sales used for generational bonuses]
 * @param  [int] $user_id 
 * @param  [date string] $from    [description]
 * @param  [date string] $to      [description]
 * @return [int]          [description]
 */
public function minimum_group_sales_generational_bonuses($user_id, $from ,  $to )
{
		//from db
		$gsv_percent 	= json_decode(MlmSetting::where('rank_criteria', 'gsv_rule')->first()->settings, true) ;

		$raw_gsv 			= MlmSales::minimum_group_sales_of_legs($user_id, $from ,  $to);
		$personal_sales = MlmSales::personal_sales_over_time($user_id, $from ,  $to);

		//not counting for leadership leg
		foreach ($raw_gsv as $leg_index => $value) {
				if ((MlmSetting::is_leadership_leg($user_id, $leg_index  ))) {
					unset($raw_gsv[$leg_index]);					
				}
			}



		$max_gsv 		= $gsv_percent * 0.01 *  (array_sum($raw_gsv));

		// print_r($raw_gsv);

			//apply gsv rule
			$gsv_rule_applied_gsv = $raw_gsv; 
			

			foreach ($raw_gsv as $leg_index => $value) {

				

					if ($value >= $max_gsv) { //apply gsv rule
						$gsv_rule_applied_gsv[$leg_index] = $max_gsv;
					}
			}

			$min_group_sales_volume = array_sum($gsv_rule_applied_gsv) + $personal_sales;
		


		return ($min_group_sales_volume);


}


public function minimum_group_sales($user_id, $from ,  $to )
{
		//from db
		$gsv_percent 	= json_decode(MlmSetting::where('rank_criteria', 'gsv_rule')->first()->settings, true) ;

		$raw_gsv 			= MlmSales::minimum_group_sales_of_legs($user_id, $from ,  $to);
		$personal_sales = MlmSales::personal_sales_over_time($user_id, $from ,  $to);
		$max_gsv 		= $gsv_percent * 0.01 *  (array_sum($raw_gsv));

		// print_r($raw_gsv);

			//apply gsv rule
			$gsv_rule_applied_gsv = $raw_gsv; 
			foreach ($raw_gsv as $leg_index => $value) {
					if ($value >= $max_gsv) { //apply gsv rule
						$gsv_rule_applied_gsv[$leg_index] = $max_gsv;
					}
			}

			$min_group_sales_volume = array_sum($gsv_rule_applied_gsv) + $personal_sales;
		


		return ($min_group_sales_volume);


}


public function fetch_next_rank($rank_number)
{
	$rank_number++;
	if ($rank_number > 9) {
		$rank_number = 9;
	}
 $ranks_indices =  json_decode(self::where('rank_criteria', 'rank_interpreter')->first()->settings, true) ;
$rank = ($ranks_indices[$rank_number]);


 $rank_criteria =  json_decode(self::where('rank_criteria', 'major_rank_qualification')->first()->settings, true) ;
 $broad_division = $rank_criteria[$rank['main_rank']];


// print_r($broad_division);
$readable_rank = [
				'class_rank' 	=> $broad_division['rank'] ,
				'main_rank' 	=> $broad_division['sub_ranks'][$rank['sub_rank']]['rank'] ,
				'criteria' => $broad_division['sub_ranks'][$rank['sub_rank']]['criteria'] ,
				];


return ($readable_rank);

}

public function fetch_rank_advancement_commission($rank_number)
{
 $ranks_indices =  json_decode(self::where('rank_criteria', 'rank_interpreter')->first()->settings, true) ;
$rank = ($ranks_indices[$rank_number]);
// print_r($rank);
 $rank_criteria =  json_decode(self::where('rank_criteria', 'rank_advancement_bonus')->first()->settings, true) ;
 $broad_division = $rank_criteria[$rank['main_rank']];


// print_r($broad_division);
$readable_rank = [
				'class_rank' 	=> $broad_division['rank'] ,
				'main_rank' 	=> $broad_division['sub_ranks'][$rank['sub_rank']]['rank'] ,
				'criteria' => $broad_division['sub_ranks'][$rank['sub_rank']]['criteria'] ,
				];


return ($readable_rank);

}

public function fetch_rank_generational_bonus($rank_number)
{
 $ranks_indices =  json_decode(self::where('rank_criteria', 'rank_interpreter')->first()->settings, true) ;
$rank = ($ranks_indices[$rank_number]);
// print_r($rank);
 $rank_criteria =  json_decode(self::where('rank_criteria', 'generational_bonus')->first()->settings, true) ;
 $broad_division = $rank_criteria[$rank['main_rank']];


// print_r($broad_division);
$readable_rank = [
				'class_rank' 	=> $broad_division['rank'] ,
				'main_rank' 	=> $broad_division['sub_ranks'][$rank['sub_rank']]['rank'] ,
				'criteria' => $broad_division['sub_ranks'][$rank['sub_rank']]['criteria'] ,
				];


return ($readable_rank);

}


public function fetch_leadership_pool_bonus($rank_number)
{
 $ranks_indices =  json_decode(self::where('rank_criteria', 'rank_interpreter')->first()->settings, true) ;
$rank = ($ranks_indices[$rank_number]);
// print_r($rank);
 $rank_criteria =  json_decode(self::where('rank_criteria', 'leadership_bonus_pool')->first()->settings, true) ;
 $broad_division = $rank_criteria[$rank['main_rank']];


// print_r($broad_division);
$readable_rank = [
				'class_rank' 	=> $broad_division['rank'] ,
				'main_rank' 	=> $broad_division['sub_ranks'][$rank['sub_rank']]['rank'] ,
				'criteria' => $broad_division['sub_ranks'][$rank['sub_rank']]['criteria'] ,
				];


return ($readable_rank);

}


public function fetch_rank($rank_number)
{
 $ranks_indices =  json_decode(self::where('rank_criteria', 'rank_interpreter')->first()->settings, true) ;
$rank = ($ranks_indices[$rank_number]);
// print_r($rank);
 $rank_criteria =  json_decode(self::where('rank_criteria', 'major_rank_qualification')->first()->settings, true) ;
 $broad_division = $rank_criteria[$rank['main_rank']];


// print_r($broad_division);
$readable_rank = [
				'class_rank' 	=> $broad_division['rank'] ,
				'main_rank' 	=> $broad_division['sub_ranks'][$rank['sub_rank']]['rank'] ,
				'criteria' => $broad_division['sub_ranks'][$rank['sub_rank']]['criteria'] ,
				];


return ($readable_rank);

}


public function fetch_executive_leader_bonus($rank_number)
{
 $ranks_indices =  json_decode(self::where('rank_criteria', 'rank_interpreter')->first()->settings, true) ;
$rank = ($ranks_indices[$rank_number]);
// print_r($rank);
 $rank_criteria =  json_decode(self::where('rank_criteria', 'executive_leader_bonus')->first()->settings, true) ;
 $broad_division = $rank_criteria[$rank['main_rank']];


// print_r($broad_division);
$readable_rank = [
				'class_rank' 	=> $broad_division['rank'] ,
				'main_rank' 	=> $broad_division['sub_ranks'][$rank['sub_rank']]['rank'] ,
				'criteria' => $broad_division['sub_ranks'][$rank['sub_rank']]['criteria'] ,
				];


return ($readable_rank);

}




public function fetch_team_override_commission($rank_number)
{
 $ranks_indices =  json_decode(self::where('rank_criteria', 'rank_interpreter')->first()->settings, true) ;
$rank = ($ranks_indices[$rank_number]);
// print_r($rank);
 $rank_criteria =  json_decode(self::where('rank_criteria', 'team_override_commission')->first()->settings, true) ;
 $broad_division = $rank_criteria[$rank['main_rank']];


// print_r($broad_division);
$readable_rank = [
				'class_rank' 	=> $broad_division['rank'] ,
				'main_rank' 	=> $broad_division['sub_ranks'][$rank['sub_rank']]['rank'] ,
				'criteria' => $broad_division['sub_ranks'][$rank['sub_rank']]['criteria'] ,
				];


return ($readable_rank);

}







public function getsettingsAttribute($value)
    {
        return json_encode( json_decode($value ,true));
    }












}


















?>