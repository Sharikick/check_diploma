<?php

namespace Core\Session;

interface SessionInterface {
    public function start(): void;
    public function getFlash(string $key, $default = null);
    public function get(string $key, $default = null);
    public function set(string $key, $value): void;
    public function has(string $key): bool;
    public function remove(string $key): void;
    public function destroy(): void;
    public function setOptions(array $options): void;
}
