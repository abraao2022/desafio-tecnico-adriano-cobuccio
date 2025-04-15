<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
// use App\Http\Middleware\UserIsAdmin;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        api: __DIR__.'/../routes/api.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(UserIsAdmin::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'message' => 'Os dados fornecidos são inválidos.',
                'errors' => $e->errors(),
            ], 422);
        });
    })
    ->withProviders([
        App\Providers\RouteServiceProvider::class,
    ])
    ->create();
