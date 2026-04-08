<?php

namespace App\Services\Admin;

use App\Models\Setting;

class SettingService
{
    public function getSettings(): Setting
    {
        return Setting::firstOrCreate([]);
    }

    public function updateSettings(array $data): Setting
    {
        $setting = Setting::firstOrCreate([]);
        $setting->update($data);
        return $setting->fresh();
    }
}
