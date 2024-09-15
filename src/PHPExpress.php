<?php

namespace PHPExpress;

use PHPExpress\Router\Router;

class PHPExpress
{

    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function get(string $uri, callable $callback): void
    {
        $this->router->get($uri, $callback);
    }

    public function post(string $uri, callable $callback): void
    {
        $this->router->post($uri, $callback);
    }

    public function put(string $uri, callable $callback): void
    {
        $this->router->put($uri, $callback);
    }

    public function delete(string $uri, callable $callback): void
    {
        $this->router->delete($uri, $callback);
    }

    public function addMiddleware(string $name, string $className): void
    {
        $this->router->addMiddleware($name, $className);
    }

    public function run(): void
    {
        $this->router->run();
    }

}