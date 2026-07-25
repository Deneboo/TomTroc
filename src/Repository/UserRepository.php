<?php 

namespace App\Repository;

use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findBooksByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                books.*,
                users.username,
                users.email,
                user.avatar
            FROM books
            INNER JOIN users
                ON books.user_id = users.id
            WHERE users.id = :user_id
            ORDER BY books.created_at DESC
        ");

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}