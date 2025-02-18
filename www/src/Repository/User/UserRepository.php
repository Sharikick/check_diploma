<?php

namespace App\Repository\User;

use App\Model\User;
use Core\Container\ContainerInterface;
use RuntimeException;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    public function save(array $data): void
    {
        $db = $this->container->getDatabase();
        $sql = "
            INSERT INTO users (email, password, role_id)
            SELECT :email, :password, id
            FROM roles
            WHERE role = :role
        ";
        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute([
                ":email" => $data['email'],
                ":password" => $data['password'],
                ":role" => $data['role']
            ]);
        } catch(\PDOException $e) {
            throw new RuntimeException("Ошибка базы данных в методе save", 500, $e);
        }
    }

    public function getByEmail(string $email): ?User
    {
        $db = $this->container->getDatabase();
        $sql = "SELECT * FROM users WHERE email = :email";
        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute([":email" => $email]);
            $result = $stmt->fetch();

            if (!$result) {
                return null;
            }

            return new User(
                $result['id'],
                $result['name'],
                $result['surname'],
                $result['patronymic'],
                $result['email'],
                $result['password'],
                $result['role_id']
            );
        } catch (\PDOException $e) {
            throw new RuntimeException("Ошибка базы данных в методе getByEmail", 500, $e);
        }
    }

    public function getById(int $id): ?User
    {
        $db = $this->container->getDatabase();
        $sql = "SELECT * FROM users WHERE id = :id";
        try {
            $stmt = $db->getConnection()->prepare($sql);
            $stmt->execute([":id" => $id]);
            $result = $stmt->fetch();

            if (!$result) {
                return null;
            }

            return new User(
                $result['id'],
                $result['name'],
                $result['surname'],
                $result['patronymic'],
                $result['email'],
                $result['password'],
                $result['role_id']
            );

        } catch(\PDOException $e) {
            throw new RuntimeException("Ошибка базы данных в методе getById", 500, $e);
        }
    }
}
