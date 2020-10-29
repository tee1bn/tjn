<?php

namespace Filters\Traits;

use Illuminate\Database\Eloquent\Builder;

use  Filters\Filters\OrderFilter;
use  Filters\QueryFilter;

trait Filterable
{
    /**
     * @param Builder $builder
     * @param QueryFilter $filter
     */
    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        $filter->apply($builder);
    }
}