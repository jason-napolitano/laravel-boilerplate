<?php

namespace App\Http\Controllers\Auth {

    use App\Http\Requests\Auth\PasswordResetRequest;
    use Illuminate\Auth\Events\PasswordReset;
    use Illuminate\Support\Facades\Password;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Hash;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Inertia\Response;
    use App\Models\User;

    class ResetPasswordController extends Controller
    {
        public function edit(Request $request, string $token): Response
        {
            abort_if(!$this->settings->enable_reset_password, 403);

            return inertia('auth/reset-password', [
                'email' => $request->query('email', ''),
                'token' => $token,
            ]);
        }

        public function update(PasswordResetRequest $request): RedirectResponse
        {
            abort_if(!$this->settings->enable_reset_password, 403);

            $request->validated();

            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                static function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return to_route('login')->with('status', $status);
            }

            return back()->withErrors([
                'email' => $status,
            ]);
        }
    }
}
