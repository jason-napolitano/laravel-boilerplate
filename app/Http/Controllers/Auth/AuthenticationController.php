<?php

namespace App\Http\Controllers\Auth {

    use App\Http\Requests\Auth\MemberLoginRequest;
    use Illuminate\Http\RedirectResponse;
    use App\Http\Controllers\Controller;
    use Inertia\Response;

    class AuthenticationController extends Controller
    {
        public function index(): Response
        {
            return inertia('auth/login');
        }

        public function store(MemberLoginRequest $request): RedirectResponse
        {
            $request->authenticate();
            $request->session()->regenerate();

            $user = $request->user();

            return to_route('users.show', $user);
        }

        public function destroy(): RedirectResponse
        {
            logout_action();
            return to_route('login');
        }
    }
}
