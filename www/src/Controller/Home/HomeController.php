<?php

namespace App\Controller\Home;

use Core\Container\ContainerInterface;

class HomeController implements HomeControllerInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function homePage(): void
    {
        $view = $this->container->getView();
        $view->render("home", ['title' => 'Home']);
    }
}
