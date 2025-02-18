<?php

namespace App\Service\Auth;

interface AuthServiceInterface {
    public function registerUser(): void;
    public function authenticateUser(): void;
    public function check(): bool;
}
