<?php

namespace App\Services;

use Carbon\Carbon;

class WhatsappService
{
    public static function sendMessage($to, $message)
    {
        $client = new \GuzzleHttp\Client();
        $url = 'https://cloudwa.net/api/v2/messages/send-message';
        $response = $client->post(
            $url,
            [
                'headers' => [
                    'Authorization' => 'Bearer 579584|x13XSXogBfBgKv1YR8dcTB1ttQd2aK2jhpSftX0a4a52b3d2',
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Accept-Language' => 'ar',
                ],
                'json' => [
                    'session_uuid' => '9d01c371-4fa1-47d5-850c-ee543817edda',
                    'chat_id' => $to,
                    'schedule_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'type' => 'TEXT',
                    'urgency' => '2',
                    'message' => $message,
//                    'image' => 'https://static.facebook.com/images/whatsapp/www/whatsapp-promo.png',
                ],
            ]
        );
        $body = $response->getBody();
        print_r(json_decode((string)$body));
    }
}
