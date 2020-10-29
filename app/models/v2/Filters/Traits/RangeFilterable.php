<?php

namespace Filters\Traits;

use Illuminate\Database\Eloquent\Builder;

use  Filters\QueryFilter;

trait RangeFilterable
{
    
        public function date($date = null, $column=null, $data_set = 'query')
        {

            if ($date == null) {
                return ;
            }

            $today = date("Y-m-d");
            switch ($date) {
                
                case 'this_week':
                    $date = date_range($today, 'week', true);
                    break;
                
                case 'last_week':
                    $last_week = date("Y-m-d",strtotime("$today -1 week"));
                    $date = date_range($last_week, 'week', true);
                    break;
                
                case 'this_month':
                    $date = date_range($today, 'month', true);
                    break;
                
                case 'last_month':
                    $last_month = date("Y-m-d",strtotime("$today -1 month"));
                    $date = date_range($last_month, 'month', true);
                    break;  

                case 'today':
                    $date = [
                        'start_date' => date('Y-m-d'),
                        'end_date' => date('Y-m-d'),
                    ];
                    break;

                default:
                if (is_array($date)) {

                    //great
                }

                    break;
            }

            extract($date);

            switch ($data_set) {
                case 'query':
                 $this->dateRange($start_date , $end_date, $column);        
                    break;

                case 'collection':
                 return $this->CollectionDateRange($start_date , $end_date, $column);        

                    break;
                
                default:
                    # code...
                    break;
            }
        }


        public function CollectionDateRange($start_date=null, $end_date= null, $column=null)
        {       
            if (($start_date == null) && ($end_date==null)) {
                return $this->builder;
            }

            $this->builder = $this->builder->filter(function($item) use ($start_date, $end_date, $column){

                            return  (strtotime($item[$column]) >= strtotime($start_date)) && (strtotime($item[$column]) <= strtotime($end_date));
                        });

           return $this->builder;
        }


        public function dateRange($start_date=null, $end_date= null, $column=null)
        {       
            if (($start_date == null) && ($end_date==null)) {
                return;
            }

           return $this->builder->whereDate($column,'>=',  $start_date)->whereDate($column, '<=',$end_date);
        }


        public function Range($start=null, $end = null, $column=null)
        {       
            if (($start == null) && ($end ==null)) {
                return;
            }

          return   $this->builder->where($column,'>=',  $start)->where($column, '<=',$end );
        }


}