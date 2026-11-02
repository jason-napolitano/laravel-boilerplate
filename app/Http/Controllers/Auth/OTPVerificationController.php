<?php

namespace App\Http\Controllers\Auth {

    use App\Models\Setting;
    use Illuminate\Validation\ValidationException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\Controller;
    use App\Services\Auth\OTPService;
    use Illuminate\Http\Request;
    use Inertia\Response;
    use Inertia\Inertia;

    class OTPVerificationController extends Controller
    {
        public function __construct(protected OTPService $otp)
        {
            logger()->info('AuthenticateWithEmailOtp executed.');
            parent::__construct();
        }

        public function create(Request $request): Response|RedirectResponse
        {
            if (! $request->session()->has('auth.otp.challenge')) {
                return redirect()->route('login');
            }

            return inertia('auth/otp/verify');
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

            if (! $challenge) {
                return redirect()->route('login');
            }

            $user = $this->otp->verify($challenge, $request->input('code'));

            if (! $user) {
                throw ValidationException::withMessages([
                    'code' => 'The verification code is invalid or has expired.',
                ]);
            }

            $remember = $request->session()->get('auth.otp.remember', false);

            // Remove the completed challenge.
            $this->otp->invalidate($challenge);

            $request->session()->forget([
                'auth.otp.challenge',
                'auth.otp.remember',
            ]);

            // Authenticate only after successful OTP verification.
            Auth::guard(config('fortify.guard'))->login($user, $remember);

            $request->session()->regenerate();

            return redirect()->intended(config('fortify.home'));
        }
    }
}
