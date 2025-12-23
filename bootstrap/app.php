<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// Pastikan baris ini sesuai dengan nama file middleware kamu
use App\Http\Middleware\CheckRole; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 1. INI FIX UNTUK RAILWAY (HTTPS & MOBILE)
        $middleware->trustProxies(at: '*');

        // 2. INI FIX UNTUK ERROR "TARGET CLASS ROLE DOES NOT EXIST"
        // Kita daftarkan ulang alias 'role'
        $middleware->alias([
            'role' => CheckRole::class, // <-- Pastikan class ini sesuai nama file kamu
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();