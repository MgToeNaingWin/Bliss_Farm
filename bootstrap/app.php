<?php

use App\Http\Middleware\AdminMiddleWare;
use App\Http\Middleware\SuperAdminMiddleWare;
use App\Http\Middleware\UserMiddleWare;
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
        //declare
        $middleware->alias([
            'admin' => AdminMiddleWare::class,
            'user' => UserMiddleWare::class,
            'superadmin' => SuperAdminMiddleWare::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
