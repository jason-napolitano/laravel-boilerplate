<?php

namespace App\Http\Middleware {

    use Symfony\Component\HttpFoundation\Response;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Http\Request;
    use Closure;

    class EnsureUserIsNotBanned
    {
        public function handle(Request $request, Closure $next): Response
        {
            // Allow the login action to run first
            $user = Auth::user();

            // Check if $users is banned
            if ($user && $user['is_banned']) {
                // if the $user is banned, log them out
                logout_action();

                // redirect to the login page with the banned error message
                return redirect()->route('login')->withErrors([
                    'email' => 'Your account has been banned.',
                ]);
            }
            return $next($request);
        }
    }
}
