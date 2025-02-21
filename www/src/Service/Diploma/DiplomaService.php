<?php

namespace App\Service\Diploma;

use Core\Container\ContainerInterface;

class DiplomaService implements DiplomaServiceInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function checkDiploma(): void
    {
        $docx = $this->container->getDocx();
        $docx->validate();
    }
}
