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

    public function createDatabase(): void
    {
        $createTomTrocBD = "
            CREATE DATABASE IF NOT EXISTS `tom_troc`
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
        ";

        $this->pdo->exec($createTomTrocBD);

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
                CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) 
            ENGINE=InnoDB
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci;
        ";

        $this->pdo->exec($createBooksTable);

        $createConversationsTable = "
            CREATE TABLE  IF NOT EXISTS conversations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user1_id INT NOT NULL,
                user2_id INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_conversations_user1 FOREIGN KEY (user1_id) REFERENCES users(id),
                CONSTRAINT fk_conversations_user2 FOREIGN KEY (user2_id) REFERENCES users(id),
                CONSTRAINT uq_conversations_users UNIQUE (user1_id, user2_id),
                CONSTRAINT chk_conversations_different_users CHECK (user1_id <> user2_id)
            )
            ENGINE=InnoDB
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
            ";

        $this->pdo->exec($createConversationsTable);

        $createMessagesTable = "
            CREATE TABLE IF NOT EXISTS messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                conversation_id INT NOT NULL,
                message TEXT NOT NULL,
                sender_id INT NOT NULL,
                receiver_id INT NOT NULL,
                book_id INT DEFAULT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_conversation FOREIGN KEY (conversation_id) REFERENCES conversations(id) ON DELETE CASCADE,
                CONSTRAINT fk_sender FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
                CONSTRAINT fk_receiver FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
                CONSTRAINT fk_book FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE SET NULL
            ) 
            ENGINE=InnoDB
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
            INSERT INTO users (email, password, username, avatar, created_at)
            VALUES (:email, :password, :username, :avatar, :created_at)
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
            INSERT INTO books (title, author, description, image, created_at, user_id)
            VALUES (:title, :author, :description, :image, :created_at, :user_id)
        ");

        foreach (BookFixtures::getData() as $book) {
            $stmt->execute([
                'title'       => $book['title'],
                'author'      => $book['author'],
                'description' => $book['description'],
                'image'       => $book['image'],
                'created_at'  => $book['created_at'],
                'user_id'     => $users[$book['seller']],
            ]);
        }
    }

    public function initialize(): void
    {
        $this->createDatabase();
        $this->seed();
    }
}
