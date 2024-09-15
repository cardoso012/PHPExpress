<?php

namespace PHPExpress\Http;

class Response
{

    private int $statusCode;

    private array $headers = [];

    private string $contentType;

    public function __construct($statusCode = 200, $contentType = 'application/json')
    {
        $this->statusCode = $statusCode;
        $this->setContentType($contentType);
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $this->contentType);
    }

    public function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public function __get(string $name)
    {
        return $this->{$name};
    }

    private function sendHeaders(): void
    {
        foreach($this->headers as $key => $value) {
            header("{$key}: {$value}");
        }
    }

    private function sendStatusCode(): void
    {
        http_response_code($this->statusCode);
    }

    private function sendContentAsJson(array $data): void
    {
        echo json_encode($data);
    }

    public function json(array $data): void
    {
        $this->sendStatusCode();
        $this->sendHeaders();
        $this->sendContentAsJson($data);
    }

    public function noContent(): void
    {
        $this->sendStatusCode();
        $this->sendHeaders();
    }

}