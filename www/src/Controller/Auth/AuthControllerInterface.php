<?php

namespace App\Controller\Auth;

interface AuthControllerInterface {
    public function loginPage(): void;
    public function registerPage(): void;
    public function registerUser(): void;
    public function authenticateUser(): void;
}
