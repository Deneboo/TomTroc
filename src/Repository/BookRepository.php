<?php 

namespace App\Repository;

use PDO;
use App\Models\Book;
use App\Models\User;

class BookRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $query = "
            SELECT
                books.*,
                users.email,
                users.username,
                users.avatar
            FROM books
            INNER JOIN users
                ON books.user_id = users.id
            ORDER BY books.id DESC
        ";
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $books = [];

        foreach ($rows as $data) {
            $user = new User(
                (int) $data['user_id'],
                $data['email'],
                $data['username'],
                '',
                $data['avatar'],
                new \DateTime($data['created_at'])
            );

            $books[] = new Book(
                (int) $data['id'],
                $data['title'],
                $data['author'],
                $data['description'],
                $data['image'],
                $user
            );
        }

        return $books;
    }

    public function findById(int $id): ?Book
    {
        $query = "
            SELECT
                books.*,
                users.email,
                users.username,
                users.avatar
            FROM books
            INNER JOIN users
                ON books.user_id = users.id
            WHERE books.id = :id
        ";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);

        $data = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $user = new User(
            (int) $data['user_id'],
            $data['email'],
            $data['username'],
            '',
            $data['avatar'],
            new \DateTime($data['created_at'])
        );

        return new Book(
            (int) $data['id'],
            $data['title'],
            $data['author'],
            $data['description'],
            $data['image'],
            $user
        );
    }

    public function findByUserId(int $userId): array
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