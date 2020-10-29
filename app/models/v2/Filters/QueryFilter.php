<?php

namespace Filters;
use  Illuminate\Database\Eloquent\Builder;


abstract class QueryFilter
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @param Collection $collection
     */
    protected $collection;

    /**
     * @param collection $collection
     */
    public function __construct($request = [])
    {
        if ($request == []) {
            $this->request = $_REQUEST;
        }
            $this->request = $request;
    }

    /**
     * @param Builder $builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;


        foreach ($this->fields() as $field => $value) {
            $method = ($field);
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], (array)$value);
            }
        }
    }
    

    /**
     * @param Collection $collection
     */
    public function sieve($collection)
    {
        $this->builder = $collection;

        foreach ($this->fields() as $field => $value) {
            $method = ($field);
            if (method_exists($this, $method)) {
                call_user_func_array([$this, $method], (array)$value);
            }
        }

        return $this->builder;
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        return    array_map(function($field){
                        if (is_array($field)) {
                            return $field;
                        }
                      return trim($field);
            }, $this->request);
    }
}
