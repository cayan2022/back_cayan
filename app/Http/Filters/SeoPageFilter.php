<?php

namespace App\Http\Filters;

class SeoPageFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'meta_name',
        'meta_description',
        'meta_keywords',
    ];

    /**
     * Filter the query by a given name.
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
                        $query->whereTranslationLike('meta_name', '%'.$value.'%')
                            ->orWhereTranslationLike('meta_description', '%'.$value.'%')
                            ->orWhereTranslationLike('meta_keywords', '%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }
}
