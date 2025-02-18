<?php

namespace App\Controller\Auth;

use Core\Container\ContainerInterface;

class AuthController implements AuthControllerInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {}

    public function loginPage(): void
    {
        $view = $this->container->getView();
        $view->render('login', ['title' => 'Авторизация']);
    }

    public function registerPage(): void
    {
        $view = $this->container->getView();
        $view->render('register', ['title' => 'Регистрация']);
    }

    public function registerUser(): void
    {
        $authService = $this->container->getAuthService();
        $authService->registerUser();
    }

    public function authenticateUser(): void
    {
        $authService = $this->container->getAuthService();
        $authService->authenticateUser();
    }
}
