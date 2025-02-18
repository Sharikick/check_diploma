<?php

namespace Core\Http\Request;

class Request implements RequestInterface
{
    private readonly string $method;
    private readonly string $uri;
    private readonly array $query;
    private readonly array $body;

    public function __construct()
    {
        $this->method = strtoupper($_SERVER["REQUEST_METHOD"] ?? "GET");
        $this->uri = strtok($_SERVER["REQUEST_URI"], '?');
        $this->query = $_GET ?? [];
        $this->body = [
            "data" => $_POST,
            "files" => $_FILES
        ];
    }

    public function input(string $key): mixed
    {
        return $this->body["data"][$key] ?? null;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getFile(string $name): ?array {
        return $this->body["files"][$name] ?? null;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getQuery(): array
    {
        return $this->query;
    }
}
