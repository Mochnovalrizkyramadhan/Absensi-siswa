<?php

namespace App\Http\Middleware;

use App\Http\Attributes\UseMiddleware;
use Closure;
use Illuminate\Http\Request;
use ReflectionClass;
use ReflectionMethod;

class AttributeMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        $route = $request->route();

        if (! $route) {
            return $next($request);
        }

        $action = $route->getAction();
        $controller = $action['controller'] ?? null;

        if (! $controller || ! str_contains($controller, '@')) {
            return $next($request);
        }

        [$class, $method] = explode('@', $controller);
        if (! class_exists($class) || ! method_exists($class, $method)) {
            return $next($request);
        }

        $middlewares = [];

        $reflectionClass = new ReflectionClass($class);
        $classAttributes = $reflectionClass->getAttributes(UseMiddleware::class);
        foreach ($classAttributes as $attribute) {
            $middlewares[] = $attribute->newInstance()->middleware;
        }

        $reflectionMethod = new ReflectionMethod($class, $method);
        $methodAttributes = $reflectionMethod->getAttributes(UseMiddleware::class);
        foreach ($methodAttributes as $attribute) {
            $middlewares[] = $attribute->newInstance()->middleware;
        }

        if (empty($middlewares)) {
            return $next($request);
        }

        $pipeline = array_reduce(
            array_reverse($middlewares),
            fn (Closure $stack, string $middleware): Closure => static function (Request $request) use ($stack, $middleware) {
                $instance = app($middleware);
                return $instance->handle($request, $stack);
            },

        );

        return $pipeline($request);
    }
}
