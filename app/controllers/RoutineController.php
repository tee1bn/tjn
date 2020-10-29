<?php


/**
 */
class RoutineController extends controller
{


    public function __construct()
    {

        $this->auth()->block_if_has_expired_payout();
    }


    public function give_bonuses_due()
    {

        return;


        $proper_compensation_plan_index = ((int)$this->auth()->rank + 1);

        $proper_compensation_plan = MlmSetting::compensation_breakdown()[$proper_compensation_plan_index];
        $downline_level_of_interest = $proper_compensation_plan['downline_level'];
        $min_no_of_downlines = $proper_compensation_plan['min_no_of_downlines'];

        //bonuses
        $amount_earnable = $proper_compensation_plan['amount_earnable'];
        $grocery_voucher_earnable = (int)$proper_compensation_plan['grocery_voucher_earnable'];
        $live_chickens_or_rx = $proper_compensation_plan['live_chickens_or_rx'];
        $no_of_life_chicken = $live_chickens_or_rx[0];
        $cash_eq_of_life_chicken = $live_chickens_or_rx[1];


        $downlines_at_level = $this->auth()
            ->referred_members_downlines($downline_level_of_interest)[$downline_level_of_interest];

        if (count($downlines_at_level) >= $min_no_of_downlines) {

            LevelIncomeReport::credit_user($this->auth()->id, $amount_earnable, "Level $proper_compensation_plan_index Basic Bonus", $proper_compensation_plan_index);


            LevelIncomeReport::credit_user($this->auth()->id, $grocery_voucher_earnable, "Level $proper_compensation_plan_index Grocery Voucher Bonus", $proper_compensation_plan_index);


            LevelIncomeReport::credit_user($this->auth()->id, $live_chickens_or_rx[1], "Level $proper_compensation_plan_index - $live_chickens_or_rx[0] Life Chicken(s) Bonus", $proper_compensation_plan_index);

            $this->auth()->increment('rank');


        }


    }


// ?pxmw?Lo}wMQ


}


?>