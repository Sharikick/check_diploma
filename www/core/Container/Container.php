<?php

namespace Core\Container;

use Core\Config\Config;
use Core\Config\ConfigInterface;
use Core\Http\Request\Request;
use Core\Http\Request\RequestInterface;
use Core\Session\Session;
use Core\Session\SessionInterface;
use Core\Validator\Validator;
use Core\Validator\ValidatorInterface;
use Core\View\View;
use Core\View\ViewInterface;

class Container implements ContainerInterface
{
    private ?ConfigInterface $config = null;
    private ?RequestInterface $request = null;
    private ?ViewInterface $view = null;
    private ?SessionInterface $session = null;
    private ?ValidatorInterface $validator = null;

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

    public function getSession(): SessionInterface
    {
        if ($this->session === null) {
            $this->session = new Session();
            $this->session->setOptions([
                'cookie_secure' => true,
                'cookie_httponly' => true,
                'gc_maxlifetime' => 3600
            ]);
            $this->session->start();
        }
        return $this->session;
    }


    public function getValidator(): ValidatorInterface
    {
        if ($this->validator === null) {
            $this->validator = new Validator();
        }
        return $this->validator;
    }
}
