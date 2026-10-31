<?php

namespace Database\Seeders {

    use Illuminate\Database\Seeder;
    use App\Models\Setting;

    class SettingsSeeder extends Seeder
    {
        public function run(): void
        {
            Setting::create([
                'title'                 => env('APP_NAME'),
                'description'           => env('APP_DESCRIPTION'),
                'version'               => env('APP_VERSION'),
                'items_per_page'        => env('APP_DEFAULT_PAGINATION'),
                'enable_passkeys'       => env('APP_ENABLE_PASSKEYS'),
                'enable_reset_password' => env('APP_ENABLE_RESET_PASSWORD'),
                'enable_registration'   => env('APP_ENABLE_REGISTRATION'),
                'logo'                  => env('APP_LOGO'),
            ]);
        }
    }
}
