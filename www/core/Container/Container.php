<?php

namespace Core\Container;

use Core\Config\Config;
use Core\Config\ConfigInterface;
use Core\Http\Request\Request;
use Core\Http\Request\RequestInterface;

class Container implements ContainerInterface
{
    private ?ConfigInterface $config = null;
    private ?RequestInterface $request = null;

    public function getConfig(): ConfigInterface
    {
        if ($this->config === null) {
            $this->config = new Config();
        }
        return $this->config;
    }

    public function getRequest(): RequestInterface
    {
        if ($this->request === null) {
            $this->request = new Request();
        }
        return $this->request;
    }
}
