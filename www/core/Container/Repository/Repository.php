<?php

namespace Core\Container\Repository;

use App\Repository\User\UserRepository;
use App\Repository\User\UserRepositoryInterface;

trait Repository  {
    private ?UserRepositoryInterface $userRepository = null;

    public function getUserRepository(): UserRepositoryInterface {
        if ($this->userRepository === null) {
            $this->userRepository = new UserRepository($this);
        }

        return $this->userRepository;
    }
}
