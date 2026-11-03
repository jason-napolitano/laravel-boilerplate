<?php

namespace App\Http\Controllers\Auth {

    use App\Http\Controllers\Controller;
    use App\Notifications\Auth\OtpNotification;
    use App\Services\Auth\OTPService;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Validation\ValidationException;
    use Inertia\Response;

    class OTPVerificationController extends Controller
    {
        public function __construct(protected OTPService $otp)
        {
            parent::__construct();
        }

        public function create(Request $request): Response|RedirectResponse
        {
            abort_if(!$this->settings->enable_otp_support, 404);

            $challenge = $request->session()->get('auth.otp.challenge');

            if (!$challenge) {
                return to_route('login');
            }

            return inertia('auth/otp/verify', [
                'resendAvailableIn' => $this->otp->resendAvailableIn($challenge),
            ]);
        }

        /**
         * Verify the OTP and authenticate the user.
         */
        public function store(Request $request): RedirectResponse
        {
            $request->validate([
                'code' => ['required', 'digits:6'],
            ]);

            $challenge = $request->session()->get('auth.otp.challenge');

            if (!$challenge) {
                return redirect()->route('login');
            }

            $user = $this->otp->verify($challenge, $request->input('code'));

            if (!$user) {
                throw ValidationException::withMessages([
                    'code' => 'The verification code is invalid or has expired.',
                ]);
            }

            $remember = $request->session()->get('auth.otp.remember', false);

            $this->otp->invalidate($challenge);

            $request->session()->forget([
                'auth.otp.challenge',
                'auth.otp.remember',
            ]);

            Auth::guard(config('fortify.guard'))->login($user, $remember);

            $request->session()->regenerate();

            return redirect()->intended(config('fortify.home'));
        }

        public function resend(Request $request): RedirectResponse
        {
            $challenge = $request->session()->get('auth.otp.challenge');

            if (!$challenge) {
                return redirect()->route('login');
            }

            $result = $this->otp->resend($challenge);

            try {
                $result['user']->notify(
                    new OtpNotification($result['code'])
                );
            } catch (\Throwable $exception) {
                report($exception);

                throw ValidationException::withMessages([
                    'resend' => 'We could not send your verification code. Please try again.',
                ]);
            }

            return back()->with('status', 'A new verification code has been sent.');
        }
    }
}
