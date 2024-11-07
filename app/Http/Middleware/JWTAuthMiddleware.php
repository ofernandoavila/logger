<?php

namespace App\Http\Middleware;

use App\Exceptions\AccessUnauthorizedException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (request()->expectsJson() && !$this->isAuthenticated()) {
            throw new AccessUnauthorizedException(["You must give an authorization code to access this resource."]);
        }

        return $next($request);
    }

    public function isAuthenticated() {
        $token = JWTAuth::getToken();

        return $token;
    }
}
