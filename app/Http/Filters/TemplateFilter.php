<?php

namespace App\Http\Filters;

class TemplateFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'slug'
    ];

    /**
     * Filter the query by a given title.
     *
     * @param  string|int  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function name($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('name'),
                    function ($query) use ($value) {
                        $query->like('name', '%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }

    protected function slug($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('slug'),
                    function ($query) use ($value) {
                        $query->like('slug', '%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }

}
