<?php

namespace App\Http\Controllers\Auth {

    use App\Http\Requests\Auth\RegisterUserRequest;
    use Illuminate\Http\RedirectResponse;
    use App\Http\Controllers\Controller;
    use Inertia\Response;
    use App\Models\User;

    class UserRegistrationController extends Controller
    {
        public function index(): Response
        {
            abort_if(!$this->settings->enable_registration, 403);

            return inertia('auth/register');
        }

        public function store(RegisterUserRequest $request): RedirectResponse
        {
            abort_if(!$this->settings->enable_registration, 403);

            $user = User::create($request->validated());
            $user->assignRole(env('APP_DEFAULT_ROLE'));

            return to_route('login');
        }
    }
}
