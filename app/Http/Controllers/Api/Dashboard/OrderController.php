<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Models\Order;
use App\Models\OrderHistory;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderHistoryResource;
use App\Http\Requests\Api\Dashboard\StoreOrderRequest;
use App\Http\Requests\Api\Dashboard\FollowOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return OrderResource::collection(Order::filter()->latest()->paginate());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return OrderResource
     */
    public function store(StoreOrderRequest $request)
    {
        $this->middleware('permission:create orders');

        $order = Order::create($request->validated());

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  Order  $order
     * @return OrderResource
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    public function follow(FollowOrderRequest $request)
    {
        return new OrderHistoryResource(
        //it will observe order to update its status to the current status -> when order history created
            OrderHistory::create(
                $request->validated() + ['user_id' => auth()->user()->id]
            )
        );
    }
}
