<?php

namespace App\Repository;

use App\models\User;

class UserRepository extends AbstractRepository
{
    public function insert(User $user): bool
    {
        $query = "
            INSERT INTO users 
            (username, email, password, avatar)
            VALUES
            (:username, :email, :password, :avatar)
        ";
        return $this->execute($query, [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'avatar' => $user->getAvatar(),
        ]);
    }

    public function findUserByEmail(string $userEmail)
    {
        $query = "
            SELECT *
            FROM users
            WHERE users.email = :user_email
        ";

        $data = $this->executeOne($query, [
            'user_email' => $userEmail,
        ]);

        if (!$data) {
            return null;
        }

        return new User(
            (int) $data['id'],
            $data['username'],
            $data['email'],
            $data['password'],
            $data['avatar'],
            new \DateTime($data['created_at']),
        );
    }

    public function findByEmailOrUsername(string $userEmail, string $username): ?User
    {
        $query = "SELECT * FROM users WHERE users.email = :user_email OR username = :username LIMIT 1";
        $data = $this->executeOne($query, [
            'user_email' => $userEmail,
            'username' => $username,
        ]);

        if ($data) {
            return new User(
                $data['id'],
                $data['username'],
                $data['email'],
                $data['password'],
                $data['avatar'],
                new \DateTime($data['created_at']),
            );
        }

        return null;
    }

    public function findUserById(int $userId)
    {
        $query = "
            SELECT *
            FROM users
            WHERE users.id = :id
        ";

        $data = $this->executeOne($query, [
            'id' => $userId,
        ]);

        if (!$data) {
            return null;
        }

        return new User(
            (int) $data['id'],
            $data['username'],
            $data['email'],
            $data['password'],
            $data['avatar'],
            new \DateTime($data['created_at']),
        );
    }

    public function update(User $user): bool
    {
        $query = "
            UPDATE users
            SET username = :username,
                email = :email,
                password = :password,
                avatar = :avatar
            WHERE id = :id
        ";

        return $this->execute($query, [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'avatar' => $user->getAvatar(),
        ]);
    }

    public function findByUserId(int $userId): array
    {
        return $this->executeAll(
            "
            SELECT
                books.*,
                users.username,
                users.email
            FROM books
            INNER JOIN users
                ON books.user_id = users.id
            WHERE users.id = :user_id
            ORDER BY books.created_at DESC
            ",
            [
                'user_id' => $userId,
            ],
        );
    }

}
