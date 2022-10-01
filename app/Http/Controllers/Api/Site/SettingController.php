<?php

namespace App\Http\Controllers\Api\Site;

use App\Models\Setting;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  Setting  $setting
     * @return SettingResource
     */
    public function __invoke(Setting $setting): SettingResource
    {
        return $setting->getResource();
    }
}
