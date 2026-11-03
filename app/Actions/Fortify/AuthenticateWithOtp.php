<?php

namespace App\Actions\Fortify {

    use Illuminate\Validation\ValidationException;
    use Illuminate\Contracts\Auth\StatefulGuard;
    use App\Notifications\Auth\OtpNotification;
    use Laravel\Fortify\LoginRateLimiter;
    use Illuminate\Auth\Events\Failed;
    use App\Services\Auth\OTPService;
    use Illuminate\Http\Request;
    use Laravel\Fortify\Fortify;
    use Throwable;

    class AuthenticateWithOtp
    {
        public function __construct(protected StatefulGuard $guard, protected LoginRateLimiter $limiter, protected OTPService $otp)
        {
            // ...
        }

        public function handle(Request $request)
        {
            $credentials = $request->only(Fortify::email(), 'password');
            $provider = $this->guard->getProvider();

            $user = $provider->retrieveByCredentials($credentials);

            if (!$user || !$provider->validateCredentials($user, $credentials)) {
                event(new Failed(config('fortify.guard'), $user, $credentials));

                $this->limiter->increment($request);

                throw ValidationException::withMessages([
                    Fortify::username() => [
                        trans('auth.failed'),
                    ],
                ]);
            }

            // Rehash the password if Laravel requires it.
            if (config('hashing.rehash_on_login', true) && method_exists($provider, 'rehashPasswordIfRequired')) {
                $provider->rehashPasswordIfRequired($user, $credentials);
            }

            $this->limiter->clear($request);

            // Generate the OTP.
            $result = $this->otp->create($user);

            try {
                $user->notify(new OtpNotification($result['code']));
            } catch (Throwable $exception) {
                $this->otp->invalidate(
                    $result['challenge']
                );

                throw $exception;
            }

            // Store the pending challenge in the session.
            $request->session()->put([
                'auth.otp.challenge' => $result['challenge'],
                'auth.otp.remember' => $request->boolean('remember'),
            ]);

            // IMPORTANT: We do not authenticate the user here.
            return redirect()->route('otp.challenge');
        }
    }
}
