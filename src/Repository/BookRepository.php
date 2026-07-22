<?php 

namespace App\Repository;

use PDO;

class BookRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
 
    public function findFourLatest(): array
    {
        $query = $this->pdo->query("
            SELECT
                books.*,
                users.username
            FROM books
            INNER JOIN users
                ON books.user_id = users.id
            ORDER BY books.created_at DESC
            LIMIT 4
        ");

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAll(): array
    {
        $query = $this->pdo->query("
            SELECT
                books.*,
                users.username
            FROM books
            INNER JOIN users
                ON books.user_id = users.id
            ORDER BY books.created_at DESC
        ");

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findBookById(int $id): ?array
    {
        $query = $this->pdo->prepare("
            SELECT
                books.*,
                users.username
            FROM books
            INNER JOIN users
                ON books.user_id = users.id
            WHERE books.id = :id
        ");

        $query->execute([
            'id' => $id
        ]);

        $book = $query->fetch(PDO::FETCH_ASSOC);

        return $book ?: null;
    }

    public function findBooksByUserId(int $userId): array
    {
        $query = $this->pdo->prepare("
            SELECT
                books.*,
                users.username,
                users.email
            FROM books
            INNER JOIN users
                ON books.user_id = users.id
            WHERE users.id = :user_id
            ORDER BY books.created_at DESC
        ");

        $query->execute([
            'user_id' => $userId
        ]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}