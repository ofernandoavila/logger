<?php

use App\Exceptions\Exception;
use App\Http\Middleware\JWTAuthMiddleware;
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
        $middleware->append([ 'jwt.auth' => JWTAuthMiddleware::class ]);
        $middleware->append([ ValidateRequest::class ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {                
        if(boolval(env('APP_DEBUG'))) {
            $exceptions->render(function (Exception $ex, Request $request) {
                return Response::send_response($ex->getMessage(), $ex->to_response(), $ex->getCode(), true);
            });
        }

        $exceptions->render(function (Exception $ex, Request $request) {
            return Response::send_response($ex->getMessage(), $ex->params, $ex->getCode(), true);
        });
    })->create();
