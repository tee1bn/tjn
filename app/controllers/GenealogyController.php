<?php

use Filters\Filters\UserFilter;
use v2\Models\InvestmentPackage;

/**
 * this class is the default controller of our application,
 *
 */
class GenealogyController extends controller
{


    public function __construct()
    {


        if (!$this->admin()) {

            $this->middleware('current_user')
                ->mustbe_loggedin();
            // ->mustbe_pay_registration_fee();
        }


    }


    /**
     * [showThisDownine handles the display of generations]
     * @param  [type] $user_id [user to display]
     * @param  [type] $type    [whether referred_by(placement structure)
     *  or introduced_by (enrolment strcuture)]
     * @return [type]          [description]
     */
    public function showThisDownine($user_id, $type)
    {
        $type_detail = [
            'introduced_by' => 'enrolment',
            'referred_by' => 'placement',
            'binary_id' => 'binary',
        ];
        $route = $type_detail[$type];
        $user_ = User::find($user_id);
        $recruiter = User::where('mlm_id', $user_->$type)->first()->username;
        $output = '';
        $output .= '<div  class="col-sm-1 col-xs-1   refer-people" align="center">
    <a href="' . Config::domain() . '/genealogy/placement/' . $user_->username . '/' . $route . '" data-toggle="tooltip" title="Upline:  ' . ucfirst($recruiter) . '">
    ';

        $output .= ' <img class="img-responsive tree-img" src="' . Config::domain() . '/' . $user_->profilepic . '">';

        $output .= ' <p>' . ucfirst($user_->username) . "</p>       
    </a>
    </div>";

        return $output;
    }


    public function place_user($new_member = null, $placement_sponsor_id = null, $username = null)
    {
        echo "<pre>";

        $enrolee = User::find($new_member);
        $placement_sponsor = User::where('username', $username)->first();


        if (($new_member == null) || ($placement_sponsor_id == null)) {
            Session::putFlash('', 'Invalid Placement. Please check and try again.');
            // Redirect::to('genealogy/placement');
            Redirect::to("admin/placement/$username");
            // return;              

        }

        if ($enrolee->placed) {
            Session::putFlash('', 'Enrolee already placed.');
            // Redirect::to('genealogy/placement');
            Redirect::to("admin/placement/$username");
            // return;              

        }


        $new_member_level = $placement_sponsor->enroler_downline_level_of($new_member);
        $placement_sponsor_level = $placement_sponsor->enroler_downline_level_of($placement_sponsor_id);


        if (($new_member_level['present'] != 1) ||
            ($placement_sponsor_level['present'] != 1) ||
            ($new_member == $placement_sponsor_id)
        ) {

            Session::putFlash('', 'Invalid Placement. Please check and try again.');
            // Redirect::to('genealogy/placement');
            Redirect::to("admin/placement/$username");

            return;
        }


        $placement = $enrolee->update([
            'referred_by' => $placement_sponsor_id,
            'placed' => 1,
        ]);

        if ($placement) {
            Session::putFlash('', 'Placed successfully.');
        }


        // Redirect::to('genealogy/placement');
        Redirect::to("admin/placement/$username");

    }


    public function enrolment($user_id = '')
    {
        $use = 'username';

        if ($use == 'id') {
            if ($user_id == '') {
                $user_id = $this->auth()->id;
            }
        } else {
            $requested_user = User::where('username', $user_id)->first();
            $user_id = $requested_user->id;

            if ($requested_user == null) {
                if ($this->auth()) {
                    $user_id = User::where('username', $this->auth()->username)->first()->id;
                }
            }

        }


        $this->view('auth/enrolment-structure', ['user_id' => $user_id]);

    }


