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
        if (isset($data['mobile'])) {
            $data['mobile'] = '2' . $data['mobile'];
        }

        if (isset($data['whatsapp'])) {
            $data['whatsapp'] = '2' . $data['whatsapp'];
        }

        $setting = Setting::firstOrCreate([]);
        $setting->update($data);
        return $setting->fresh();
    }
}
