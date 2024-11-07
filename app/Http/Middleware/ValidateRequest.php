<?php

namespace App\Http\Middleware;

use App\Annotations\ValidateRequest as AnnotationsValidateRequest;
use App\Exceptions\RequestValidationFailedException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\Response;

class ValidateRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = Route::getRoutes()->match($request);
        $config = [
            'controller' => $route->getController(),
            'action' => $route->getActionMethod(),
        ];

        
        if(!is_null($config['controller']) && class_exists($config['controller']::class)) {
            $config['reflectionMethod'] = new ReflectionMethod($config['controller'], $config['action']);
            $config['attributes'] = $config['reflectionMethod']->getAttributes(AnnotationsValidateRequest::class);
            
            foreach($config['attributes'] as $attribute)
            {
                $validator = $attribute->newInstance();
                
                $controller = $validator->controller;
                $action = $validator->action;
                
                if ($_SERVER['REQUEST_METHOD'] === "POST" && method_exists($controller, $action)) {
                    $controller::$action($request);
                }
            }
        }

        return $next($request);
    }
}