    public function placement($user_id = '', $tree_key = 'placement', $requested_depth = null)
    {
        if (!in_array($tree_key, array_keys(User::$tree))) {
            // Session::putFlash("danger","Invalid Request");
            Redirect::to('genealogy/placement');
            die();

        }


        if (is_numeric($requested_depth)) {

            unset($_SESSION['requested_depth']);
        } else {
            $requested_depth = 1;
        }
        if (!isset($_SESSION['requested_depth'])) {

            $_SESSION['requested_depth'] = $requested_depth;
        }
        $levels = $_SESSION['requested_depth'];


        $use = 'username';

        if ($use == 'id') {
            if ($user_id == '') {
                $user_id = $this->auth()->id;
            }
        } else {
            $requested_user = User::where('username', $user_id)->first();
            @$user_id = $requested_user->id;

            if ($requested_user == null) {
                if ($this->auth()) {
                    $user_id = User::where('username', $this->auth()->username)->first()->id;
                }
            }

        }

        $tree = User::$tree[$tree_key];
        $user_column = $tree['column'];

        $this->view('auth/revamped-placement-structure', compact('user_id', 'tree', 'user_column', 'tree_key', 'levels'));


        // $this->view('auth/placement-structure', compact('user_id','tree','user_column','tree_key','levels'));

    }


    //to go up
    public function up()
    {
        echo "<pre>";
        print_r($_POST);
        $user = User::find($_POST['user_id']);
        $level_up = $_POST['level_up'];
        $tree_key = $_POST['tree_key'];

        $upline_mlm_id = $user->max_uplevel('binary')['mlm_ids'][$level_up];
        $upline = User::where('mlm_id', $upline_mlm_id)->first();

        $domain = Config::domain();
        $link = "$domain/genealogy/placement/$upline->username/$tree_key";
        Redirect::to($link);


    }

    public function last($position, $tree_key)
    {
        $auth = $this->auth();
        $last = $auth->all_downlines_at_position($position, $tree_key)->latest()->first();

        if ($last == null) {

            Session::putFlash("danger", "No Downline found");
            Redirect::back();
        }

        $domain = Config::domain();
        $link = "$domain/genealogy/placement/$last->username/$tree_key";
        Redirect::to($link);
    }


    public function showout()
    {
        extract($_POST);
        $domain = Config::domain();
        $link = "$domain/genealogy/placement/$username/$tree_key";
        Redirect::to($link);
    }


    private function users_matters($extra_sieve, $tree_key = 'placement')
    {


        $sieve = $_REQUEST;
        $sieve = array_merge($sieve, $extra_sieve);

        $query = $this->auth()->all_downlines_by_path($tree_key);


        // ->where('status', 1);  //in review
        $sieve = array_merge($sieve);
        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        $per_page = 50;
        $skip = (($page - 1) * $per_page);

        $filter = new  UserFilter($sieve);

        $data = $query->Filter($filter)->count();

        $sql = $query->Filter($filter);

        $users = $query->Filter($filter)
            ->offset($skip)
            ->take($per_page)
            ->get();  //filtered


        return compact('users', 'sieve', 'data', 'per_page');

    }


    public function search($query = null, $tree_key = 'placement')
    {

        $compact = $this->users_matters(['name' => $query], $tree_key);
        $users = $compact['users'];
        $line = "";
        foreach ($users as $key => $user) {
            $username = $user->username;
            $fullname = $user->fullname;
            $line .= "<option value='$username'> $fullname ($username)</option>";
        }

        header("content-type:application/json");
        echo json_encode(compact('line'));
    }

    public function determine_binary_point($member, $down_gen = [], $tree_key)
    {


        $tree = User::$tree[$tree_key];
        $user_column = $tree['column'];
        $user_point = $tree['point'];
        $width = $tree['width'];


        $available = range(0, ($width - 1));
        $taken = [];

        $down_gen = $down_gen ?? [];
        foreach ($down_gen as $key => $offspring) {

            if ($offspring[$user_column] == $member['mlm_id']) {
                $taken[] = $offspring[$user_point];
            }
        }

        $remaining = array_diff($available, $taken);


        return $remaining;

    }

