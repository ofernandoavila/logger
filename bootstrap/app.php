<?php

use App\Exceptions\AccessUnauthorizedException;
use App\Exceptions\RequestValidationFailedException;
use App\Http\Middleware\ValidateRequest;
use App\Http\Response;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__ . '/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([ ValidateRequest::class ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (RequestValidationFailedException $ex, Request $request) {
            return Response::send_response($ex->getMessage(), json_decode(json_encode($ex->options['data']), true), 500, true);
        });
        
        $exceptions->render(function (AccessUnauthorizedException $ex, Request $request) {
            return Response::send_response($ex->getMessage(), $ex->errors, 401, true);
        });
        
        $exceptions->render(function (Exception $ex, Request $request) {
            return Response::send_response($ex->getMessage(), [], 406, true);
        });
    })->create();
