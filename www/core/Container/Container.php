<?php

namespace Core\Container;

use Core\Config\Config;
use Core\Config\ConfigInterface;

class Container implements ContainerInterface
{
    private ?ConfigInterface $config = null;

    public function getConfig(): ConfigInterface
    {
        if ($this->config === null) {
            $this->config = new Config();
        }
        return $this->config;
    }
}
