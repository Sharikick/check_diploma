<?php

namespace Core\Database;

interface DatabaseInterface {
    public function getConnection(): \PDO;
    public function disconnect(): void;
}
