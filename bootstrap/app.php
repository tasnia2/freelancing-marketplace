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
        // Only add your custom middleware - Laravel handles the defaults
        $middleware->alias([
            // Custom middleware
            'client' => \App\Http\Middleware\ClientMiddleware::class,
            'freelancer' => \App\Http\Middleware\FreelancerMiddleware::class,
        ]);
        
        // If you want to see what's already registered, you can add:
        // $middleware->web(append: []);
        // $middleware->api(append: []);
        // $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
