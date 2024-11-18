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

class FollowupNewOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newOrder:followup';

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
        $order_10_mins = Order::where('status_id', 1)
            ->where('created_at', Carbon::now()->subMinutes(10))
            ->first();

        $order_30_mins = Order::where('status_id', 1)
            ->where('created_at', Carbon::now()->subMinutes(30))
            ->first();

        $moderators = User::where([
            'tenant_id' => config('state.tenant_id'),
            'type' => User::MODERATOR,
            'is_block' => 0
        ])->get();
        $admin = User::where('tenant_id', config('state.tenant_id'))
            ->where('type', User::ADMIN)->first();

        if ($order_10_mins) {
            $message = 'نرجو تتبع الطلب ' . $order_10_mins->id . ' الخاص بالعميل ' . $order_10_mins->user->name . ' بحيث انه تم التأخر في متابعة الطلب';
            foreach ($moderators as $moderator) {
                WhatsappService::sendMessage($moderator->phone, $message);
            }
        }

        if ($order_30_mins) {
            $message = 'نرجو تتبع الطلب ' . $order_30_mins->id . ' الخاص بالعميل ' . $order_30_mins->user->name . ' بحيث انه تم التأخر في متابعة الطلب';
            WhatsappService::sendMessage($admin->phone, $message);
        }

        return Command::SUCCESS;
    }
}
