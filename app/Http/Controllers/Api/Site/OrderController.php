<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Country;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  CreateOrderRequest  $createOrderRequest
     * @return OrderResource
     */
    public function __invoke(CreateOrderRequest $createOrderRequest)
    {
        $user = User::firstOrCreate(['phone' => $createOrderRequest->phone],
                                    ['country_id' => Country::first()->id, 'name' => $createOrderRequest->name]);
        $order = Order::create(
            $createOrderRequest->only(['source_id', 'category_id']) +
            [
                'user_id' => $user->id,
                'status_id' => 1
            ]
        );

        return new OrderResource($order);
    }
}
