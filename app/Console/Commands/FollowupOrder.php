<?php

namespace App\Console\Commands;

use App\Mail\ReminderEmail;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\User;
use App\Services\EmailService;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FollowupOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Order:followup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $order_before_10_mins = Order::where('status_id', 2)
            ->whereHas('histories',function ($q) {
                $q->last()->where('duration', Carbon::now()->addMinutes(10));
            })->first();

        $order_after_10_mins = Order::where('status_id', 2)
            ->whereHas('histories',function ($q) {
                $q->last()->where('duration', Carbon::now()->subMinutes(10));
            })->first();

        $order_after_day = Order::where('status_id', 2)
            ->whereHas('histories', function ($q) {
                $q->where('duration', Carbon::now()->subDay()->toDateTimeString());
            })
            ->first();


        $admin = User::where('tenant_id', config('state.tenant_id'))
            ->where('type', User::ADMIN)->first();

        if ($order_after_10_mins) {
            $message = 'نرجو تتبع الطلب ' . $order_after_10_mins->id . ' الخاص بالعميل ' . $order_after_10_mins->user->name . ' بحيث انه تم التأخر في متابعة الطلب';
            WhatsappService::sendMessage($order_after_10_mins->histories->last()->employee->phone, $message);
        }

        if ($order_before_10_mins) {
            $message = 'نرجو تتبع الطلب ' . $order_before_10_mins->id . ' الخاص بالعميل ' . $order_before_10_mins->user->name;
            WhatsappService::sendMessage($order_before_10_mins->histories->last()->employee->phone, $message);
        }
        if ($order_after_day) {
            $message = 'نرجو تتبع الطلب ' . $order_after_day->id . ' الخاص بالعميل ' . $order_after_day->user->name;
            WhatsappService::sendMessage($order_after_day->histories->last()->employee->phone, $message);
        }

        return Command::SUCCESS;
    }
}
