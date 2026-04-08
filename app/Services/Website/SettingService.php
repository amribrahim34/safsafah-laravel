<?php

namespace App\Services\Website;

use App\Models\Setting;

class SettingService
{
    public function getSettings(): ?Setting
    {
        return Setting::first();
    }
}
