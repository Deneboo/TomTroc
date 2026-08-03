<?php

namespace App\Repository;

use App\Repository\AbstractRepository;
use App\Models\Book;
use App\Models\User;

class BookRepository extends AbstractRepository
{
    public function findAll(): array
    {
        $query = "
            SELECT
                books.*,
                users.username,
                users.email,
                users.avatar
            FROM books
            INNER JOIN users
                ON books.user_id = users.id
            ORDER BY books.created_at DESC
        ";

        $rows = $this->executeAll($query);

        $books = [];

        foreach ($rows as $data) {
            $user = new User(
                (int) $data['user_id'],
                $data['username'],
                $data['email'],
                '',
                $data['avatar'],
                new \DateTime($data['created_at']),
            );

            $books[] = new Book(
                (int) $data['id'],
                $data['title'],
                $data['author'],
                $data['description'],
                $data['image'],
                new \DateTime($data['created_at']),
                $user,
            );
        }

        return $books;
    }

    public function findById(int $id): ?Book
    {
        $query = "
            SELECT
                books.*,
                users.username,
                users.email,
                users.avatar
            FROM books
            INNER JOIN users
                ON books.user_id = users.id
            WHERE books.id = :id
        ";
        $data = $this->executeOne($query, [
            'id' => $id,
        ]);

        if (!$data) {
            return null;
        }

        $user = new User(
            (int) $data['user_id'],
            $data['username'],
            $data['email'],
            '',
            $data['avatar'],
            new \DateTime($data['created_at']),
        );

        return new Book(
            (int) $data['id'],
            $data['title'],
            $data['author'],
            $data['description'],
            $data['image'],
            new \DateTime($data['created_at']),
            $user,
        );
    }
}
