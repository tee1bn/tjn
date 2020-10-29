<?php

/**
 *
 */
class operations
{


    public function pagination_links($data, $per_page)
    {


        $query_string = $_SERVER['QUERY_STRING'];

        parse_str($query_string, $q_array);
        $route = $q_array['url'];
        unset($q_array['url']);
        unset($q_array['page']);

        $q_string = http_build_query($q_array);


        $url = config::domain().'/'.$route . "?$q_string";


        if ($url == null) {

            $url = Config::domain() . "/" . $_GET['url'] . '?';

        } else {

            $url .= '&';
        }

        if (is_int($data)) {

            $no_of_pages = ceil($data / $per_page);

        } else {

            $no_of_pages = ceil((count($data)) / $per_page);
        }

        $link = '';
        $current_page = (isset($_GET['page'])) ? $_GET['page'] : 1;

        $page_prev = ($current_page == 1 || (!isset($current_page))) ? 1 : ($current_page - 1);
        $page_next = ($current_page == $no_of_pages) ? $no_of_pages : ($current_page + 1);


        $prev_page = "<li class='page-item'><a class='page-link' href='{$url}page=$page_prev'>Prev</a></li>";
        $next_page = "<li class='page-item'><a class='page-link' href='{$url}page=$page_next'>Next</a></li>";

        $first_page = "<li class='page-item'><a class='page-link' href='{$url}page=1'><<</a></li>";
        $last_page = "<li class='page-item'><a class='page-link' href='{$url}page=$no_of_pages'>>></a></li>";

        $main_nav = [];
        for ($i = 1; $i <= $no_of_pages; $i++) {

            if ($current_page == $i) {
                $active = 'active';
            } elseif (!isset($current_page) && ($i == 1)) {
                $active = 'active';
            } else {
                $active = '';
            }

            $main_nav[$i] = "<li class='page-item $active'><a class='page-link' href='{$url}page=$i'>$i</a></li>";
        }


        if (count($main_nav) == 0) {
            return null;
        }


        $showable_index = array_unique([
            1,
            2,
            ($current_page - 2),
            ($current_page - 1),
            $current_page,
            ($current_page + 1),
            ($current_page + 2),
            ($no_of_pages - 1),
            $no_of_pages
        ]);

        $smart_link = '';
        foreach ($showable_index as $key => $index) {
            if (isset($main_nav[$index])) {
                $smart_link .= $main_nav[$index];
            }
        }

        $link = $first_page . $prev_page . $smart_link . $next_page . $last_page;

        return $link;


    }


    public function pictures()
    {

        $dir = 'public/img/upload/';
        $file = scandir($dir);
        unset($file[0]);
        unset($file[1]);

        return $file;

    }


    public function ordinal($number)
    {
        $ends = array('th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th');
        if ((($number % 100) >= 11) && (($number % 100) <= 13))
            return $number . 'th';
        else
            return $number . $ends[$number % 10];
    }

    public function strip($string)
    {
        return trim(strip_tags("$string"));
    }

    public function encode_for_url($string)
    {
        return str_replace(' ', '-', $string);
    }


    public function decode_url($string)
    {
        $string = str_replace('-', ' ', $string);
        $string = str_replace('_', ' ', $string);
        return $string;
    }


    public function flash($message, $message_type)
    {

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        $notice = array('type' => $message_type, 'message' => $message);
        print_r(json_encode($notice));


    }


}


?>