<?php

namespace App\Repository;

use App\Repository\AbstractRepository;
use App\Models\Message;
use App\Models\User;

class MessageRepository extends AbstractRepository
{
    public function getAllLatestMessagesForOneUser(int $userId, User $user)
    {
        $query = "
                SELECT c.*, 
                    m.id AS message_id,
                    m.message AS message_text,
                    m.sender_id AS sender_id,
                    m.receiver_id AS receiver_id,
                    m.book_id AS message_book_id,
                    interlocuteur.id AS interlocuteur_id,
                    interlocuteur.username AS interlocuteur_username,
                    interlocuteur.avatar AS interlocuteur_avatar
                FROM conversations c
                INNER JOIN messages m
                    ON m.conversation_id = c.id
                INNER JOIN (
                    SELECT conversation_id, MAX(created_at) AS last_created_at
                    FROM messages
                    GROUP BY conversation_id
                ) last_message
                    ON last_message.conversation_id = m.conversation_id
                    AND last_message.last_created_at = m.created_at
                INNER JOIN users interlocuteur
                    ON (
                        (c.user1_id = :user_id AND interlocuteur.id = c.user2_id)
                        OR
                        (c.user2_id = :user_id AND interlocuteur.id = c.user1_id)
                    )
                WHERE c.user1_id = :user_id
                    OR c.user2_id = :user_id
                ORDER BY m.created_at DESC;
            ";

        $rows = $this->executeAll($query, [
            'user_id' => $userId,
        ]);

        if (!$rows) {
            return null;
        }

        $messages = [];

        foreach ($rows as $data) {
            $interlocuteur = new User(
                (int) $data['interlocuteur_id'],
                $data['interlocuteur_username'],
                '',
                '',
                $data['interlocuteur_avatar'],
                new \DateTime($data['created_at']),
            );

            $sender = (int) $data['sender_id'] === $userId
                ? $user
                : $interlocuteur;
            $receiver = (int) $data['receiver_id'] === $userId
                ? $user
                : $interlocuteur;

            $message = new Message(
                (int) $data['message_id'],
                $data['message_text'],
                $sender,
                $receiver,
                new \DateTime($data['created_at']),
                $data['message_book_id'] !== null ? (int) $data['message_book_id'] : null,
            );

            $messages[] = [
                'message' => $message,
                'interlocuteur' => $interlocuteur,
            ];
        }

        return  $messages;
    }

    public function getOneConversation(int $userId, int $interlocuteurId)
    {
        $query = "
                SELECT id
                FROM conversations
                WHERE (user1_id = :userId AND user2_id = :interlocutorId)
                OR (user1_id = :interlocutorId AND user2_id = :userId)
            ";

        $data = $this->executeOne($query, ['userId' => $userId, 'interlocutorId' => $interlocuteurId]);

        // $data is an array because unhydrated.
        return $data;
    }

    public function getAllMessageFromAConversation(int $conversationId)
    {
        $query = "
            SELECT
                messages.*,
                sender.id AS sender_id,
                sender.email AS sender_email,
                sender.username AS sender_username,
                sender.avatar AS sender_avatar,
                receiver.id AS receiver_id,
                receiver.email AS receiver_email,
                receiver.username AS receiver_username,
                receiver.avatar AS receiver_avatar
            FROM messages
            INNER JOIN users AS sender
                ON messages.sender_id = sender.id
            INNER JOIN users AS receiver
                ON messages.receiver_id = receiver.id
            WHERE messages.conversation_id = :conversationId
        ";

        $rows = $this->executeAll($query, ['conversationId' => $conversationId]);
        $messages = [];

        foreach ($rows as $data) {
            $sender = new User(
                (int) $data['sender_id'],
                $data['sender_email'],
                $data['sender_username'],
                '',
                $data['sender_avatar'],
                new \DateTime($data['created_at']),
            );

            $receiver = new User(
                (int) $data['receiver_id'],
                $data['receiver_email'],
                $data['receiver_username'],
                '',
                $data['receiver_avatar'],
                new \DateTime($data['created_at']),
            );

            $message = new Message(
                (int) $data['message'],
                $data['message'],
                $sender,
                $receiver,
                new \DateTime($data['created_at']),
                $data['book_id'] !== null ? (int) $data['book_id'] : null,
            );
            $messages[] = $message;
        }

        return $messages;
    }

    public function insert(string $message, int $senderId, int $receiverId, int $conversationId): int
    {
        $query = "
            INSERT INTO messages (message, sender_id, receiver_id, conversation_id)
            VALUES (:message, :senderId, :receiverId, :conversationId)
        ";

        $this->execute($query, [
            'message' => $message,
            'senderId' => $senderId,
            'receiverId' => $receiverId,
            'conversationId' => $conversationId,
        ]);
        $id = (int) $this->pdo->lastInsertId();

        return $id;
    }
}
