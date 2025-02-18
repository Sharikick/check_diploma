<?php

namespace App\Repository\User;

use App\Model\User;

interface UserRepositoryInterface {
    public function save(array $data): void;
    public function getByEmail(string $email): ?User;
}
