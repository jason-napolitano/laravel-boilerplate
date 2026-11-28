<?php

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Carbon\Carbon;

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

if (! function_exists('yearly_data')) {
    /**
     * Get `per year` data for a model based on a specified database
     * column for that model
     *
     * @param string $field
     * @param string $model
     *
     * @return Collection
     */
    function yearly_data(string $field, string $model): Collection {
        $data = $model::query()
            ->whereBetween($field, [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear(),
            ])
            ->get([$field])
            ->groupBy(
                fn ($model) => Carbon::parse($model->getRawOriginal($field))->format('n')
            );

        $collection = collect();

        for ($month = 1; $month <= 12; $month++) {
            $collection->push([
                'month' => Carbon::create(Carbon::now()->year, $month, 1)->format('F'),
                'total' => $data->get((string) $month, collect())->count(),
            ]);
        }

        return $collection;
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
