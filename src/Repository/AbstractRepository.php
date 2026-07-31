<?php

namespace App\Repository;

use PDO;

abstract class AbstractRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    protected function executeAll(string $query, array $params = []): array
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function executeOne(string $query, array $params = []): ?array
    {
        $statement = $this->pdo->prepare($query);
        $statement->execute($params);

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    protected function execute(string $query, array $params = []): bool
    {
        $statement = $this->pdo->prepare($query);

        return $statement->execute($params);
    }
}
