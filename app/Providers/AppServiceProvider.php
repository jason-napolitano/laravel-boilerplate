<?php

namespace App\Providers {

    use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\Event;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Auth\Events\Login;

    class AppServiceProvider extends ServiceProvider
    {
        public function boot(): void
        {
            Gate::before(static function ($user, $ability) {
                return $user->hasRole('admin') ? true : null;
            });

            Event::listen(Login::class, static function (Login $login) {
                $login->user->last_login_at = now();
                $login->user->last_login_ip = request()->ip();
                $login->user->save();
            });
        }
    }
}
