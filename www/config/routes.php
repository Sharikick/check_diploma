<?php

use App\Controller\Auth\AuthController;
use App\Controller\Diploma\DiplomaController;
use App\Controller\Home\HomeController;
use App\Controller\Profile\ProfileController;

return [
    "GET" => [
        '/' => [HomeController::class, 'homePage'],
        '/register' => [AuthController::class, 'registerPage'],
        '/login' => [AuthController::class, 'loginPage'],
        '/profile' => [ProfileController::class, 'profilePage'],
        '/report' => [DiplomaController::class, 'reportPage'],
        '/check' => [DiplomaController::class, 'checkPage']
    ],
    "POST" => []
];
