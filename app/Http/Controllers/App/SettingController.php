<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\SettingResource;
use App\Services\Website\SettingService;

class SettingController extends Controller
{
    public function __construct(private SettingService $settingService)
    {
    }

    /**
     * Display the settings.
     */
    public function show()
    {
        $setting = $this->settingService->getSettings();
        return new SettingResource($setting);
    }
}
