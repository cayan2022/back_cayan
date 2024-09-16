<?php

namespace App\Services;

use Carbon\Carbon;

class CampaignWhatsappService
{
    public static function sendCampaign($campaign_name, $campaign_desc, $message, $start, $end, $image = null, $to = [])
    {
        $client = new \GuzzleHttp\Client();
        $url = 'https://cloudwa.net/api/v2/campaigns/create';
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
                    'name' => $campaign_name,
                    'description' => strip_tags($campaign_desc),
                    'session_uuid' => '9d01c371-4fa1-47d5-850c-ee543817edda',
                    'phones' => $to,
                    'type' => 'IMAGE',
                    'starting_time' => '2024-09-12T12:00:17',
//                    'starting_time' => $start,
                    'ending_time' => '2024-09-24T12:00:17',
//                    'ending_time' => $end,
                    'typing_duration' => 13,
                    'daily_limit' => 7,
                    'message_interval' => 'qui',
                    'add_ref' => false,
                    'message' => $message,
                    'image' => $image,
                ],
            ]
        );
        $body = $response->getBody();
        print_r(json_decode((string)$body));
    }
}
