<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Giữ redirect mặc định cho middleware auth/guest của Laravel nếu nơi khác còn dùng.
        $middleware->redirectGuestsTo('/staff/login');
        $middleware->redirectUsersTo('/staff');

        // Cho phép Telegram gọi webhook mà không cần CSRF token.
        $middleware->validateCsrfTokens(except: [
            'telegram/webhook',
        ]);

        // Alias jwt.auth bảo vệ staff area bằng JWT cookie access_token.
        $middleware->alias([
            'jwt.auth' => \App\Http\Middleware\JwtAuthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
