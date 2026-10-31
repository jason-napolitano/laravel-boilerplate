<?php

namespace App\Enums {

    enum DirectoryPath
    {
        case BASE;
        case APP;
        case CONFIG;
        case DATABASE;
        case LANG;
        case PUBLIC_DIR;
        case RESOURCES;
        case ROUTES;
        case STORAGE;
        case TESTS;

        public function path(string $path = ''): string
        {
            return match ($this) {
                self::BASE       => base_path($path),
                self::APP        => app_path($path),
                self::CONFIG     => config_path($path),
                self::DATABASE   => database_path($path),
                self::LANG       => lang_path($path),
                self::PUBLIC_DIR => public_path($path),
                self::RESOURCES  => resource_path($path),
                self::ROUTES     => base_path('routes'),
                self::STORAGE    => storage_path($path),
                self::TESTS      => base_path('tests'),
            };
        }
    }
}
