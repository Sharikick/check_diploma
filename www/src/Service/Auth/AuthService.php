<?php

namespace App\Service\Auth;

use Core\Container\ContainerInterface;
use Core\Http\Redirect\Redirect;

class AuthService implements AuthServiceInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function registerUser(): void
    {
        $request = $this->container->getRequest();
        $validator = $this->container->getValidator();
        $session = $this->container->getSession();
        $userRepository = $this->container->getUserRepository();

        $data = [
            "email" => $request->input("email"),
            "password" => $request->input("password"),
        ];

        if (!$validator->validate(
            $data,
            [
                "password" => ["required", "min:4", "max:40"],
                "email" => ["required", "email"]
            ]
        )) {
            $session->set("errors", $validator->getErrors());
            Redirect::to('/register');
        }

        $data["role"] = $request->input("role");
        $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);

        $userRepository->save($data);
        Redirect::to('/login');
    }

    public function check(): bool {
        $session = $this->container->getSession();
        return $session->has("auth");
    }

    public function authenticateUser(): void
    {
        $request = $this->container->getRequest();
        $validator = $this->container->getValidator();
        $session = $this->container->getSession();
        $userRepository = $this->container->getUserRepository();

        $data = [
            "email" => $request->input("email"),
            "password" => $request->input("password")
        ];

        if (!$validator->validate(
            $data,
            [
                "password" => ["required", "min:4", "max:40"],
                "email" => ["required", "email"]
            ]
        )) {
            $session->set("errors", $validator->getErrors());
            Redirect::to('/login');
        }

        $user = $userRepository->getByEmail($data["email"]);

        if (!$user || !password_verify($data["password"], $user->getPassword())) {
            $session->set("unauthorized", "Неправильный email или пароль");
            Redirect::to("/login");
        }

        $session->set("auth", $user->getId());
        Redirect::to("/");
    }
}
