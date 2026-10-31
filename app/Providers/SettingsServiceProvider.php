<?php

namespace App\Providers {

    use Illuminate\Support\ServiceProvider;
    use App\Services\SettingsService;

    class SettingsServiceProvider extends ServiceProvider
    {
        public function register(): void
        {
            $this->app->bind(SettingsService::class, fn () => new SettingsService()->get());
        }
    }
}
