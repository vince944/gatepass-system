<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (InvalidSignatureException $e, Request $request) {
            if (! $request->is('complete-registration/*')) {
                return null;
            }

            return response()->view('auth.complete-registration', [
                'invalidLink' => true,
                'user' => null,
                'employee' => null,
            ], Response::HTTP_FORBIDDEN);
        });
    })->create();
