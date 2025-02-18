<?php

namespace Core\Database;

use RuntimeException;

class Database implements DatabaseInterface
{
    private readonly \PDO $pdo;

    public function getConnection(): \PDO
    {
        return $this->pdo;
    }

    public function __construct(array $config)
    {
        $this->connect($config);
    }

    private function connect(array $config)
    {
        $host = $config["host"];
        $port = $config["port"];
        $db = $config["db"];
        $user = $config["user"];
        $password = $config["password"];

        $dns = "pgsql:host=$host;port=$port;dbname=$db;";
        $opt = [
                    // Для обработки исключений
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    // Возвращает результат запроса в виде ассоциативного массива, где ключами являются имена столбцов.
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    // Для чего-то
                    \PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $this->pdo = new \PDO($dns, $user, $password, $opt);
        } catch (\PDOException $e) {
            throw new RuntimeException("Не удалось подключиться к базе данных", 500, $e);
        }
    }

    public function disconnect(): void
    {
        $this->pdo = null;
    }

}
