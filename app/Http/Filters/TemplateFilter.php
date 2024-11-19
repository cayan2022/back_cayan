<?php

namespace App\Http\Filters;

use App\Models\Template;

class TemplateFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'slug',
        'type',
        'free'
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
                        $query->where('name','like', '%'.$value.'%');
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
                        $query->where('slug','like', '%'.$value.'%');
                    }
                );
        }
        return $this->builder;
    }


    protected function type($value)
    {
        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('type'),
                    function ($query) use ($value) {
                        $query->where('type','like', '%'.$value.'%');
                    }
                );
        }
        return $this->builder;
    }

    protected function free(bool $value)
    {
        if ($value !== null) {
            return $this->builder->where('is_free', $value);
        }
        return $this->builder;
    }

}
