<?php

namespace Core\Http\Request;

interface RequestInterface {
    public function input(string $key): mixed;
    public function getUri(): string;
    public function getFile(string $name): ?array;
    public function getMethod(): string;
    public function getQuery(): array;
}
