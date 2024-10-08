<?php

namespace App\Http\Controllers\Api\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Site\CreateOrderRequest;
use App\Http\Requests\Api\Site\CreateSaasOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Country;
use App\Models\Order;
use App\Models\User;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        $data = [
            'phone' => $phone,
            'email' => $createOrderRequest->email,
            'name' => $createOrderRequest->name,
            'country_id' => Country::first()->id,
            'type' => User::MODERATOR,
            'company_name' => $createOrderRequest->company_name ?? null,
            'company_spec' => $createOrderRequest->company_spec ?? null,
            'domain' => $createOrderRequest->domain ?? null,
            'password' => $createOrderRequest->password,
            'plain_pass' => request()->password,
        ];

        $user = User::query()->withoutTrashed()
            ->where(['phone' => $phone, 'email' => $createOrderRequest->email])
            ->orWhere('phone', $phone)
            ->orWhere('email', $createOrderRequest->email)
            ->firstOr(function () use ($createOrderRequest, $phone, $data) {
                $user = User::create([
                    'phone' => $phone,
                    'email' => $createOrderRequest->email,
                    'country_id' => Country::first()->id,
                    'name' => $createOrderRequest->name,
                    'type' => User::PATIENT,
                    'password' => bcrypt($createOrderRequest->password),
                ]);
                // create tenant
                if ($createOrderRequest->type == 2) {

                    $user->tenant()->create([
                        'company_name' => $createOrderRequest->company_name ?? null,
                        'company_spec' => $createOrderRequest->company_spec ?? null,
                        'domain' => $createOrderRequest->domain ?? null,
                        'expired_at' => Carbon::now()->addDays(7),
                        'is_paid' => 0,
                        'tenant_pass' => encrypt(request()->password),
                    ]);
                    Http::post('https://api.cayan.llc/api/site/create-tenant', $data);
                }

                return $user;
            });

        $order = Order::create(
            $createOrderRequest->only(['source_id', 'category_id', 'branch_id']) +
            [
                'user_id' => $user->id,
                'status_id' => Order::NEW,
                'type' => $createOrderRequest->type ?? 1
            ]
        );

        if ($createOrderRequest->type == 1) {
            // send whatsapp message to the clint
            $message = 'مرحبا بكم في شركة كيان للتسويق الإلكتروني والحلول البرمجية
تم تسجيل طلبكم بنجاح باسم            ' . $createOrderRequest?->name . ' وهي بخصوص خدمة ' . $order->category?->name . ' سيتم التواصل معكم من فريقنا التقني';
            WhatsappService::sendMessage($phone, $message);

            //send whatsapp message to admin
            $admin_phones = ['966567275203', '966554441038', '96653792794'];
            $admin_message = 'جاء طلب جديد في لوحة التحكم
يرجي متابعة العميل             ' . $createOrderRequest?->name . ' يستفسر بخصوص خدمة ' . $order->category?->name . ' مرسل الطلب برقم جوال ' . $phone . '
يمكنك متابعة الطلب عن طريق هذا الرابط             ' . env('APP_DASH') . '/orders/' . $order->id . '/request
نشكركم علي مجهودكم             ';

            foreach ($admin_phones as $admin_phone) {
                WhatsappService::sendMessage($admin_phone, $admin_message);
            }
        }
        return new OrderResource($order);
    }


    public function storeSaasOrder(CreateSaasOrderRequest $createSaasOrderRequest)
    {
        $phone = $createSaasOrderRequest->phone;
        if (preg_match("~^0\d+$~", $createSaasOrderRequest->phone)) {
            $phone = '966' . substr($createSaasOrderRequest->phone, 1);
        } elseif (preg_match("~^5\d+$~", $createSaasOrderRequest->phone)) {
            $phone = '966' . $createSaasOrderRequest->phone;
        }

        $data = [
            'phone' => $phone,
            'email' => $createSaasOrderRequest->email,
            'name' => $createSaasOrderRequest->name,
            'country_id' => Country::first()->id,
            'type' => User::MODERATOR,
            'company_name' => $createSaasOrderRequest->company_name ?? null,
            'company_spec' => $createSaasOrderRequest->company_spec ?? null,
            'domain' => $createSaasOrderRequest->domain ?? null,
            'password' => $createSaasOrderRequest->password,
            'plain_pass' => request()->password,
        ];

        $user = User::create([
            'phone' => $phone,
            'email' => $createSaasOrderRequest->email,
            'country_id' => Country::first()->id,
            'name' => $createSaasOrderRequest->name,
            'type' => User::PATIENT,
            'password' => bcrypt($createSaasOrderRequest->password),
        ]);

        $user->tenant()->create([
            'company_name' => $createSaasOrderRequest->company_name ?? null,
            'company_spec' => $createSaasOrderRequest->company_spec ?? null,
            'domain' => $createSaasOrderRequest->domain ?? null,
            'expired_at' => Carbon::now()->addDays(7),
            'is_paid' => 0,
            'tenant_pass' => encrypt(request()->password),
        ]);
        Http::post('https://api.cayan.llc/api/site/create-tenant', $data);

        $order = Order::create(
            $createSaasOrderRequest->only(['source_id', 'category_id', 'branch_id']) +
            [
                'user_id' => $user->id,
                'status_id' => Order::NEW,
                'type' => 2
            ]
        );

        return new OrderResource($order);

    }
}
