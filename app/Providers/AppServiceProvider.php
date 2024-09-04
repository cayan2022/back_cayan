<?php

namespace App\Providers;

use App\Mail\ReminderEmail;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Password::defaults(function () {
            $rule = Password::min(8);
            return $this->app->isProduction()
                ? $rule->mixedCase()->symbols()->numbers()
                : $rule;
        });

        // Ensure that the user is authenticated before performing the check
        if (Auth::guard('sanctum')->check()) {
            // Fetch the date you want to check from the database
            $user = Auth::guard('sanctum')->user(); // Assuming the date is linked to the authenticated user

            $orders = Order::filter()->whereHas('histories', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->whereStatusId(2)->get();

            foreach ($orders as $order) {
                if (Carbon::now()->diffInDays(Carbon::parse($order->histories->last()->duration), false) == 1) {
                    // Perform your action, e.g., sending a reminder email
                    $details = [
                        'email' => $user->email,
                        'title' => ' تذكير متابعة الطلب' . $order->id,
                        'body' => $order->id . ' ورقم الطلب  ' . $order->user->phone .' - '.$order->user->name . 'تم التأخير على متابعة العميل ',
                    ];

                    // Dispatch the email (you can also use a job here)
                    if ($order->histories->last()->get_reminder == 0) {
                        \Mail::to($details['email'])->send(new ReminderEmail($details));
                        $order->histories->last()->update(['get_reminder' => 1]);
                    }
                }
            }

        }
    }
}
