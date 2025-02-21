<?php

namespace Core\Container\Service;

use App\Service\Auth\AuthServiceInterface;
use App\Service\Diploma\DiplomaServiceInterface;

interface ServiceInterface
{
    public function getAuthService(): AuthServiceInterface;
    public function getDiplomaService(): DiplomaServiceInterface;
}
