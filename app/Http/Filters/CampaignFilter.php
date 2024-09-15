<?php

namespace App\Http\Filters;

class CampaignFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'description'
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
            return $this->builder
                ->when(
                    $this->request->filled('name'),
                    function ($query) use ($value) {
                        $query->whereTranslationLike('name','%'.$value.'%')
                            ->orWhereTranslationLike('description','%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }


}
