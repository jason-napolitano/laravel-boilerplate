<?php

namespace App\Http\Controllers\Auth {

    use Illuminate\Support\Facades\Password;
    use Illuminate\Http\RedirectResponse;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Inertia\Response;

    class ForgotPasswordController extends Controller
    {
        public function create(): Response
        {
            abort_if(!$this->settings->enable_reset_password, 403);

            return inertia('auth/forgot-password');
        }

        public function store(Request $request): RedirectResponse
        {
            abort_if(!$this->settings->enable_reset_password, 403);

            $request->validate([
                'email' => ['required', 'email', 'exists:users,email'],
            ]);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return back()->with('status', $status);
            }

            return back()->withErrors([
                'email' => $status,
            ]);
        }
    }
}
