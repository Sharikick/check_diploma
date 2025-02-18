<?php

namespace App\Controller\Diploma;

use Core\Container\ContainerInterface;

class DiplomaController implements DiplomaControllerInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function checkPage(): void
    {
        $view = $this->container->getView();
        $view->render('check', ['title' => 'Проверка диплома']);
    }

    public function reportPage(): void
    {
        $view = $this->container->getView();
        $view->render('report', ['title' => 'Отчеты']);
    }

    public function checkDiploma(): void
    {
        $diplomaService = $this->container->getDiplomaService();
        $diplomaService->checkDiploma();
    }
}
