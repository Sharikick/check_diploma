<?php

namespace Core\Container;

use Core\Config\ConfigInterface;
use Core\Database\DatabaseInterface;
use Core\Http\Request\RequestInterface;
use Core\Session\SessionInterface;
use Core\Validator\ValidatorInterface;
use Core\View\ViewInterface;

interface ContainerInterface {
    public function getConfig(): ConfigInterface;
    public function getRequest(): RequestInterface;
    public function getView(): ViewInterface;
    public function getSession(): SessionInterface;
    public function getValidator(): ValidatorInterface;
    public function getDatabase(): DatabaseInterface;
}
