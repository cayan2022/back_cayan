<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\WhatsappService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsappMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $messageData;

    public function __construct($messageData)
    {
        $this->messageData = $messageData;
    }


    public function handle()
    {
        // send whatsapp message to the clint
        WhatsappService::sendMessage($this->messageData['phone'], $this->messageData['message']);

        //send whatsapp message to admin
        $admins = User::where([
            'type' => User::MODERATOR,
            'is_block' => 0
        ])->get();

        $admin_message = $this->messageData['admin_message'];

        foreach ($admins as $admin) {
            WhatsappService::sendMessage($admin->phone, $admin_message);
        }
    }
}
