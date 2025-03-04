<?php

use App\Http\Middleware\CheckActiveLink;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckTemporaryLink;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.temporary.link' => CheckTemporaryLink::class,
            'check.active.link' => CheckActiveLink::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
