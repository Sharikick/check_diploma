<?php

namespace App\Controller\Profile;

use Core\Container\ContainerInterface;

class ProfileController implements ProfileControllerInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function profilePage(): void
    {
        $view = $this->container->getView();
        $view->render('profile', ['title' => 'Профиль']);
    }
}
