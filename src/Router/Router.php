<?php

namespace PHPExpress\Router;

use Exception;
use PHPExpress\Exceptions\MethodNotAllowedException;
use PHPExpress\Exceptions\NotFoundException;
use PHPExpress\Http\Request;
use PHPExpress\Http\Response;
use PHPExpress\Middlewares\MiddlewareQueue;

class Router
{

    private Request $request;
    private Response $response;

    private Routes $routes;

    private MiddlewareQueue $middlewareQueue;

    public function __construct()
    {
        $this->middlewareQueue = new MiddlewareQueue();
        $this->routes = new Routes();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function addRoute(string $method, string $route, callable $callback): void
    {
        $newRoute = new Route($method, $route, fn () => $callback($this->request, $this->response));
        $this->request->setParams($newRoute->getParams());

        $this->routes->addRoute($newRoute);
    }

    private function getRoute()
    {
        $uri = $this->request->uri;
        $httpMethod = $this->request->httpMethod;

        foreach($this->routes->getRoutes() as $patternRoute => $methods) {
            if(!preg_match($patternRoute, $uri, $matches)) continue;

            $route = $methods[$httpMethod];

            if(is_null($route)) throw new MethodNotAllowedException();

            unset($matches[0]);
            $keys = $this->request->params;
            $this->request->setParams(array_combine($keys, $matches));

            return $route;
        }

        throw new NotFoundException();
    }

    public function addMiddleware(string $name, string $className): void
    {
        $this->middlewareQueue->addMiddleware($name, $className);
    }
    
    public function get(string $route, callable $callback): void
    {
        $this->addRoute('GET', $route, $callback);
    }

    public function post(string $route, callable $callback): void
    {
        $this->addRoute('POST', $route, $callback);
    }

    public function put(string $route, callable $callback): void
    {
        $this->addRoute('PUT', $route, $callback);
    }

    public function delete(string $route, callable $callback): void
    {
        $this->addRoute('DELETE', $route, $callback);
    }

    public function run()
    {
        try {
            $route = $this->getRoute();

            $this->middlewareQueue->next($this->request);

            return call_user_func($route->getAction());
        }catch (Exception $e) {
            $response = new Response($e->getCode());
            $response->noContent();
        }
    }

}