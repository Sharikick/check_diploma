<?php

namespace Core\Container\Service;

use App\Service\Auth\AuthService;
use App\Service\Auth\AuthServiceInterface;
use App\Service\Diploma\DiplomaService;
use App\Service\Diploma\DiplomaServiceInterface;

trait Service
{
    private ?AuthServiceInterface $authService = null;
    private ?DiplomaServiceInterface $diplomaService = null;

    public function getAuthService(): AuthServiceInterface
    {
        if ($this->authService === null) {
            $this->authService = new AuthService($this);
        }
        return $this->authService;
    }

    public function getDiplomaService(): DiplomaServiceInterface
    {
        if ($this->diplomaService === null) {
            $this->diplomaService = new DiplomaService($this);
        }
        return $this->diplomaService;
    }
}
