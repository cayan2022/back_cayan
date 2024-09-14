<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\CreateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Country;
use App\Models\Order;
use App\Models\User;
use App\Services\WhatsappService;

class OrderController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param CreateOrderRequest $createOrderRequest
     * @return OrderResource
     */
    public function __invoke(CreateOrderRequest $createOrderRequest): OrderResource
    {
        $user = User::query()->withoutTrashed()
            ->where(['phone' => $createOrderRequest->phone, 'email' => $createOrderRequest->email])
            ->orWhere('phone', $createOrderRequest->phone)
            ->orWhere('email', $createOrderRequest->email)
            ->firstOr(function () use ($createOrderRequest) {
                return User::create([
                    'phone' => $createOrderRequest->phone,
                    'email' => $createOrderRequest->email,
                    'country_id' => Country::first()->id,
                    'name' => $createOrderRequest->name,
                    'type' => User::PATIENT
                ]);
            });

        $user->update(['phone' => $createOrderRequest->phone, 'email' => $createOrderRequest->email]);

        $order = Order::create(
            $createOrderRequest->only(['source_id', 'category_id', 'branch_id']) +
            [
                'user_id' => $user->id,
                'status_id' => Order::NEW
            ]
        );

        // TODO: Send Whatsapp Message to this user
        try {
            $message = 'مرحبا بكم في شركة كيان للتسويق الإلكتروني والحلول البرمجية
تم تسجيل طلبكم بنجاح باسم ' . $createOrderRequest->name . ' وهي بخصوص خدمة ' . $createOrderRequest->category->name . ' سيتم التواصل معكم من فريقنا التقني';
            WhatsappService::sendMessage($createOrderRequest->phone, $message);
        } catch (\Exception $e) {
            // TODO: Handle exception
        }
        return new OrderResource($order);
    }
}
