<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Helpers\Traits\RespondsWithHttpStatus;
use App\Http\Resources\SaasOrderResource;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderHistoryResource;
use App\Http\Requests\Api\Dashboard\StoreOrderRequest;
use App\Http\Requests\Api\Dashboard\FollowOrderRequest;
use App\Models\UserTenant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    use RespondsWithHttpStatus;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        if ($request->status == 'متابعة') {
            $orders = Order::filter()->orderBy(OrderHistory::select('order_histories.duration')
                ->whereColumn('order_histories.order_id', 'orders.id')
                ->where('type', 1)
                ->latest()->take(1), 'asc')->paginate();
        } else {
            $orders = Order::filter()->where('type', 1)->latest()->paginate();
        }

        return OrderResource::collection($orders);
    }


    public function getSaasOrders(Request $request)
    {
        $orders = Order::filter()->where('type', 2)->latest()->paginate();
        return SaasOrderResource::collection($orders);
    }


    public function showSaasOrder(Order $order)
    {
        return SaasOrderResource::make($order);
    }

    public function renewSaasOrder(Request $request)
    {
        // make validation
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|gt:0',
            'invoice_number' => 'required',
            'duration' => 'required|gt:0',
        ]);
        $user_tenant = UserTenant::where('user_id', $request->user_id)->first();
        $order = Order::where('user_id', $request->user_id)->where('type', 2)->first();
        $user_tenant->update([
            'is_paid' => 1,
            'amount' => $request->amount,
            'invoice_number' => $request->invoice_number,
            'expired_at' => Carbon::now()->addMonths($request->duration),
        ]);
        $user_tenant->user->update([
            'is_block' => 0,
        ]);

        // call api in cayan med to update user data tenant
        $data = [
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'invoice_number' => $request->invoice_number,
            'domain' => $user_tenant->domain,
            'duration' => 'required|gt:0',
        ];
        Http::post('https://api.cayan.llc/api/site/renew-tenant', $data);


        return SaasOrderResource::make($order);
    }

    public function changeSaasOrderStatus(Order $order)
    {
        $order->user->update([
            'is_block' => !($order->user->is_block),
        ]);

        if ($order->user->is_block) {
            $order->user()->tokens()->delete();
        }

        Http::get('https://api.cayan.llc/api/site/change-status-tenant',[
            'domain' => $order->user->tenant->domain,
        ]);

        return SaasOrderResource::make($order);
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create($request->validated());

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
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

    public function destroy(Order $order)
    {
        $order->delete();
        return $this->success(__('auth.success_operation'));

    }
}
