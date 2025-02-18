<?php

namespace Core\Container;

use Core\Config\Config;
use Core\Config\ConfigInterface;
use Core\Http\Request\Request;
use Core\Http\Request\RequestInterface;
use Core\View\View;
use Core\View\ViewInterface;

class Container implements ContainerInterface
{
    private ?ConfigInterface $config = null;
    private ?RequestInterface $request = null;
    private ?ViewInterface $view = null;

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

    public function getView(): ViewInterface
    {
        if ($this->view === null) {
            $this->view = new View($this);
        }
        return $this->view;
    }
}
