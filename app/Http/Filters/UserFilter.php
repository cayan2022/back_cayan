<?php

namespace App\Http\Filters;

class UserFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
        'email',
        'phone'
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
            return $this->builder->where('name', 'like', "%$value%");
        }

        return $this->builder;
    }


    /**
     * Filter the query to include users by email.
     *
     * @param string|int $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function email($value)
    {
        if ($value) {
            return $this->builder->where('email', 'like', "%$value%");
        }

        return $this->builder;
    }

    protected function phone($value){

        if ($value) {
            return $this->builder
                ->when(
                    $this->request->filled('phone'),
                    function ($query) use ($value) {
                        $query->where('phone', 'like', '%'.$value.'%');
                    }
                );
        }

        return $this->builder;
    }
}
