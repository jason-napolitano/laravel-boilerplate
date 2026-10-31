<?php

namespace App\Http\Controllers {

    use App\Models\Setting;
    use App\Services\SettingsService;

    abstract class Controller
    {
        /**
         * Injection of the SettingsService
         */
        public function __construct(protected ?Setting $settings = null)
        {
            $this->settings = app(SettingsService::class);
        }
    }
}
