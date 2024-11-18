<?php

namespace App\Console\Commands;

use App\Mail\ReminderEmail;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Services\EmailService;
use App\Services\WhatsappService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReminderEmployeeOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orderEmployee:reminder';

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
        $orders = Order::filter()->whereHas('histories', function ($q) {
            $q->where('duration', '<', now());
        })->whereStatusId(2)->get();

        foreach ($orders as $order) {
            if ($order->histories->last()->get_reminder == 0) {

                $message = 'نرجو تتبع الطلب ' . $order->id . ' الخاص بالعميل ' . $order->user->name . ' بحيث انه تم التأخر في متابعة الطلب';
                WhatsappService::sendMessage($order->histories->last()->employee->phone, $message);

                // send email
                $data = [
                    'name' => $order?->user->name,
                    'category' => $order->category?->name,
                    'source' => $order->source?->name,
                    'client_email' => $order?->user->email,
                    'status' => $order->status?->name,
                    'phone' => $order?->user->phone,
                    'last_employee' => $order->last_employee,
                    'order_link' => env('CAYAN_DASH') . '/orders/' . $order->id . '/request',
                    'order_number' => $order->id,
                    'subject' => 'Order Follow up',
                    'email' => $order->histories->last()->employee->email,
                    'background' => env('APP_URL') . "/mail/background.png",
                    'logo' => env('APP_URL') . "/mail/logo.png",
                    'bracket' => env('APP_URL') . "/mail/bracket.png",
                    'bracket - rotated' => env('APP_URL') . "/mail/bracket-rotated.png",
                    'face' => env('APP_URL') . "/mail/face.png",
                    'insta' => env('APP_URL') . "/mail/insta.png",
                    'link' => env('APP_URL') . "/mail/link.png",
                    'snap' => env('APP_URL') . "/mail/snap.png",
                    'x' => env('APP_URL') . "/mail/x.png",
                    'yout' => env('APP_URL') . "/mail/yout.png",
                ];

                new EmailService($data, 'order');

                $order->histories->last()->update(['get_reminder' => 1]);
            }
        }

        return Command::SUCCESS;
    }
}
