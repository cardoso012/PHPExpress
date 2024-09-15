<?php

namespace PHPExpress\Middlewares;

use PHPExpress\Http\Request;

class MiddlewareQueue
{
    private array $middlewares = [];

    public function addMiddleware(string $name, string $className): void
    {
        $this->middlewares[$name] = $className;
    }

    public function next(Request $request)
    {
        if(empty($this->middlewares)) return;

        $middleware = array_shift($this->middlewares);
        $queue = $this;
        $next = function($request) use ($queue) {
            $queue->next($request);
        };

        return (new $middleware)->handle($request, $next);
    }
}