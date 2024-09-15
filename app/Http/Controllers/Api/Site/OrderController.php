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
        $phone = $createOrderRequest->phone;
        if (preg_match("~^0\d+$~", $createOrderRequest->phone)) {
            $phone = '966' . substr($createOrderRequest->phone, 1);
        } elseif (preg_match("~^5\d+$~", $createOrderRequest->phone)) {
            $phone = '966' . $createOrderRequest->phone;
        }
        $user = User::query()->withoutTrashed()
            ->where(['phone' => $phone, 'email' => $createOrderRequest->email])
            ->orWhere('phone', $phone)
            ->orWhere('email', $createOrderRequest->email)
            ->firstOr(function () use ($createOrderRequest, $phone) {
                return User::create([
                    'phone' => $phone,
                    'email' => $createOrderRequest->email,
                    'country_id' => Country::first()->id,
                    'name' => $createOrderRequest->name,
                    'type' => User::PATIENT
                ]);
            });

        $user->update(['phone' => $phone, 'email' => $createOrderRequest->email]);

        $order = Order::create(
            $createOrderRequest->only(['source_id', 'category_id', 'branch_id']) +
            [
                'user_id' => $user->id,
                'status_id' => Order::NEW
            ]
        );

        // send whatsapp message to the clint
        $message = 'مرحبا بكم في شركة كيان للتسويق الإلكتروني والحلول البرمجية
تم تسجيل طلبكم بنجاح باسم ' . $createOrderRequest?->name . ' وهي بخصوص خدمة ' . $order->category?->name . ' سيتم التواصل معكم من فريقنا التقني';
        WhatsappService::sendMessage($phone, $message);

        //send whatsapp message to admin
//        $admin_phones = ['966567275203', '966554441038', '96653792794', '201010529966', '201007425819'];
        $admin_phones = [ '201010529966', '201007425819'];
        $admin_message = 'جاء طلب جديد في لوحة التحكم
يرجي متابعة العميل ' . $createOrderRequest?->name . ' يستفسر بخصوص خدمة ' . $order->category?->name . ' مرسل الطلب برقم جوال ' . $phone . '
يمكنك متابعة الطلب عن طريق هذا الرابط ' . 'https://dash.cayan.co/orders/' . $order->id . '/request
نشكركم علي مجهودكم';

        foreach ($admin_phones as $admin_phone) {
            WhatsappService::sendMessage($admin_phone, $admin_message);
        }

        return new OrderResource($order);
    }
}
