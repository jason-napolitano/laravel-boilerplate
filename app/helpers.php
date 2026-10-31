<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

// --------------------------------------------------
// if the function doesn't exist, let's create it!
if (!function_exists('user')) {
    /**
     * Shorthand for auth()->user()
     *
     * @return Authenticatable|null
     */
    function user(): ?Authenticatable
    {
        return auth()->user();
    }
}

// --------------------------------------------------
// if the function doesn't exist, let's create it!
if (!function_exists('logout_action')) {
    /**
     * Logout action
     *
     * @param ?callable $callable
     *
     * @return void
     */
    function logout_action(?callable $callable = null): void
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        if ($callable) {
            $callable();
        }
    }
}
