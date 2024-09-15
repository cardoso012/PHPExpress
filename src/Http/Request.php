<?php

namespace PHPExpress\Http;

class Request
{

    private string $httpMethod;

    private string $uri;

    private array $query;

    private array $body;

    private array $params = [];

    private array $headers;

    public function __construct()
    {
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        $this->headers = getallheaders() ?? [];
        $this->query = $_GET ?? [];
        $this->body = $_POST ?? [];
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function __get(string $name)
    {
        return $this->{$name};
    }
}