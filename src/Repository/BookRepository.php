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
                new \DateTime($data['created_at']),
                $user,
                (bool) $data['is_available'],
                $data['image'],
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
            new \DateTime($data['created_at']),
            $user,
            $data['is_available'] === 1 ? true : false,
            $data['image'],
        );
    }

    public function searchByTitle(string $title): array
    {
        $query = " 
            SELECT 
                books.*,
                users.username,
                users.email,
                users.avatar
            FROM books
            LEFT JOIN users
                ON books.user_id = users.id
            WHERE books.title LIKE :title
            ORDER BY books.created_at DESC
        ";

        $rows = $this->executeAll(
            $query,
            [
                'title' => '%' . $title . '%',
            ],
        );

        $books = [];

        foreach ($rows as $data) {
            $user = new User(
                (int) $data['user_id'],
                $data['username'],
                '',
                '',
                $data['avatar'],
                new \DateTime($data['created_at']),
            );

            $books[] = new Book(
                (int) $data['id'],
                $data['title'],
                $data['author'],
                $data['description'],
                new \DateTime($data['created_at']),
                $user,
                (bool) $data['is_available'],
                $data['image']
            );
        }
        return $books;
    }

    public function insert(Book $book): int
    {
        $query = "
            INSERT INTO books (title, author, description, image, user_id, is_available)
            VALUES (:title, :author, :description, :image, :user_id, :is_available)
        ";

        $this->execute($query, [
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'description' => $book->getDescription(),
            'image' => $book->getImage(),
            'user_id' => $book->getUser()->getId(),
            'is_available' => $book->isAvailable() ? 1 : 0,
        ]);
        $id = (int) $this->pdo->lastInsertId();

        return $id;
    }

    public function update(Book $book): bool
    {
        $query = "
            UPDATE books
            SET title = :title,
                author = :author,
                description = :description,
                image = :image,
                is_available = :is_available
            WHERE id = :id
        ";

        return $this->execute($query, [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'description' => $book->getDescription(),
            'image' => $book->getImage(),
            'is_available' => $book->isAvailable() ? 1 : 0,
        ]);
    }

    public function delete(int $id): bool
    {
        $query = "
            DELETE FROM books
            WHERE id = :id
        ";

        return $this->execute($query, [
            'id' => $id,
        ]);
    }
}
