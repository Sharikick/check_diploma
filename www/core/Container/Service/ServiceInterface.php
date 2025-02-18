<?php

namespace Core\Container\Service;

use App\Service\Auth\AuthServiceInterface;

interface ServiceInterface {
    public function getAuthService(): AuthServiceInterface;
}
