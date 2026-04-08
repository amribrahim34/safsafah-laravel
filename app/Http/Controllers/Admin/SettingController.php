<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Http\Resources\Admin\SettingResource;
use App\Services\Admin\SettingService;

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

    /**
     * Update the settings.
     */
    public function update(UpdateSettingRequest $request)
    {
        $setting = $this->settingService->updateSettings($request->validated());
        return new SettingResource($setting);
    }
}
