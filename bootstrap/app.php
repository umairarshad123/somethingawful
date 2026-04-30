<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Unauthenticated visitors hitting "auth" middleware get redirected:
        //  - admin URLs → bespoke admin sign-in
        //  - everything else → customer sign-in
        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            return str_starts_with($request->path(), 'thebestadmin')
                ? route('admin.login')
                : route('auth.show');
        });

        // Register middleware aliases.
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureAdmin::class,
        ]);

        // Bounce admins back to the admin panel from anywhere on the
        // public site. Runs after session/auth so $request->user() is
        // populated by the time we make the call.
        $middleware->web(append: [
            \App\Http\Middleware\RedirectAdminToPanel::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
