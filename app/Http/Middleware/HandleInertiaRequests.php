<?php

namespace App\Http\Middleware {

    use App\Services\SettingsService;
    use Illuminate\Http\Request;
    use Inertia\Middleware;

    class HandleInertiaRequests extends Middleware
    {
        public function version(Request $request): ?string
        {
            return parent::version($request);
        }

        public function share(Request $request): array
        {
            return [
                ...parent::share($request),
                'auth' => [
                    'permissions' => fn () => $request->user()
                        ? $request->user()->getPermissionsViaRoles()
                        : [],
                    'user' => fn () => $request->user()
                        ? $request->user()->only('id', 'name', 'email')
                        : null,
                ],
                'settings' => fn () => app(SettingsService::class),
            ];
        }
    }
}
