<?php

namespace App\Providers {

    use App\Services\SettingsService;
    use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
    use Laravel\Fortify\Actions\CanonicalizeUsername;
    use App\Actions\Fortify\AuthenticateWithOTP;
    use Illuminate\Support\Facades\RateLimiter;
    use Illuminate\Cache\RateLimiting\Limit;
    use Illuminate\Support\ServiceProvider;
    use Laravel\Fortify\Fortify;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;

    class FortifyServiceProvider extends ServiceProvider
    {
        public function register(): void
        {
            //
        }

        public function boot(): void
        {
            // fortify login vue
            Fortify::loginView(static fn () => inertia('auth/login'));

            // application settings
            $settings = app(SettingsService::class);

            // if otp support is enabled
            if ($settings->enable_otp_support) {
                // authenticate using otp
                Fortify::authenticateThrough(function (Request $request) {
                    return array_filter([
	                    config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
	                    config('fortify.lowercase_usernames') ? CanonicalizeUsername::class : null,
	                    AuthenticateWithOTP::class,
                    ]);
                });
            }

            // run the rate limiters
            $this->runRateLimiters();
        }

        private function runRateLimiters(): void
        {
            // login rate limiter
            RateLimiter::for('login', function (Request $request) {
                $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());
                return Limit::perMinute(5)->by($throttleKey);
            });

            // passkeys rate limiter
            RateLimiter::for('passkeys', function (Request $request) {
                $credentialId = $request->input('credential.id');
                return Limit::perMinute(10)->by(
                    ($credentialId ?: $request->session()->getId()) . '|' . $request->ip()
                );
            });

            // otp rate limiter
            RateLimiter::for('otp', function (Request $request) {
                return Limit::perMinute(5)->by($request->session()->getId());
            });
        }
    }
}
