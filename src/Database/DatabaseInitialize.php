<?php

namespace App\Database;

use PDO;
use App\Database\DBConnect;
use App\Database\Fixtures\UserFixtures;
use App\Database\Fixtures\BookFixtures;

class DatabaseInitialize
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DBConnect::getInstance()->getConnection();
    }

    public function createTable(): void
    {
        $createUsersTable = "
            CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                username VARCHAR(255) NOT NULL UNIQUE,
                avatar VARCHAR(255) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci;
        ";

        $this->pdo->exec($createUsersTable);

        $createBooksTable = "
            CREATE TABLE IF NOT EXISTS books (
                id INT AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                author VARCHAR(255) NOT NULL,
                description TEXT,
                image VARCHAR(255) DEFAULT NULL,
                user_id INT NOT NULL,
                is_available BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id)
            ) ENGINE=InnoDB
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci;
        ";

        $this->pdo->exec($createBooksTable);

        $createMessagesTable = "
            CREATE TABLE IF NOT EXISTS messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                message TEXT NOT NULL,
                sender_id INT NOT NULL,
                receiver_id INT NOT NULL,
                book_id INT DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (sender_id) REFERENCES users(id),
                FOREIGN KEY (receiver_id) REFERENCES users(id),
                FOREIGN KEY (book_id) REFERENCES books(id)
            ) ENGINE=InnoDB
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci;
        ";

        $this->pdo->exec($createMessagesTable);
    }

    public function seed(): void
    {
        $count = $this->pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();

        if ($count > 0) {
            return;
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO users (email, password, username, avatar)
            VALUES (:email, :password, :username, :avatar)
        ");

        foreach (UserFixtures::getData() as $user) {
            $stmt->execute($user);
        }

        $users = [];

        $query = $this->pdo->query("SELECT id, username FROM users");

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $users[$row['username']] = $row['id'];
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO books (title, author, description, image, user_id)
            VALUES (:title, :author, :description, :image, :user_id)
        ");

        foreach (BookFixtures::getData() as $book) {
            $stmt->execute([
                'title'       => $book['title'],
                'author'      => $book['author'],
                'description' => $book['description'],
                'image'       => $book['image'],
                'user_id'     => $users[$book['seller']],
            ]);
        }
    }

    public function initialize(): void
    {
        $this->createTable();
        $this->seed();
    }
}
