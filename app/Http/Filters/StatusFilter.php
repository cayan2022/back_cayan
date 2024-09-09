<?php

namespace App\Http\Filters;

use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\Source;
use App\Models\User;

class StatusFilter extends BaseFilters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [
        'name',
//        'start_date',
//        'employee',
//        'source'
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
                        $query->whereTranslationLike('name', '%' . $value . '%');
                    }
                );
        }

        return $this->builder;
    }

//    protected function startDate($value)
//    {
//        if ($value) {
//            return $this->builder
//                ->when(
//                    $this->request->filled('start_date') && $this->request->filled('end_date'),
//                    function ($query) {
//                        $query->whereBetween(
//                            'created_at',
//                            [
//                                $this->request->get('start_date'),
//                                $this->request->get('end_date')
//                            ]
//                        );
//                    }
//                );
//        }
//
//        return $this->builder;
//    }
//
//    protected function employee($value)
//    {
//        if ($value) {
//            $user = User::where('name', $value)->first();
//            $order_ids = OrderHistory::where('user_id', $user->id)->groupBy('order_id')->pluck('order_id');
//            return $this->builder->withCount([
//                'orders' => function ($query) use ($order_ids) {
//                    $query->whereIn('id', $order_ids);
//                },
//            ]);
//        }
//
//        return $this->builder;
//    }
//
//    protected function source($value)
//    {
//        if ($value) {
//            $source = Source::where('identifier', $value)->first();
//            $order_ids = Order::where('source_id', $source->id)->pluck('id');
//            return $this->builder->withCount([
//                'orders' => function ($query) use ($order_ids) {
//                    $query->whereIn('id', $order_ids);
//                },
//            ]);
//        }
//        return $this->builder;
//    }

}