    //this adds dummy user to postions not filled
    public function complete_downline($downlines, $tree_key = null, $levels = null)
    {


        $tree = User::$tree[$tree_key];
        $user_column = $tree['column'];
        $user_point = $tree['point'];
        $width = $tree['width'];


        $total_expection = 0;
        $exp = [];
        for ($i = 0; $i <= $levels; $i++) {
            $p = pow($width, $i);
            $total_expection += $p;
            $exp[$i] = $p;
        }

        $dummies = [];
        $uplines_with_deficient_members = [];

        foreach ($exp as $level => $no) { //check if all levels have expected no of peopele
            $downline_at_level = $downlines[$level] ?? [];

            if (count($downline_at_level) < $no) {


                $up_gen_level = $level - 1;
                $up_gen = $downlines[$up_gen_level] ?? [];    //determine the upper generation

                $down_gen_level = $level + 1;
                $down_gen = $downlines[$down_gen_level] ?? [];  //determine the lower generation

                ksort($up_gen);

                foreach ($up_gen as $key => $member) {
                    $remaining = $width - $member['no_of_direct_line']; //determine the remaining donwline(dummy) a user needs

                    $binary_points_left = $this->determine_binary_point($member, $down_gen, $tree_key); //determine the binarypoints left i.e positions left to fill

                    for ($i = 0; $i < $remaining; $i++) {
                        $mlm_id = -1 - count($dummies);  //generate a random mlm_id in the signed integer spectrun


                        if ($remaining < $width) {
                            $uplines_with_deficient_members[] = $member;  //get offsprings that will have mixed (both real and dummy users)


                            $binary_point = null;
                        } else {

                            $binary_point = $binary_points_left[0];
                            unset($binary_points_left[0]);
                            $binary_points_left = array_values($binary_points_left);
                        }

                        $dummy = [
                            'mlm_id' => $mlm_id,
                            $user_column => $member['mlm_id'],
                            'id' => $mlm_id,
                            'rank' => -1,
                            'username' => 'default',
                            $user_point => $binary_point,
                            'no_of_direct_line' => 0,
                        ];

                        $dummies[] = $dummy;
                        $downlines[$level][] = $dummy;
                    }

                }

            }


        }

        $flatten_downlines = array_flatten($downlines, 1);
        //fix deficient offsprings
        foreach ($uplines_with_deficient_members as $key => $deficient) {
            $mlm_id = $deficient['mlm_id'];
            $corrected_downlines = array_filter($flatten_downlines, function ($downline) use ($mlm_id, $user_column) {
                return $downline[$user_column] == $mlm_id;
            });

            $available = range(0, ($width - 1));
            $taken = [];


            foreach ($corrected_downlines as $key => $downline) { //get all the taken postions
                if ($downline['username'] != 'default') {
                    $taken[] = $downline[$user_point];
                }
            }

            $remaining = array_diff($available, $taken);
            $remaining = array_values($remaining);


            foreach ($corrected_downlines as $key => $downline) {
                if ($downline['username'] == 'default') {

                    $corrected_downlines[$key][$user_point] = $remaining[0];
                    unset($remaining[0]);
                    $remaining = array_values($remaining);
                }
            }


            foreach ($flatten_downlines as $key => $downline) {
                foreach ($corrected_downlines as $ckey => $cdownline) {

                    if (($downline['mlm_id'] == $cdownline['mlm_id']) && ($cdownline['username'] == 'default')) {
                        $flatten_downlines[$key] = $cdownline;
                    }
                }
            }

        }

        return $flatten_downlines;
    }


