<?php

namespace Core\Container\Repository;

use App\Repository\User\UserRepositoryInterface;

interface RepositoryInterface {
    public function getUserRepository(): UserRepositoryInterface;
}
