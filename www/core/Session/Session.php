<?php

namespace Core\Session;

class Session implements SessionInterface
{
    public function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set(string $key, $value): void
    {
        $this->start();
        $_SESSION[$key] = $value;
    }

    public function get(string $key, $default = null)
    {
        $this->start();
        return $this->has($key) ? $_SESSION[$key] : $default;
    }

    public function getFlash(string $key, $default = null)
    {
        $this->start();
        $value = $this->get($key, $default);
        $this->remove($key);
        return $value;
    }

    public function has(string $key): bool
    {
        $this->start();
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        $this->start();
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function destroy(): void
    {
        $this->start();
        session_unset();
        session_destroy();
    }

    public function setOptions(array $options): void
    {
        foreach($options as $key => $value) {
            ini_set("session.$key", $value);
        }
    }
}
