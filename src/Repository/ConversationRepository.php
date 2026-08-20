<?php

namespace App\Repository;

use App\Repository\AbstractRepository;
use App\Models\Conversation;

class ConversationRepository extends AbstractRepository
{

    public function getConversationByUsersIds(int $user1Id, int $user2Id)
    {
        $query = "
            SELECT *
            FROM conversations
            WHERE (user1_id = :user1 AND user2_id = :user2)
                OR (user1_id = :user2 AND user2_id = :user1)
            LIMIT 1
        ";

        $data = $this->executeOne($query, [
            'user1' => $user1Id,
            'user2' => $user2Id,
        ]);

        if (!$data) {
            return null;
        }

        return new Conversation(
            $data['id'],
            $data['user1_id'],
            $data['user2_id'],
            new \DateTime($data['created_at'])
        );
    }

    public function insert(int $user1Id, int $user2Id)
    {
        $query = "
            INSERT INTO conversations (user1_id, user2_id)
            VALUES (:user1Id, :user2Id)
        ";

        $this->execute($query, [
            'user1Id' => $user1Id,
            'user2Id' => $user2Id,
        ]);

        return (int) $this->pdo->lastInsertId();
    }
}