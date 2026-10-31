<?php

use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use App\Http\Middleware\EnsureUserIsNotBanned;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Configuration;
use Illuminate\Foundation\Application;
use Inertia\ExceptionResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__ . '/../routes/verified.php',
            __DIR__ . '/../routes/guest.php',
            __DIR__ . '/../routes/web.php',
        ],
        api: [
            __DIR__ . '/../routes/api.php',
        ]
    )
    ->withMiddleware(function (Configuration\Middleware $middleware): void {
        // cookie encryption
        $middleware->encryptCookies();

        // sanctum's frontend middleware
        $middleware->statefulApi();

        // web middleware
        $middleware->web(
            append: [
                AddLinkHeadersForPreloadedAssets::class,
                HandleInertiaRequests::class,
                EnsureUserIsNotBanned::class,
            ]
        );
    })
    ->withExceptions(function (Configuration\Exceptions $exceptions): void {
        // inertia exception handling
        Inertia::handleExceptionsUsing(callback: static function (ExceptionResponse $response) {
            $codes = [403, 404, 419, 500, 503];
            if (in_array($response->statusCode(), $codes, true)) {
                return $response->render('error', [
                    'status' => $response->statusCode(),
                ])->withSharedData();
            }
        });

        // API exception handling
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