    public function fetch2($user_id = '', $tree_key = 'placement', $requested_depth = null, $month =null)
    {
        if (!in_array($tree_key, array_keys(User::$tree))) {
            // Session::putFlash("danger","Invalid Request");
            Redirect::to('genealogy/placement');
            die();
        }

        if (is_numeric($requested_depth)) {

            unset($_SESSION['requested_depth']);
        } else {
            $requested_depth = 1;
        }
        if (!isset($_SESSION['requested_depth'])) {

            $_SESSION['requested_depth'] = $requested_depth;
        }
        $levels = $_SESSION['requested_depth'];
        $use = 'id';
        if ($use == 'id') {
            if ($user_id == '') {
                $user_id = $this->auth()->id;
            }
        } else {
            $requested_user = User::where('username', $user_id)->first();
            @$user_id = $requested_user->id;
            if ($requested_user == null) {
                if ($this->auth()) {
                    $user_id = User::where('username', $this->auth()->username)->first()->id;
                }
            }
        }
        $user = User::find($user_id);
        $downlines = $user->referred_members_downlines($levels, $tree_key);

        ksort($downlines);
        //we fill empty positions with dummy users
        // $flatten_downlines = $this->complete_downline($downlines, $tree_key, $levels);

        $flatten_downlines = array_flatten($downlines, 1);




        // print_r($flatten_downlines);
        $tree = User::$tree[$tree_key];
       $user_column = $tree['column'];

        $flatten_downlines = collect($flatten_downlines)->keyBy('mlm_id')->toArray();


        $re = $this->buildTree($flatten_downlines, $user->mlm_id, $user_column);

        //here we include the root in the tree
        $root = [
            'mlm_id' => $user->mlm_id,
            $user_column => $user->$user_column,
            'id' => $user->id,
            'rank' => $user->rank,
            'username' => $user->username,
            'no_of_direct_line' => 0
        ];
        $root['children'] = $re;


        $re = [];
        $re[$user->mlm_id] = $root;



        $list = ($this->buildList($re, $tree_key));
        
       


        $response = compact('list');
        header("content-type:application/json");
        echo json_encode($response);

    }



    public function fetch($user_id = '', $tree_key = 'placement', $requested_depth = null)
    {
        if (!in_array($tree_key, array_keys(User::$tree))) {
            // Session::putFlash("danger","Invalid Request");
            Redirect::to('genealogy/placement');
            die();
        }

        if (is_numeric($requested_depth)) {

            unset($_SESSION['requested_depth']);
        } else {
            $requested_depth = 1;
        }
        if (!isset($_SESSION['requested_depth'])) {

            $_SESSION['requested_depth'] = $requested_depth;
        }
        $levels = $_SESSION['requested_depth'];
        $use = 'id';
        if ($use == 'id') {
            if ($user_id == '') {
                $user_id = $this->auth()->id;
            }
        } else {
            $requested_user = User::where('username', $user_id)->first();
            @$user_id = $requested_user->id;
            if ($requested_user == null) {
                if ($this->auth()) {
                    $user_id = User::where('username', $this->auth()->username)->first()->id;
                }
            }
        }
        $user = User::find($user_id);
        $downlines = $user->referred_members_downlines($levels, $tree_key);

        ksort($downlines);
        //we fill empty positions with dummy users
        $flatten_downlines = $this->complete_downline($downlines, $tree_key, $levels);

        // $flatten_downlines = array_flatten($downlines, 1);


        $tree = User::$tree[$tree_key];
        $user_column = $tree['column'];

        $flatten_downlines = collect($flatten_downlines)->keyBy('mlm_id')->toArray();


        $re = $this->buildTree($flatten_downlines, $user->mlm_id, $user_column);

        //here we include the root in the tree
        $root = [
            'mlm_id' => $user->mlm_id,
            $user_column => $user->$user_column,
            'id' => $user->id,
            'rank' => $user->rank,
            'username' => $user->username,
            'no_of_direct_line' => 0
        ];
        $root['children'] = $re;


        $re = [];
        $re[$user->mlm_id] = $root;

        $list = ($this->buildList($re, $tree_key));


        $response = compact('list');
        header("content-type:application/json");
        echo json_encode($response);

    }


