<?php

namespace App\Services;

use Carbon\Carbon;

class CampaignWhatsappService
{
    public static function sendCampaign($campaign_name, $campaign_desc, $message, $image = null, $to = [])
    {
        $client = new \GuzzleHttp\Client();
        $url = 'https://cloudwa.net/api/v2/campaigns/create';
        $response = $client->post(
            $url,
            [
                'headers' => [
                    'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Accept-Language' => 'ar',
                ],
                'json' => [
                    'name' => $campaign_name,
                    'description' => $campaign_desc,
                    'session_uuid' => '9d01c371-4fa1-47d5-850c-ee543817edda',
                    'phones' => $to,
                    'type' => 'IMAGE',
                    'starting_time' => Carbon::now()->format('Y-m-d H:i:s'),
                    'ending_time' => Carbon::now()->addDay()->format('Y-m-d H:i:s'),
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
