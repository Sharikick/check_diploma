<?php

namespace Core\Container;

use Core\Config\ConfigInterface;
use Core\Http\Request\RequestInterface;
use Core\View\ViewInterface;

interface ContainerInterface {
    public function getConfig(): ConfigInterface;
    public function getRequest(): RequestInterface;
    public function getView(): ViewInterface;
}
