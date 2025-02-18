<?php

namespace Core\Container;

use Core\Config\ConfigInterface;
use Core\Http\Request\RequestInterface;

interface ContainerInterface {
    public function getConfig(): ConfigInterface;
    public function getRequest(): RequestInterface;
}
