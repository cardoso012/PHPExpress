<?php

namespace PHPExpress\Router;

class Routes
{
    private array $routes = [];

    public function addRoute(Route $route): void
    {
        $this->routes[$route->getRoute()][$route->getMethod()] = $route;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

}