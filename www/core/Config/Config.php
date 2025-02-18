<?php

namespace Core\Config;

class Config implements ConfigInterface
{
    private array $configs;

    public function __construct()
    {
        $this->initConfig();
    }

    private function initConfig()
    {
        $this->configs = [];
        $pattern = APP_PATH . "/config/*.php";

        $files = glob($pattern);
        if ($files === false) {
            throw new \Exception("Ошибка инициализации конфига");
        }

        foreach ($files as $path) {
            $file = basename($path, ".php");
            $this->configs[$file] = require $path;
        }

    }

    public function get(string $key): array
    {
        return $this->configs[$key];
    }
}
