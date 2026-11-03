<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

Route::middleware(['auth', 'verified'])->group(function () {
    // ------------------------------------------------------------------------
    // dashboard
    Route::prefix('dashboard')->middleware('can:view_dashboard')->group(function () {
        // -------------------------------------
        // dashboard routes
        Route::get('', Controllers\DashboardController::class)
            ->name('dashboard');

        // -------------------------------------
        // users
        Route::resource('users', Controllers\UserController::class);

        Route::prefix('users')->group(function () {
            Route::delete('{user}/image', [Controllers\UserController::class, 'destroyImage'])
                ->name('users.image.destroy');

            Route::post('{user}/image', [Controllers\UserController::class, 'updateImage'])
                ->name('users.image');

            Route::post('{user}/ban', [Controllers\UserController::class, 'toggleBan'])
                ->name('users.ban');

            Route::patch('{user}/role', [Controllers\UserController::class, 'updateRole'])
                ->name('users.role.update');
        });

        // ------------------------------------------------------------------------
        // roles
        Route::prefix('roles')->group(function () {
            Route::get('', [Controllers\RoleController::class, 'index'])
                ->name('roles.index');

            Route::post('{role}/add-permission', [Controllers\RoleController::class, 'addPermission'])
                ->name('roles.add-permission');

            Route::post('', [Controllers\RoleController::class, 'store'])
                ->name('roles.store');

            Route::delete('{role}', [Controllers\RoleController::class, 'destroy'])
                ->name('roles.destroy');
        });

        // ------------------------------------------------------------------------
        // permissions
        Route::prefix('permissions')->group(function () {
            Route::post('', [Controllers\PermissionController::class, 'store'])
                ->name('permissions.store');
        });

        // ------------------------------------------------------------------------
        // settings
        Route::prefix('settings')->group(function () {
            Route::get('', [Controllers\SettingsController::class, 'index'])
                ->name('settings.index');

            Route::patch('', [Controllers\SettingsController::class, 'update'])
                ->name('settings.update');

            Route::post('{setting}/update-logo', [Controllers\SettingsController::class, 'updateImage'])
                ->name('settings.update-logo');
        });
    });

    // ------------------------------------------------------------------------
    // logout
    Route::post('logout', [Controllers\Auth\AuthenticationController::class, 'destroy'])
        ->name('logout');
});
