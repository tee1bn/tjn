<?php


use Illuminate\Database\Eloquent\Model as Eloquent;
use  v2\Models\HotWallet;
use  v2\Models\Commission;
use  v2\Models\Sales;
use Illuminate\Database\Capsule\Manager as DB;

class Rank 
{
	

	private $user;
	private $all_ranks;
	private $rank_qualifications;

	private $rank = -1;


	public function __construct()
	{

		$rank_setting = SiteSettings::find_criteria('leadership_ranks')->settingsArray;
		// print_r($rank_setting);

		$this->all_ranks = $rank_setting['all_ranks'];
		$this->rank_qualifications = $rank_setting['rank_qualifications'];
		krsort($this->rank_qualifications);

		echo "<pre>";
		// print_r($this->rank_qualifications);

	}


	public function setUser($user)
	{
		 $this->user = $user;
		return $this;
	}


	public function __get($property)
	{
		return $this->$property;
	}


	public function setUserRank()
	{
		echo $this->rank;

		if (($this->rank == -1) ||($this->rank === null)) {
			return;
		}


		if ($this->rank <= $this->user->rank) {
			return;
		}



		$rank = $this->all_ranks[$this->rank];
		$cash_rewards = $this->rank_qualifications[$this->rank]['cash_rewards'];
		$amount = $cash_rewards['amount'];

		if (isset($cash_rewards['perks'])) {

			$perks =  implode(",", $cash_rewards['perks']);
		}else{
			$perks = "Nil";
		}

		$comment = "Cash Reward $amount for reaching {$rank['name']} and perks: $perks";


		$extra_detail = json_encode([
			'reason' => 'rank'
		]);


		$today = date("Y-m-d H:i:s");


		$pay_date = date("Y-m-t");


		$identifier = "rank{$this->rank}";
		DB::beginTransaction();

		try {

			$rank_history = $this->user->RankHistoryArray;

			$rank_history[$today] = $this->rank;
			
			$update = $this->user->update([
						'rank'=> $this->rank,
						'rank_history'=> json_encode($rank_history),
					]);

			/*	
			$leadership_bonus =	Commission::createTransaction(
									'credit',
									$this->user->id,
									null,
									$amount,
									'completed',
									'rank',
									$comment,
									$identifier, 
									null, 
									null,
									$extra_detail,
									$pay_date
								);*/
			DB::commit();
		} catch (Exception $e) {
			DB::rollback();
			// print_r($e->getMessage());
		}

	}


	public  function determineRank()
	{
		$possible_ranks = [];

		$allowed=['rating', 'points_volume'];

		foreach ($this->rank_qualifications as $rank => $requirements) {

			foreach ($requirements as $requirement => $detail) {

				if((method_exists($this, $requirement)) && (in_array($requirement, $allowed))){

					$response = $this->$requirement($detail, $rank);
					if ($response===false) {
						// echo "$requirement for $rank <br>";
						$possible_ranks[$rank][] = 0;
						continue 2;

					}else{
						
						$possible_ranks[$rank][] = 1;
					}
				}

			}


		}


		// print_r($possible_ranks);

		foreach ($possible_ranks as $rank => $value) {
			if (array_sum($value) == count($allowed)) {
				$this->rank = $rank;
				break;
			}
		}

		return  $this;
	}




	public function rating($detail, $currently_checked_rank)
	{
		//activities
		$activities = $detail['activity'];


		// print_r($activities);
		foreach ($activities as $key => $activity) {
			$action = $activity['action'];
			$count = $activity['count'];


			if (($action == '') || ($count == '')) {
				continue;
			}

			switch ($action) {

				case 'buy_x_course_in_level':

						$course_level = $currently_checked_rank + 1;
						$sales_count = Sales::where('buyer_id', $this->user->id)->where('level', '>=', $course_level)->count();


						if ($sales_count < $count) {
							return false;
						}

					break;
				
				default:

					break;
			}


		}



		//in_team
		$in_team = $detail['in_team'];

		foreach ($in_team as $key => $team_requirement) {
			$member_rank = $team_requirement['member_rank'];
			if (($member_rank=='') || ($team_requirement['count'] == '')) { continue;}

			$count = $this->user->find_rank_in_team('enrolment', $member_rank);
			

			if ($count < $team_requirement['count']) {
				return false;
			}

		}


		//direct_lines
		$direct_line = $detail['direct_line'];


		foreach ($direct_line as $key => $direct_line_requirement) {
			$member_rank = $direct_line_requirement['member_rank'] ?? 0;

			if (($member_rank=='') || ($direct_line_requirement['count'] == '')) { continue;}

			$count = $this->user->find_rank_in_direct_line('enrolment', $member_rank);


			if ($count < $direct_line_requirement['count']) {
				return false;
			}


		}


		return true;
	}



	public function points_volume($detail, $index)
	{


		//check life_personal_points
		 $required_life_personal_points = $detail['life_personal_points'];

		if ($required_life_personal_points != '') {

			$found_life_personal_points =  ($this->user->total_volumes('all', 'enrolment', [], 'points', 'personal'));

			if ($found_life_personal_points < $required_life_personal_points ) {
				return false;
			}
		}


		//check life_group_points
		 $required_life_group_points = $detail['life_group_points'];

		if ($required_life_group_points != '') {

			$found_life_group_points =  ($this->user->total_volumes('all', 'enrolment', [], 'points', 'group'));

			if ($found_life_group_points < $required_life_group_points ) {
				return false;
			}
		}

		


		return true;

	}

	//checking donwline at a particular level in set tree
	public function binary_gains($detail, $index)
	{

		foreach ($detail as $key => $binary_gains) {

			if (($binary_gains['count']=='') && ($binary_gains['level']=='') ) {
				continue;
			}


			$downlines =  $this->user->referred_members_downlines($binary_gains['level'], 'binary');

			$downlines =  $downlines[$binary_gains['level']] ?? [];

			if (count($downlines) < $binary_gains['count']) {
				return false;
			}
		}

	}




}


















?>