<?php

namespace App\Services {

    use App\Models\Setting;

    class SettingsService
    {
        public function get(): Setting
        {
            return Setting::query()->first();
        }
    }
}
