<?php

namespace App\Http\Filters;

class SourceFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'identifier',
    ];

    /**
     * Filter the query by a given name.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
    {
        if ($value) {
            return $this->builder->whereTranslationLike('name', "$value%");
        }

        return $this->builder;
    }

    protected function identifier($value)
    {
        if ($value) {
            return $this->builder->whereTranslationLike('name', "$value%");
        }

        return $this->builder;
    }



}
