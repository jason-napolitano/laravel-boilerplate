<?php

namespace App\Providers {

    use Illuminate\Support;
    use Database\Providers;

    class FakerServiceProvider extends Support\ServiceProvider
    {

        /**
         * Bootstrap services.
         */
        public function boot(): void
        {
            fake()->addProvider(new Providers\CategoryProvider(fake()));
            fake()->addProvider(new Providers\ProductProvider(fake()));
        }
    }
}
