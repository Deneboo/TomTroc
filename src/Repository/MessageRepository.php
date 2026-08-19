<?php

namespace App\Repository;

use App\Repository\AbstractRepository;
use App\Models\Message;
use App\Models\User;

class MessageRepository extends AbstractRepository
{
    public function getAllLatestMessagesByUserId(int $userId): array
    {
        $query = "
        SELECT
        conversations.*,
        interlocuteur.id AS interlocuteur_id,
        interlocuteur.username AS interlocuteur_username,
        interlocuteur.avatar AS interlocuteur_avatar
        FROM (
        SELECT
        messages.*,
        ROW_NUMBER() OVER (
            PARTITION BY
                LEAST(sender_id, receiver_id),
                GREATEST(sender_id, receiver_id)
            ORDER BY created_at DESC
        ) AS message_number

            FROM messages

            WHERE sender_id = :userId
            OR receiver_id = :userId

        ) AS conversations
        INNER JOIN users interlocuteur
            ON interlocuteur.id = CASE
                WHEN conversations.sender_id = :userId
                THEN conversations.receiver_id
                ELSE conversations.sender_id
            END
        WHERE message_number = 1
        ORDER BY created_at DESC
        ";

        $rows = $this->executeAll($query, [
            'userId' => $userId,
        ]);
        $messages = [];
        $interlocuteur = []; 

        foreach ($rows as $data) {
            // if ((int) $data['sender_id'] === $userId) {
            //     $interlocuteurId = (int) $data['receiver_id'];
            //     $interlocuteurUsername = $data['receiver_username'];
            //     $interlocuteurAvatar = $data['receiver_avatar'];
            // } else {
            //     $interlocuteurId = (int) $data['sender_id'];
            //     $interlocuteurUsername = $data['sender_username'];
            //     $interlocuteurAvatar = $data['sender_avatar'];
            // }

            $interlocuteur = new User(
                $data['interlocuteur_id'],
                $data['interlocuteur_username'],
                '',
                '',
                '',
                new \DateTime($data['created_at']),
            );


            $messages[] = new Message(
                (int) $data['id'],
                $data['message'],
                $interlocuteur ? $interlocuteur : [],
                $interlocuteur ? $interlocuteur : [],
                new \DateTime($data['created_at']),
                $data['book_id'] !== null ? (int) $data['book_id'] : null
            );
        }

        return [
            'messages' => $messages,
            'interlocuteur' => $interlocuteur,
        ];
    }

    public function getAllMessageFromOneConversation(int $userId): array 
    {
        $query = "
            SELECT messages.* 
            FROM messages 
            WHERE (sender_id, receiver_id) IN ((16, 18), (18, 16))
            ORDER BY messages.created_at DESC;
        ";

        $rows = $this->executeAll($query, [
            'userId' => $userId,
        ]);
        $messages = [];

        foreach ($rows as $data) {
            $messages[] = new Message(
                (int) $data['id'],
                $data['message'],
                $data['receiver_id'],
                $data['sender_id'],
                new \DateTime($data['created_at']),
                $data['book_id']
            );
        }

        return $messages;
    }
}