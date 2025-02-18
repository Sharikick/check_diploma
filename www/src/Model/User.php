<?php

namespace App\Model;

class User
{
    public function __construct(
        private readonly int $id,
        private readonly ?string $name,
        private readonly ?string $surname,
        private readonly ?string $patronymic,
        private readonly string $email,
        private readonly string $password,
        private readonly int $roleId
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "surname" => $this->surname,
            "patronymic" => $this->patronymic,
            "email" => $this->email,
            "password" => $this->password,
            "role_id" => $this->roleId
        ];
    }
}