    //This returns the tree structure without the root()
    public function buildTree(array &$elements, $parentId = 0, $user_column)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element[$user_column] == $parentId) {
                $children = $this->buildTree($elements, $element['mlm_id'], $user_column);
                if ($children) {
                    $element['children'] = $children;
                }
                unset($elements[$element['mlm_id']]);
                $branch[$element['mlm_id']] = $element;
            }
        }
        return $branch;
    }

    public function get_detail($user_id, $tree_key)
    {

        $user = User::find($user_id);
        $view = $this->buildView('composed/mlm_detail', compact('user'));

        header("content-type:application/json");
        echo json_encode(compact('view'));
    }


    public function buildList($data, $tree_key)
    {
        $tree = '';


        $d_tree = User::$tree[$tree_key];
        $user_column = $d_tree['column'];
        $user_point = $d_tree['point'];
        $width = $d_tree['width'];


        $i = 1;
        $domain = Config::domain();
        $icon = Config::domain() . "/template/default/app-assets/images/logo/packs";
        foreach ($data as $list_key => $node) {
            $username = $node['username'];
            $id = $node['id'];
            $binary_point = $node[$user_point] ?? '';

            $mlm_id = $node['mlm_id'];

            $user = User::find($id);
            if ($user == null) {
                $view = "";

            } else {


                $pack = null;
                if ($pack == null) {

                    $image_src = "$domain/$user->profilepic";

                } else {

                    $pack_id = $pack->ExtraDetailArray['investment']['pack_id'];
                    $image_src = "$icon/$pack_id.png";
                }


                $view = $this->buildView('composed/mlm_detail', compact('user', 'tree_key'), true);
            }


            if ($user == null) {
                $image_src = "$domain/template/default/app-assets/images/logo/Logo-head.png";

                $drop = <<<MSSG
        <li>

        <span style="border:0px !important; padding-bottom: 10px;">
        <img src="$image_src" style="background: #0000007a;padding: 4px; border-radius: 70%;height: 55px; object-fit:contain;"><br>
        </span>
          
MSSG;

}else{

        $drop = <<<MSSG
        <li>
                <div class="dropdown" style="padding:0px;">

        <span  class="dropdown-toggle" data-toggle="dropdown" style="border:0px !important; padding-bottom: 10px;" id="dropdownMenuButton$i"  aria-haspopup="true" aria-expanded="false">
        <img src="$image_src" style="border-radius: 70%;height: 20px; object-fit:contain;"><br>
        <b style="text-transform:capitalize;font-size:10px;">$user->NameInitials </b>

        </span>
          <div class="dropdown-menu" style="padding:0px; border-radius:5px;" aria-labelledby="dropdownMenuButton$i">
            $view

            <a class="text-primary" href="$domain/genealogy/placement/$user->username/enrolment/2" style="font-size:12px; margin-left:30px;">See Binary Tree</a>

          </div>
        </div>

MSSG;

}

        $tree .= $drop;


            if (isset($node['children'])) {
                    //ensures users are displayed in theier right leg

                    array_multisort(
                                    array_column($node['children'], $user_point), SORT_ASC,
                                    $node['children']);
                
                $tree.= "<ul>";
                $tree.= $this->buildList($node['children'], $tree_key);
                $tree.= "</ul>";
            }

        $tree.="</li>";
        unset($data[$list_key]);
        $i++;
    }

    return $tree;
}




public function placement_list($username=null, $level_of_referral=1, $tree_key='placement', $requested_depth=null)
{

    if (is_numeric($requested_depth)) {

        unset($_SESSION['requested_depth']);
    }else{
        $requested_depth=1;
    }
    if (! isset($_SESSION['requested_depth'] )) {

        $_SESSION['requested_depth'] = $requested_depth;
    }
    $levels = $_SESSION['requested_depth'];



    $user   = User::where('username' ,$username)->first();
    if (($user == null) || (!is_numeric($level_of_referral))) {
        if ($this->auth()) {
            $user = User::where('username', $this->auth()->username)->first();
        }
    }


    $page = (isset($_GET['page']))? $_GET['page'] : 1  ; 
    $per_page = 50;

    $tree = User::$tree[$tree_key];
    $user_column = $tree['column'];


    $list = User::referred_members_downlines_paginated($user->id, $level_of_referral, $per_page , $page, $tree_key );

    $note = MIS::filter_note(count($list['list']) , $list['data'], $list['total'],  $list['sieve'], 1);

    $this->view('auth/placement-structure-list', compact('list', 'user','per_page', 'level_of_referral','tree','user_column','tree_key','levels', 'note'));

}






}























?>