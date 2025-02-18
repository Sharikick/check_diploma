<?php

namespace Core\Container\Service;

use App\Service\Auth\AuthService;
use App\Service\Auth\AuthServiceInterface;

trait Service {
    private ?AuthServiceInterface $authService = null;

    public function getAuthService(): AuthServiceInterface {
        if ($this->authService === null) {
            $this->authService = new AuthService($this);
        }

        return $this->authService;
    }
}
