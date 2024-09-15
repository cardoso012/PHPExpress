<?php

namespace PHPExpress\Router;

use Closure;

class Route
{

    private array $params = [];
    private string $route;
    private string $method;
    private Closure $action;

    public function __construct(string $method, string $route, callable $action)
    {
        $this->setRoute($route);
        $this->setMethod($method);
        $this->setAction($action);
    }

    private function setRoute(string $route): void
    {
        $this->route = $this->parseRoute($route);
    }

    private function setMethod(string $method): void
    {
        $this->method = $method;
    }

    private function setAction(callable $action): void
    {
        $this->action = $action;
    }

    private function parseRoute(string $route): string
    {
        $patternVariables = '/{(.*?)}/';
        if(preg_match_all($patternVariables, $route, $matches)) {
            $route = preg_replace($patternVariables, '(.*?)', $route);
            $this->params = $matches[1];
        }

        return '/^'. str_replace('/', '\/', $route) . '$/';
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getAction(): Closure
    {
        return $this->action;
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function toArray(): array
    {
        return [
            'path' => $this->route,
            'method' => $this->method,
            'action' => $this->action,
        ];
    }

}